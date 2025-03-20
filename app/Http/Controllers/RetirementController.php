<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retirement;
use App\Models\Employeee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RetirementController extends Controller
{
    /**
     * Exibe a lista de pedidos de reforma.
     * - Funcionário vê apenas o seu pedido.
     * - Admin/Diretor vê todos.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'employee') {
            $employeeId = $user->employee->id ?? null;
            $retirements = Retirement::where('employeeId', $employeeId)
                ->orderByDesc('id')
                ->get();
        } else {
            $retirements = Retirement::with('employee')
                ->orderByDesc('id')
                ->get();
        }
        return view('retirement.index', compact('retirements'));
    }

    
    public function create()
    {
        $user = Auth::user();
        if (in_array($user->role, ['admin', 'director'])) {
            return view('retirement.createSearch');
        } else {
            $employee = $user->employee;
            return view('retirement.createEmployee', compact('employee'));
        }
    }

    /**
     * Busca funcionário por ID ou Nome – para admin/diretor.
     */
    public function searchEmployee(Request $request)
    {
        $request->validate([
            'employeeSearch' => 'required|string',
        ]);

        $term = $request->employeeSearch;
        $employee = Employeee::where('id', $term)
            ->orWhere('fullName', 'LIKE', "%$term%")
            ->first();

        if (!$employee) {
            return redirect()->back()
                ->withErrors(['employeeSearch' => 'Funcionário não encontrado!'])
                ->withInput();
        }

        return view('retirement.createSearch', ['employee' => $employee]);
    }

  
    public function store(Request $request)
    {
        $user = Auth::user();

        // Se o usuário for funcionário, usamos o próprio ID; caso contrário, esperamos que o form envie employeeId.
        if ($user->role === 'employee') {
            $employeeId = $user->employee->id ?? null;
        } else {
            $request->validate([
                'employeeId' => 'required|exists:employeees,id',
            ]);
            $employeeId = $request->employeeId;
        }

        $request->validate([
            'requestDate'    => 'nullable|date',
            'retirementDate' => 'nullable|date|after_or_equal:requestDate',
            'status'         => 'required|in:Pendente,Aprovado,Rejeitado',
            'observations'   => 'nullable|string',
        ]);

        $data = $request->all();
        $data['employeeId'] = $employeeId;
        if (empty($data['requestDate'])) {
            $data['requestDate'] = Carbon::now()->format('Y-m-d');
        }

        Retirement::create($data);

        // Atualiza o status do funcionário para Aposentado(retired)
        $employee = Employeee::find($employeeId);
        if ($employee) {
            $employee->employmentStatus = 'retired';
            $employee->save();
        }

        return redirect()->route('retirements.index')
                         ->with('msg', 'Pedido de reforma registrado com sucesso.');
    }


    public function show($id)
    {
        $retirement = Retirement::with('employee')->findOrFail($id);
        return view('retirement.show', compact('retirement'));
    }

    public function edit($id)
    {
        $retirement = Retirement::findOrFail($id);
        return view('retirement.edit', compact('retirement'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'requestDate'    => 'nullable|date',
            'retirementDate' => 'nullable|date|after_or_equal:requestDate',
            'status'         => 'required|in:Pendente,Aprovado,Rejeitado',
            'observations'   => 'nullable|string',
        ]);

        $retirement = Retirement::findOrFail($id);
        $data = $request->all();
        $retirement->update($data);

        // Se o status for aprovado, atualiza o funcionário para "retired"
        if (strtolower($data['status']) === 'aprovado') {
            $employee = Employeee::find($retirement->employeeId);
            if ($employee) {
                $employee->employmentStatus = 'retired';
                $employee->save();
            }
        }

        return redirect()->route('retirements.index')
                         ->with('msg', 'Pedido de reforma atualizado com sucesso.');
    }

   
    public function destroy($id)
    {
        $retirement = Retirement::findOrFail($id);
        $employeeId = $retirement->employeeId;
        $retirement->delete();

        //caso o pedido seja removido, podemos atualizar o status do funcionário para Ativo(active) novamente
        $employee = Employeee::find($employeeId);
        if ($employee) {
            $employee->employmentStatus = 'active';
            $employee->save();
        }

        return redirect()->route('retirements.index')
                         ->with('msg', 'Pedido de reforma removido com sucesso.');
    }
}
