<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employeee;
use App\Models\VacationRequest;

class DepartmentHeadController extends Controller
{
    // Exibir lista de funcionários do departamento do Chefe
    public function myEmployees()
    {
        // Pega o usuário logado (Admin ou User)
        $user = Auth::user();
        // Garante que seja department_head
        if ($user->role !== 'department_head') {
            abort(403, 'Acesso negado.');
        }

        // Pega o Employee vinculado
        $headEmployee = $user->employee; 
        if (!$headEmployee) {
            return redirect()->back()->withErrors(['msg' => 'Chefe não vinculado a nenhum funcionário.']);
        }

        // Pega o departamento do Chefe
        $departmentId = $headEmployee->departmentId;

        // Puxa todos os funcionários daquele departamento
        $employees = Employeee::where('departmentId', $departmentId)->orderBy('fullName')->get();

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

        // Buscamos todos os VacationRequests pendentes, 
        // cujos funcionários são do mesmo departamento
        $pendingRequests = VacationRequest::where('status', 'pending')
            ->whereHas('employee', function($q) use ($departmentId) {
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

        // Verifica se o vacationRequest pertence ao departamento do chefe
        if ($vacation->employee->departmentId !== $user->employee->departmentId) {
            abort(403, 'Você não pode aprovar pedidos de outro departamento.');
        }

        $vacation->status = 'approved';
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

        $vacation->status = 'rejected';
        $vacation->save();

        return redirect()->route('dh.pendingVacations')
            ->with('msg', 'Pedido de férias rejeitado com sucesso!');
    }
}
