<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VacationRequest;
use App\Models\Employeee;
use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;

class VacationRequestController extends Controller
{
    // Lista todos os pedidos de férias
    public function index()
    {
        $data = VacationRequest::with(['employee', 'department'])
                    ->orderByDesc('id')
                    ->get();
        return view('vacationRequest.index', compact('data'));
    }

    // Exibe o formulário para criar um novo pedido de férias
    public function create()
    {
        $departments = Department::all();
        // Opções fixas para o tipo de férias
        $vacationTypes = ['15 dias','30 dias','22 dias úteis','11 dias úteis'];
        return view('vacationRequest.create', compact('vacationTypes', 'employee'));

    }

    // Pesquisa um funcionário por ID ou parte do nome
    public function searchEmployee(Request $request)
    {
        $search = $request->input('employeeSearch');
        if (is_numeric($search)) {
            $employee = Employeee::find($search);
        } else {
            $employee = Employeee::where('fullName', 'like', '%'.$search.'%')->first();
        }

        if (!$employee) {
            return redirect()->back()
                ->withErrors(['employeeSearch' => 'Funcionário não encontrado!'])
                ->withInput();
        }

        $departments = Department::all();
        $vacationTypes = ['15 dias', '30 dias', '22 dias úteis', '11 dias úteis'];

        return view('vacationRequest.create', compact('departments', 'vacationTypes', 'employee'));
    }

    // Armazena o pedido de férias
    public function store(Request $request)
    {
        $request->validate([
            'employeeId'    => 'required|integer|exists:employeees,id',
            'vacationType'  => 'required|in:15 dias,30 dias,22 dias úteis,11 dias úteis',
            'vacationStart' => 'required|date',
            'vacationEnd'   => 'required|date|after_or_equal:vacationStart',
        ]);

        // Aqui optamos por usar o departamento atual do funcionário como referência
        $employee = Employeee::find($request->employeeId);
        $departmentId = $employee->departmentId;

        VacationRequest::create([
            'employeeId'    => $request->employeeId,
            'departmentId'  => $departmentId,
            'vacationType'  => $request->vacationType,
            'vacationStart' => $request->vacationStart,
            'vacationEnd'   => $request->vacationEnd,
        ]);

        return redirect()->route('vacationRequest.index')
                         ->with('msg', 'Pedido de férias registrado com sucesso!');
    }

    // Exibe os detalhes de um pedido (opcional)
    public function show($id)
    {
        $data = VacationRequest::with(['employee', 'department'])->findOrFail($id);
        return view('vacationRequest.show', compact('data'));
    }

    // Exibe o formulário para editar um pedido
    public function edit($id)
    {
        $data = VacationRequest::findOrFail($id);
        $departments = Department::all();
        $vacationTypes = ['15 dias', '30 dias', '22 dias úteis', '11 dias úteis'];
        return view('vacationRequest.edit', compact('data', 'departments', 'vacationTypes'));
    }

    // Atualiza um pedido de férias
    public function update(Request $request, $id)
    {
        $request->validate([
            'vacationType'  => 'required|in:15 dias,30 dias,22 dias úteis,11 dias úteis',
            'vacationStart' => 'required|date',
            'vacationEnd'   => 'required|date|after_or_equal:vacationStart',
        ]);

        $vacationRequest = VacationRequest::findOrFail($id);
        $vacationRequest->vacationType = $request->vacationType;
        $vacationRequest->vacationStart = $request->vacationStart;
        $vacationRequest->vacationEnd = $request->vacationEnd;
        $vacationRequest->save();

        return redirect()->route('vacationRequest.edit', $id)
                         ->with('msg', 'Pedido de férias atualizado com sucesso!');
    }

    // Remove um pedido de férias
    public function destroy($id)
    {
        VacationRequest::destroy($id);
        return redirect()->route('vacationRequest.index')->with('msg', 'Pedido de férias excluído com sucesso!');
    }

    // Gera o PDF com todos os pedidos de férias
    public function pdfAll()
    {
        $allVacationRequests = VacationRequest::with(['employee', 'department'])->get();
        $pdf = PDF::loadView('vacationRequest.vacationRequest_pdf', compact('allVacationRequests'))
                ->setPaper('a3', 'portrait');
        return $pdf->stream('RelatorioPedidosFerias.pdf');
    }
}
