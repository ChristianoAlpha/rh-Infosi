<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VacationRequest;
use Carbon\Carbon;

class DepartmentHeadController extends Controller
{
    /**
     * Exibe os pedidos de férias pendentes para o departamento do chefe.
     */
    public function pendingVacationRequests()
    {
        // Supondo que o usuário autenticado é um Employeee e que seu cargo está em $user->position->name
        $user = auth()->user();
        if (!$user || $user->position->name !== 'Chefe de Departamento') {
            abort(403, 'Acesso negado.');
        }

        $departmentId = $user->departmentId;
        // Obter os pedidos de férias dos funcionários deste departamento que estão pendentes
        $requests = VacationRequest::with('employee')
            ->whereHas('employee', function ($query) use ($departmentId) {
                $query->where('departmentId', $departmentId);
            })
            ->where('status', 'Pendente')
            ->orderByDesc('created_at')
            ->get();

        return view('departmentHead.pendingVacationRequests', compact('requests'));
    }

    /**
     * Atualiza o status de um pedido de férias.
     */
    public function updateVacationRequestStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Aprovado,Recusado,Pendente',
        ]);

        $vacationRequest = VacationRequest::findOrFail($id);

        // Verifica se o pedido pertence ao departamento do chefe autenticado
        $user = auth()->user();
        if (!$user || $user->position->name !== 'Chefe de Departamento' ||
            $vacationRequest->employee->departmentId != $user->departmentId) {
            abort(403, 'Acesso negado.');
        }

        $vacationRequest->status = $request->status;
        $vacationRequest->save();

        return redirect()->back()->with('msg', 'Status atualizado com sucesso.');
    }
}
