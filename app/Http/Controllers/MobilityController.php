<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobility;
use App\Models\Employeee;
use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class MobilityController extends Controller
{
    public function index()
    {
        // Carrega todas as mobilidades com os relacionamentos (funcionário, departamento antigo e novo)
        $data = Mobility::with(['employee', 'oldDepartment', 'newDepartment'])
                        ->orderByDesc('id')
                        ->get();
        return view('mobility.index', compact('data'));
    }

    public function create()
    {
        // Para o formulário de criação, precisamos de todos os departamentos
        $departments = Department::all();
        return view('mobility.create', compact('departments'));
    }

    /**
     * Método para buscar um funcionário pelo seu ID.
     * chamaremos via GET para preencher o formulário.
     */
    public function searchEmployee(Request $request)
    {
        $request->validate([
            'employeeId' => 'required|integer',
        ]);

        $employee = Employeee::find($request->employeeId);

        if (!$employee) {
            return redirect()->back()
                ->withErrors(['employeeId' => 'Funcionário não encontrado!'])
                ->withInput();
        }

        // Obtém o departamento atual do funcionário
        $oldDepartment = $employee->department;
        $departments = Department::all();

        return view('mobility.create', [
            'departments'   => $departments,
            'employee'      => $employee,
            'oldDepartment' => $oldDepartment,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employeeId'      => 'required|integer|exists:employeees,id',
            'oldDepartmentId' => 'nullable|integer|exists:departments,id',
            'newDepartmentId' => 'required|integer|exists:departments,id',
            'causeOfMobility' => 'nullable|string',
        ]);

        // Cria o registro de mobilidade
        Mobility::create([
            'employeeId'      => $request->employeeId,
            'oldDepartmentId' => $request->oldDepartmentId,
            'newDepartmentId' => $request->newDepartmentId,
            'causeOfMobility' => $request->causeOfMobility,
        ]);

        // Atualiza o departamento do funcionário
        $employee = Employeee::find($request->employeeId);
        $employee->departmentId = $request->newDepartmentId;
        $employee->save();

        return redirect()->route('mobility.index')
                         ->with('msg', 'Mobilidade registrada com sucesso!');
    }

 
    public function pdfAll()
    {
        $allMobility = Mobility::with(['employee', 'oldDepartment', 'newDepartment'])
                                ->orderByDesc('id')
                                ->get();

        $pdf = PDF::loadView('mobility.mobility_pdf', compact('allMobility'))
                  ->setPaper('a3', 'portrait');

        return $pdf->stream('RelatorioMobilidades.pdf');
    }

    public function destroy($id)
    {
        Mobility::destroy($id);
        return redirect()->route('mobility.index');
    }
}
