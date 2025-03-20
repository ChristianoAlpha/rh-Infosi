<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employeee;
use App\Models\VacationRequest;
use App\Models\LeaveRequest;

class DepartmentHeadController extends Controller
{
    // Exibir lista de funcionários do departamento do chefe
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

    // ========================
    // PEDIDOS DE FÉRIAS
    // ========================

    // Exibir lista de pedidos de férias pendentes dos funcionários do departamento
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

    // Aprovar um pedido de férias
    public function approveVacation($id)
    {
        $user = Auth::user();
        if ($user->role !== 'department_head') {
            abort(403, 'Acesso negado.');
        }

        $vacation = VacationRequest::findOrFail($id);

        // Verifica se o pedido pertence ao mesmo departamento do chefe
        if (!$vacation->employee || $vacation->employee->departmentId !== $user->employee->departmentId) {
            abort(403, 'Você não pode aprovar pedidos de outro departamento.');
        }

        $vacation->approvalStatus = 'Aprovado';
        $vacation->approvalComment = request('approvalComment') ?? 'Aprovado pelo chefe';
        $vacation->save();

        return redirect()->route('dh.pendingVacations')
            ->with('msg', 'Pedido de férias aprovado com sucesso!');
    }

    // Rejeitar um pedido de férias
    public function rejectVacation($id)
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
        $vacation->approvalComment = request('approvalComment') ?? 'Recusado pelo chefe';
        $vacation->save();

        return redirect()->route('dh.pendingVacations')
            ->with('msg', 'Pedido de férias rejeitado com sucesso!');
    }

    // ========================
    // PEDIDOS DE LICENÇA
    // ========================

    // Exibir lista de pedidos de licença pendentes dos funcionários do departamento
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

    // Aprovar um pedido de licença
    public function approveLeave($id)
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
        $leave->approvalComment = request('approvalComment') ?? 'Aprovado pelo chefe';
        $leave->save();

        return redirect()->route('dh.pendingLeaves')
            ->with('msg', 'Pedido de licença aprovado com sucesso!');
    }

    // Rejeitar um pedido de licença
    public function rejectLeave($id)
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
        $leave->approvalComment = request('approvalComment') ?? 'Recusado pelo chefe';
        $leave->save();

        return redirect()->route('dh.pendingLeaves')
            ->with('msg', 'Pedido de licença rejeitado com sucesso!');
    }
}
