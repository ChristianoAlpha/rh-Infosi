<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalaryPayment;
use App\Models\Employeee;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class SalaryPaymentController extends Controller
{
    // Lista os pagamentos; funcionários do tipo "employee" veem só os seus.
    public function index()
    {
        if (auth()->check() && auth()->user()->role === 'employee') {
            $employeeId = auth()->user()->employee->id ?? null;
            $salaryPayments = SalaryPayment::where('employeeId', $employeeId)
                ->orderByDesc('created_at')
                ->get();
        } else {
            $salaryPayments = SalaryPayment::with('employee')->orderByDesc('created_at')->get();
        }
        return view('salaryPayment.index', compact('salaryPayments'));
    }

    // Exibe o formulário para criar um novo pagamento.
    public function create()
    {
        // Se o usuário logado for admin ou diretor, permita selecionar o funcionário.
        // Para funcionários, você pode opcionalmente pré-preencher com os próprios dados.
        $employees = Employeee::orderBy('fullName')->get();
        return view('salaryPayment.create', compact('employees'));
    }

    // Armazena o pagamento.
    public function store(Request $request)
    {
        $request->validate([
            'employeeId'      => 'required|exists:employeees,id',
            'salaryAmount'    => 'required|numeric|min:0',
            'paymentDate'     => 'nullable|date',
            'paymentStatus'   => 'required|in:Pending,Completed,Failed',
            'paymentComment'  => 'nullable|string',
        ]);

        SalaryPayment::create($request->all());

        return redirect()->route('salaryPayment.index')
                         ->with('msg', 'Salary payment recorded successfully.');
    }

    // Mostra os detalhes do pagamento.
    public function show($id)
    {
        $salaryPayment = SalaryPayment::with('employee')->findOrFail($id);
        return view('salaryPayment.show', compact('salaryPayment'));
    }

    // Exibe o formulário para editar um pagamento.
    public function edit($id)
    {
        $salaryPayment = SalaryPayment::findOrFail($id);
        $employees = Employeee::orderBy('fullName')->get();
        return view('salaryPayment.edit', compact('salaryPayment', 'employees'));
    }

    // Atualiza o pagamento.
    public function update(Request $request, $id)
    {
        $request->validate([
            'employeeId'      => 'required|exists:employeees,id',
            'salaryAmount'    => 'required|numeric|min:0',
            'paymentDate'     => 'nullable|date',
            'paymentStatus'   => 'required|in:Pending,Completed,Failed',
            'paymentComment'  => 'nullable|string',
        ]);

        $salaryPayment = SalaryPayment::findOrFail($id);
        $salaryPayment->update($request->all());

        return redirect()->route('salaryPayment.index')
                         ->with('msg', 'Salary payment updated successfully.');
    }

    // Deleta o pagamento.
    public function destroy($id)
    {
        $salaryPayment = SalaryPayment::findOrFail($id);
        $salaryPayment->delete();

        return redirect()->route('salaryPayment.index')
                         ->with('msg', 'Salary payment deleted successfully.');
    }

    // Gera um PDF com todos os pagamentos.
    public function pdfAll()
    {
        $salaryPayments = SalaryPayment::with('employee')->orderByDesc('created_at')->get();
        $pdf = PDF::loadView('salaryPayment.salaryPayment_pdf', compact('salaryPayments'))
                  ->setPaper('a4', 'portrait');
        return $pdf->stream('SalaryPaymentsReport.pdf');
    }
}
