<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalaryPayment;
use App\Models\Employeee;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class SalaryPaymentController extends Controller
{
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

    public function create()
    {
        $employees = Employeee::orderBy('fullName')->get();
        return view('salaryPayment.create', compact('employees'));
    }

    
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

 
    public function store(Request $request)
    {
        $request->validate([
            'employeeId'    => 'required|exists:employeees,id',
            'baseSalary'    => 'required',
            'subsidies'     => 'required',
            'irtRate'       => 'required',
            'inssRate'      => 'required',
            'discount'      => 'nullable',
            'paymentDate'   => 'nullable|date',
            'paymentStatus' => 'required|in:Pending,Completed,Failed',
            'paymentComment'=> 'nullable|string',
        ]);

        $data = $request->all();

        $data['baseSalary'] = $this->parseNumber($data['baseSalary']);
        $data['subsidies']  = $this->parseNumber($data['subsidies']);
        $data['irtRate']    = $this->parseNumber($data['irtRate']);
        $data['inssRate']   = $this->parseNumber($data['inssRate']);
        $data['discount']   = $this->parseNumber($data['discount']);

        if (empty($data['paymentDate'])) {
            $data['paymentDate'] = Carbon::now()->format('Y-m-d');
        }

     
        $gross = $data['baseSalary'] + $data['subsidies'];
        $irtValue = $gross * ($data['irtRate'] / 100);
        $inssValue = $gross * ($data['inssRate'] / 100);
        $discount = $data['discount'] ?? 0;
        $netSalary = $gross - $irtValue - $inssValue - $discount;
        $data['salaryAmount'] = $netSalary;

        SalaryPayment::create($data);

        return redirect()->route('salaryPayment.index')
                         ->with('msg', 'Pagamento de salário registrado com sucesso.');
    }

    public function show($id)
    {
        $salaryPayment = SalaryPayment::with('employee')->findOrFail($id);
        return view('salaryPayment.show', compact('salaryPayment'));
    }


    public function edit($id)
    {
        $salaryPayment = SalaryPayment::findOrFail($id);
        $employees = Employeee::orderBy('fullName')->get();
        return view('salaryPayment.edit', compact('salaryPayment', 'employees'));
    }

 
    public function update(Request $request, $id)
    {
        $request->validate([
            'employeeId'    => 'required|exists:employeees,id',
            'baseSalary'    => 'required',
            'subsidies'     => 'required',
            'irtRate'       => 'required',
            'inssRate'      => 'required',
            'discount'      => 'nullable',
            'paymentDate'   => 'nullable|date',
            'paymentStatus' => 'required|in:Pending,Completed,Failed',
            'paymentComment'=> 'nullable|string',
        ]);

        $salaryPayment = SalaryPayment::findOrFail($id);
        $data = $request->all();

        $data['baseSalary'] = $this->parseNumber($data['baseSalary']);
        $data['subsidies']  = $this->parseNumber($data['subsidies']);
        $data['irtRate']    = $this->parseNumber($data['irtRate']);
        $data['inssRate']   = $this->parseNumber($data['inssRate']);
        $data['discount']   = $this->parseNumber($data['discount']);

        if (empty($data['paymentDate'])) {
            $data['paymentDate'] = Carbon::now()->format('Y-m-d');
        }

     
        $gross = $data['baseSalary'] + $data['subsidies'];
        $irtValue = $gross * ($data['irtRate'] / 100);
        $inssValue = $gross * ($data['inssRate'] / 100);
        $discount = $data['discount'] ?? 0;
        $netSalary = $gross - $irtValue - $inssValue - $discount;
        $data['salaryAmount'] = $netSalary;

        $salaryPayment->update($data);

        return redirect()->route('salaryPayment.index')
                         ->with('msg', 'Pagamento de salário atualizado com sucesso.');
    }


    public function destroy($id)
    {
        $salaryPayment = SalaryPayment::findOrFail($id);
        $salaryPayment->delete();

        return redirect()->route('salaryPayment.index')
                         ->with('msg', 'Pagamento de salário removido com sucesso.');
    }

   
    public function pdfAll()
    {
        $salaryPayments = SalaryPayment::with('employee')
            ->orderByDesc('created_at')
            ->get();

        $pdf = PDF::loadView('salaryPayment.salaryPayment_pdf', compact('salaryPayments'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('RelatorioPagamentosSalarial.pdf');
    }

    
    private function parseNumber($value)
    {
        if (!$value) return 0;
        $value = str_replace('.', '', $value);
        return floatval($value);
    }
}
