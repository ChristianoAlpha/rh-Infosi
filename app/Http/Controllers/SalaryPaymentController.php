<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalaryPayment;
use App\Models\Employeee;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class SalaryPaymentController extends Controller
{
    // Lista os pagamentos
    public function index()
    {
        if (auth()->check() && auth()->user()->role === 'employee') {
            $employeeId = auth()->user()->employee->id ?? null;
            $salaryPayments = SalaryPayment::where('employeeId', $employeeId)
                ->orderByDesc('created_at')
                ->get();
        } else {
            $salaryPayments = SalaryPayment::with('employee')
                ->orderByDesc('created_at')
                ->get();
        }
        return view('salaryPayment.index', compact('salaryPayments'));
    }

    // Exibe o formulário para criar um novo pagamento
    public function create()
    {
        $employees = Employeee::orderBy('fullName')->get();
        return view('salaryPayment.create', compact('employees'));
    }

    // Busca um funcionário por ID ou nome
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

        $employees = Employeee::orderBy('fullName')->get();

        return view('salaryPayment.create', [
            'employee'  => $employee,
            'employees' => $employees,
        ]);
    }

    // Armazena o pagamento
    public function store(Request $request)
    {
        $request->validate([
            'employeeId'     => 'required|exists:employeees,id',
            'salaryAmount'   => 'required|numeric|min:0',
            'paymentDate'    => 'nullable|date',
            'paymentStatus'  => 'required|in:Pending,Completed,Failed',
            'paymentComment' => 'nullable|string',
        ]);

        // Prepara os dados
        $data = $request->all();

        // Se não vier data de pagamento, calcula com base em paymentDelayDays
        if (empty($data['paymentDate'])) {
            $employee = Employeee::with('employeeType')->findOrFail($data['employeeId']);

            // Exemplo: data-base é a data atual
            // ou fixar dia 25 => $baseDate = Carbon::now()->day(25)->setTime(0,0);
            $baseDate = Carbon::now();
            $delay = $employee->employeeType->paymentDelayDays ?? 0;
            $calculatedDate = $baseDate->addDays($delay);
            $data['paymentDate'] = $calculatedDate->format('Y-m-d');
        }

        SalaryPayment::create($data);

        return redirect()->route('salaryPayment.index')
                         ->with('msg', 'Pagamento de salário registrado com sucesso.');
    }

    // Exibe os detalhes do pagamento
    public function show($id)
    {
        $salaryPayment = SalaryPayment::with('employee')->findOrFail($id);
        return view('salaryPayment.show', compact('salaryPayment'));
    }

    // Exibe o formulário para editar um pagamento
    public function edit($id)
    {
        $salaryPayment = SalaryPayment::findOrFail($id);
        $employees = Employeee::orderBy('fullName')->get();
        return view('salaryPayment.edit', compact('salaryPayment', 'employees'));
    }

    // Atualiza o pagamento
    public function update(Request $request, $id)
    {
        $request->validate([
            'employeeId'     => 'required|exists:employeees,id',
            'salaryAmount'   => 'required|numeric|min:0',
            'paymentDate'    => 'nullable|date',
            'paymentStatus'  => 'required|in:Pending,Completed,Failed',
            'paymentComment' => 'nullable|string',
        ]);

        $salaryPayment = SalaryPayment::findOrFail($id);

        $data = $request->all();

        // Se a data de pagamento estiver vazia, recalcula
        if (empty($data['paymentDate'])) {
            $employee = Employeee::with('employeeType')->findOrFail($data['employeeId']);
            $baseDate = Carbon::now();
            $delay = $employee->employeeType->paymentDelayDays ?? 0;
            $calculatedDate = $baseDate->addDays($delay);
            $data['paymentDate'] = $calculatedDate->format('Y-m-d');
        }

        $salaryPayment->update($data);

        return redirect()->route('salaryPayment.index')
                         ->with('msg', 'Pagamento de salário atualizado com sucesso.');
    }

    // Deleta o pagamento
    public function destroy($id)
    {
        $salaryPayment = SalaryPayment::findOrFail($id);
        $salaryPayment->delete();

        return redirect()->route('salaryPayment.index')
                         ->with('msg', 'Pagamento de salário removido com sucesso.');
    }

    // Gera um PDF com todos os pagamentos
    public function pdfAll()
    {
        $salaryPayments = SalaryPayment::with('employee')
            ->orderByDesc('created_at')
            ->get();

        $pdf = PDF::loadView('salaryPayment.salaryPayment_pdf', compact('salaryPayments'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('RelatorioPagamentosSalarial.pdf');
    }
}
