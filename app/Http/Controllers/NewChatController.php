<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Employeee;
use App\Models\Department;
use App\Models\ChatGroup;
use App\Models\ChatMessage;
use App\Events\NewChatMessageSent;

class NewChatController extends Controller
{
    /**
     * Exibe a lista de grupos/conversas disponíveis para o usuário.
     */
    public function index()
    {
        $user = Auth::user();
        $groups = collect();

        // --- Caso seja DIRETOR ---
        if ($user->role === 'director') {
            // Grupo “Diretores” (exclusivo)
            $directorGroup = ChatGroup::firstOrCreate(
                ['groupType' => 'directorGroup'],
                ['name' => 'Diretores']
            );
            $groups->push($directorGroup);

            // Opcional: Grupo “Chefes de Departamento” (se diretores devem vê-los)
            $deptHeadsGroup = ChatGroup::firstOrCreate(
                ['groupType' => 'departmentHeadsGroup'],
                ['name' => 'Chefes de Departamento']
            );
            $groups->push($deptHeadsGroup);

            // Conversa individual entre o diretor e cada chefe de departamento
            $heads = Admin::where('role', 'department_head')->get();
            foreach ($heads as $head) {
                if ($head->employee) {
                    $ind = ChatGroup::firstOrCreate(
                        [
                            'groupType'    => 'individual',
                            'departmentId' => $head->department_id, // se houver
                            'headId'       => $head->employee->id
                        ],
                        ['name' => $user->employee->fullName . ' ↔ ' . $head->employee->fullName]
                    );
                    $groups->push($ind);
                }
            }
        }
        // --- Caso seja CHEFE DE DEPARTAMENTO ---
        elseif ($user->role === 'department_head') {
            // Grupo “Chefes de Departamento”
            $deptHeadsGroup = ChatGroup::firstOrCreate(
                ['groupType' => 'departmentHeadsGroup'],
                ['name' => 'Chefes de Departamento']
            );
            $groups->push($deptHeadsGroup);

            // Grupo do Departamento (exibe funcionários do dept + chefe)
            if (!empty($user->department_id)) {
                $departmentGroup = ChatGroup::firstOrCreate(
                    [
                        'groupType'    => 'departmentGroup',
                        'departmentId' => $user->department_id
                    ],
                    ['name' => 'Departamento ' . $this->getDepartmentTitle($user->department_id)]
                );
                $groups->push($departmentGroup);

                // Conversas individuais: Chefe ↔ cada funcionário do departamento
                $employees = Employeee::where('departmentId', $user->department_id)->get();
                foreach ($employees as $emp) {
                    // Evita criar conversa com ele mesmo
                    if ($emp->id != ($user->employee->id ?? 0)) {
                        $ind = ChatGroup::firstOrCreate(
                            [
                                'groupType'    => 'individual',
                                'departmentId' => $user->department_id,
                                'headId'       => $user->employee->id
                            ],
                            ['name' => $emp->fullName . ' ↔ ' . ($user->employee->fullName ?? $user->email)]
                        );
                        $groups->push($ind);
                    }
                }
            }
        }
        // --- Caso seja FUNCIONÁRIO ---
        elseif ($user->role === 'employee') {
            // O funcionário foi criado na tabela 'employeees' com seu departmentId
            $emp = Employeee::find($user->id);
            if ($emp && $emp->departmentId) {
                // Grupo do Departamento
                $departmentGroup = ChatGroup::firstOrCreate(
                    [
                        'groupType'    => 'departmentGroup',
                        'departmentId' => $emp->departmentId
                    ],
                    ['name' => 'Departamento ' . ($emp->department->title ?? '')]
                );
                $groups->push($departmentGroup);

                // Conversa individual com seu chefe
                $headAdmin = Admin::where('role', 'department_head')
                                  ->where('department_id', $emp->departmentId)
                                  ->first();
                if ($headAdmin && $headAdmin->employee) {
                    $ind = ChatGroup::firstOrCreate(
                        [
                            'groupType'    => 'individual',
                            'departmentId' => $emp->departmentId,
                            'headId'       => $headAdmin->employee->id
                        ],
                        ['name' => $emp->fullName . ' ↔ ' . $headAdmin->employee->fullName]
                    );
                    $groups->push($ind);
                }
            }
        }

        $groups = $groups->unique('id')->values();

        // Organiza os grupos por tipo para exibir em abas:
        $directorGroup        = $groups->where('groupType', 'directorGroup');
        $departmentHeadsGroup = $groups->where('groupType', 'departmentHeadsGroup');
        $departmentGroups     = $groups->where('groupType', 'departmentGroup');
        $individuals          = $groups->where('groupType', 'individual');

        return view('new-chat.index', compact(
            'directorGroup',
            'departmentHeadsGroup',
            'departmentGroups',
            'individuals'
        ));
    }

    /**
     * Exibe a conversa específica do grupo
     */
    public function show($groupId)
    {
        $group = ChatGroup::findOrFail($groupId);
        // Valida se o usuário atual pode acessar este grupo
        if (!$this->userCanViewGroup($group)) {
            abort(403, 'Acesso negado a este grupo de chat.');
        }
        $messages = ChatMessage::with('sender')
            ->where('chatGroupId', $groupId)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('new-chat.conversation', compact('group','messages'));
    }

    /**
     * Envia uma mensagem via AJAX e dispara o evento de broadcast
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'chatGroupId' => 'required|exists:chat_groups,id',
            'message'     => 'required|string'
        ]);
        $user = Auth::user();

        $group = ChatGroup::find($request->chatGroupId);
        if (!$group || !$this->userCanViewGroup($group)) {
            return response()->json(['status'=>'forbidden'],403);
        }

        $senderType = in_array($user->role, ['director', 'department_head', 'admin']) 
                        ? 'admin' 
                        : 'employeee';

        $msg = ChatMessage::create([
            'chatGroupId' => $group->id,
            'senderId'    => $user->id,
            'senderType'  => $senderType,
            'message'     => $request->message,
        ]);

        event(new NewChatMessageSent($msg));

        return response()->json(['status'=>'ok']);
    }

    /**
     * Determina se o usuário logado pode visualizar (ou enviar mensagens) em determinado grupo.
     */
    private function userCanViewGroup(ChatGroup $group): bool
    {
        $user = Auth::user();
        // As regras de acesso são:
        // 1) Grupo "directorGroup": somente diretores podem visualizar.
        if ($group->groupType === 'directorGroup') {
            return ($user->role === 'director');
        }
        // 2) Grupo "departmentHeadsGroup": somente chefes de departamento (ou, se desejar, diretores também).
        if ($group->groupType === 'departmentHeadsGroup') {
            return ($user->role === 'department_head');
        }
        // 3) Grupo "departmentGroup": somente se o usuário pertencer ao mesmo departamento.
        if ($group->groupType === 'departmentGroup') {
            if ($user->role === 'department_head' || $user->role === 'admin') {
                return $user->department_id == $group->departmentId;
            } elseif ($user->role === 'employee') {
                $emp = Employeee::find($user->id);
                return ($emp && $emp->departmentId == $group->departmentId);
            }
            return false;
        }
        // 4) Grupo "individual": apenas se o usuário for parte da conversa.
        if ($group->groupType === 'individual') {
            // Regra simples: o usuário deve ter enviado ou recebido alguma mensagem neste grupo.
            $msgs = ChatMessage::where('chatGroupId', $group->id)->get();
            foreach ($msgs as $m) {
                if ($m->senderId == $user->id) {
                    return true;
                }
            }
            return false;
        }
        return false;
    }

    /**
     * Helper para obter o título de um departamento.
     */
    private function getDepartmentTitle($deptId): string
    {
        $dept = Department::find($deptId);
        return $dept ? $dept->title : '';
    }
}
