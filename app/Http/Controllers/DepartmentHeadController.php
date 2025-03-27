<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Employeee;
use App\Models\VacationRequest;
use App\Models\LeaveRequest;
use App\Models\Retirement;
use Carbon\Carbon;
use App\Mail\VacationResponseNotification;
use App\Mail\LeaveResponseNotification;
use App\Mail\RetirementResponseNotification;

class DepartmentHeadController extends Controller
{
    // Lista os funcionários do departamento do chefe
    public function myEmployees()
    {
        $user = Auth::user();
        if ($user->role !== 'department_head') {
            abort(403, 'Acesso negado. Só os Chefes de Departamentos têm acesso a esta página.');
        }
        $headEmployee = $user->employee;
        if (!$headEmployee) {
            return redirect()->back()->withErrors(['msg' => 'Chefe não vinculado a nenhum funcionário.']);
        }
        $departmentId = $headEmployee->departmentId;
        $employees = Employeee::where('departmentId', $departmentId)
            ->orderBy('fullName')
            ->get();
        return view('departmentHead.myEmployees', compact('employees'));
    }

    // ------------------- PEDIDOS DE FÉRIAS -------------------

    // Exibe lista de pedidos de férias pendentes
    public function pendingVacations()
    {
        $user = Auth::user();
        if ($user->role !== 'department_head') {
            abort(403, 'Acesso negado.');
        }
        $headEmployee = $user->employee;
        if (!$headEmployee) {
            return redirect()->back()->withErrors(['msg' => 'Chefe não vinculado a nenhum funcionário.']);
        }
        $departmentId = $headEmployee->departmentId;
        $pendingRequests = VacationRequest::where('approvalStatus', 'Pendente')
            ->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('departmentId', $departmentId);
            })
            ->orderByDesc('id')
            ->get();
        return view('departmentHead.pendingVacationRequests', compact('pendingRequests'));
    }

    // Aprova um pedido de férias e envia e‑mail de notificação
    public function approveVacation($id, Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'department_head') {
            abort(403, 'Acesso negado.');
        }
        $vacation = VacationRequest::findOrFail($id);
        if (!$vacation->employee || $vacation->employee->departmentId !== $user->employee->departmentId) {
            abort(403, 'Você não pode aprovar pedidos de outro departamento.');
        }
        $vacation->approvalStatus = 'Aprovado';
        $vacation->approvalComment = $request->input('approvalComment') ?? 'Aprovado pelo chefe';
        $vacation->save();

        // Dispara e‑mail de resposta ao pedido de férias
        Mail::to($vacation->employee->email)->send(new VacationResponseNotification($vacation));

        return redirect()->route('dh.pendingVacations')
            ->with('msg', 'Pedido de férias aprovado com sucesso!');
    }

    // Rejeita um pedido de férias e envia e‑mail de notificação
    public function rejectVacation($id, Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'department_head') {
            abort(403, 'Acesso negado.');
        }
        $vacation = VacationRequest::findOrFail($id);
        if (!$vacation->employee || $vacation->employee->departmentId !== $user->employee->departmentId) {
            abort(403, 'Você não pode rejeitar pedidos de outro departamento.');
        }
        $vacation->approvalStatus = 'Recusado';
        $vacation->approvalComment = $request->input('approvalComment') ?? 'Recusado pelo chefe';
        $vacation->save();

        // Dispara e‑mail de resposta ao pedido de férias
        Mail::to($vacation->employee->email)->send(new VacationResponseNotification($vacation));

        return redirect()->route('dh.pendingVacations')
            ->with('msg', 'Pedido de férias rejeitado com sucesso!');
    }

    // ------------------- PEDIDOS DE LICENÇA -------------------


    public function pendingLeaves()
    {
        $user = Auth::user();
        if ($user->role !== 'department_head') {
            abort(403, 'Acesso negado.');
        }
        $headEmployee = $user->employee;
        if (!$headEmployee) {
            return redirect()->back()->withErrors(['msg' => 'Chefe não vinculado a nenhum funcionário.']);
        }
        $departmentId = $headEmployee->departmentId;
        $pendingLeaveRequests = LeaveRequest::where('approvalStatus', 'Pendente')
            ->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('departmentId', $departmentId);
            })
            ->orderByDesc('id')
            ->get();
        return view('departmentHead.pendingLeaveRequests', compact('pendingLeaveRequests'));
    }

   
    public function approveLeave($id, Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'department_head') {
            abort(403, 'Acesso negado.');
        }
        $leave = LeaveRequest::findOrFail($id);
        if (!$leave->employee || $leave->employee->departmentId !== $user->employee->departmentId) {
            abort(403, 'Você não pode aprovar pedidos de outro departamento.');
        }
        $leave->approvalStatus = 'Aprovado';
        $leave->approvalComment = $request->input('approvalComment') ?? 'Aprovado pelo chefe';
        $leave->save();


        Mail::to($leave->employee->email)->send(new LeaveResponseNotification($leave));

        return redirect()->route('dh.pendingLeaves')
            ->with('msg', 'Pedido de licença aprovado com sucesso!');
    }

    public function rejectLeave($id, Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'department_head') {
            abort(403, 'Acesso negado.');
        }
        $leave = LeaveRequest::findOrFail($id);
        if (!$leave->employee || $leave->employee->departmentId !== $user->employee->departmentId) {
            abort(403, 'Você não pode rejeitar pedidos de outro departamento.');
        }
        $leave->approvalStatus = 'Recusado';
        $leave->approvalComment = $request->input('approvalComment') ?? 'Recusado pelo chefe';
        $leave->save();


        Mail::to($leave->employee->email)->send(new LeaveResponseNotification($leave));

        return redirect()->route('dh.pendingLeaves')
            ->with('msg', 'Pedido de licença rejeitado com sucesso!');
    }

    // ------------------- PEDIDOS DE REFORMA (Retirement) -------------------

    public function pendingRetirements()
    {
        $user = Auth::user();
        if ($user->role !== 'department_head') {
            abort(403, 'Acesso negado.');
        }
        $headEmployee = $user->employee;
        if (!$headEmployee) {
            return redirect()->back()->withErrors(['msg' => 'Chefe não vinculado a nenhum funcionário.']);
        }
        $departmentId = $headEmployee->departmentId;
        $pendingRetirements = Retirement::where('status', 'Pendente')
            ->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('departmentId', $departmentId);
            })
            ->orderByDesc('id')
            ->get();
        return view('departmentHead.pendingRetirementRequests', compact('pendingRetirements'));
    }


    public function approveRetirement($id, Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'department_head') {
            abort(403, 'Acesso negado.');
        }
        $retirement = Retirement::findOrFail($id);
        if (!$retirement->employee || $retirement->employee->departmentId !== $user->employee->departmentId) {
            abort(403, 'Você não pode aprovar pedidos de outro departamento.');
        }
        $retirement->status = 'Aprovado';
        $retirement->observations = $request->input('approvalComment') ?? 'Aprovado pelo chefe';
        $retirement->save();

        $employee = $retirement->employee;
        if ($employee) {
            $employee->employmentStatus = 'retired';
            $employee->save();
            Mail::to($employee->email)->send(new RetirementResponseNotification($retirement));
        }
        return redirect()->route('dh.pendingRetirements')
            ->with('msg', 'Pedido de reforma aprovado com sucesso!');
    }


    public function rejectRetirement($id, Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'department_head') {
            abort(403, 'Acesso negado.');
        }
        $retirement = Retirement::findOrFail($id);
        if (!$retirement->employee || $retirement->employee->departmentId !== $user->employee->departmentId) {
            abort(403, 'Você não pode rejeitar pedidos de outro departamento.');
        }
        $retirement->status = 'Rejeitado';
        $retirement->observations = $request->input('approvalComment') ?? 'Rejeitado pelo chefe';
        $retirement->save();

        Mail::to($retirement->employee->email)->send(new RetirementResponseNotification($retirement));

        return redirect()->route('dh.pendingRetirements')
            ->with('msg', 'Pedido de reforma rejeitado com sucesso!');
    }
}
