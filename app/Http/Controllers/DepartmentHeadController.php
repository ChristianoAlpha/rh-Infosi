<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employeee;
use App\Models\VacationRequest;

class DepartmentHeadController extends Controller
{
    // Exibir lista de funcionários do departamento do chefe
    public function myEmployees()
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
        $employees = Employeee::where('departmentId', $departmentId)
                                ->orderBy('fullName')
                                ->get();

        return view('departmentHead.myEmployees', compact('employees'));
    }

    // Exibir lista de pedidos pendentes dos funcionários do departamento
    public function pendingVacations()
    {
        $user = Auth::user();
        if ($user->role !== 'department_head') {
            abort(403, 'Acesso negado.');
        }

        $headEmployee = $user->employee;
        $departmentId = $headEmployee->departmentId;

        // Agora usamos 'approvalStatus' para filtrar os pedidos pendentes
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

        // Garante que o pedido pertence ao mesmo departamento do chefe
        if ($vacation->employee->departmentId !== $user->employee->departmentId) {
            abort(403, 'Você não pode aprovar pedidos de outro departamento.');
        }

        $vacation->approvalStatus = 'Aprovado';
        // Se houver comentário enviado via formulário (opcional), atualizamos; caso contrário, usamos um padrão
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

        if ($vacation->employee->departmentId !== $user->employee->departmentId) {
            abort(403, 'Você não pode rejeitar pedidos de outro departamento.');
        }

        $vacation->approvalStatus = 'Recusado';
        $vacation->approvalComment = request('approvalComment') ?? 'Recusado pelo chefe';
        $vacation->save();

        return redirect()->route('dh.pendingVacations')
            ->with('msg', 'Pedido de férias rejeitado com sucesso!');
    }
}
