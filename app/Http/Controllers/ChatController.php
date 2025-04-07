<?php

// app/Http/Controllers/ChatController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatGroup;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $groups = collect();

        // 1) Grupo de Diretores
        if ($user->role === 'director' && $user->employee) {
            $g = ChatGroup::firstOrCreate(
                ['groupType'=>'directorGroup'],
                ['name'=>'Diretores']
            );
            $groups->push($g);
            // individuais onde ele é head
            $inds = ChatGroup::where('groupType','individual')
                ->where('headId',$user->employee->id)
                ->get();
            $groups = $groups->merge($inds);
        }

        // 2) Grupo do Departamento
        if ($user->employee && $user->employee->departmentId) {
            $g = ChatGroup::firstOrCreate(
                [
                  'groupType'=>'departmentGroup',
                  'departmentId'=>$user->employee->departmentId
                ],
                ['name'=>'Departamento '.$user->employee->department->title]
            );
            $groups->push($g);
        }

        // 3) Conversa funcionário ↔ chefe
        if ($user->role==='employee' && $user->employee->departmentId) {
            $head = \App\Models\Admin::where('role','department_head')
                ->where('department_id',$user->employee->departmentId)
                ->first();
            if ($head && $head->employee) {
                $g = ChatGroup::firstOrCreate(
                  [
                    'groupType'=>'individual',
                    'departmentId'=>$user->employee->departmentId,
                    'headId'=>$head->employee->id
                  ],
                  ['name'=>$user->employee->fullName.' ↔ '.$head->employee->fullName]
                );
                $groups->push($g);
            }
        }

        // 4) Se for chefe de dept., pega as individuais
        if ($user->role==='department_head' && $user->employee) {
            $inds = ChatGroup::where('groupType','individual')
                ->where('headId',$user->employee->id)
                ->get();
            $groups = $groups->merge($inds);
        }

        $groups = $groups->unique('id')->values();
        // separa
        $directorGroup    = $groups->where('groupType','directorGroup');
        $departmentGroups = $groups->where('groupType','departmentGroup');
        $individuals      = $groups->where('groupType','individual');

        return view('chat.index', compact('directorGroup','departmentGroups','individuals'));
    }

    public function show($groupId)
    {
        $group    = ChatGroup::findOrFail($groupId);
        $messages = ChatMessage::with('sender')
                     ->where('chatGroupId',$groupId)
                     ->orderBy('created_at')
                     ->get();
        return view('chat.conversation', compact('group','messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'chatGroupId'=>'required|exists:chat_groups,id',
            'message'    =>'required|string',
        ]);

        $user = Auth::user();
        $msg = ChatMessage::create([
            'chatGroupId'=>$request->chatGroupId,
            'senderId'   =>$user->id,
            'senderType' =>$user->role==='admin'?'admin':'employeee',
            'message'    =>$request->message,
        ]);

        event(new \App\Events\ChatMessageSent($msg));
        return response()->json(['status'=>'ok']);
    }
}
