<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalaryPayment;
use App\Models\Employeee;
use App\Models\AttendanceRecord;
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
            ->orWhere('fullName', 'LIKE', "%{$term}%")
            ->first();

        if (!$employee) {
            return redirect()->back()
                ->withErrors(['employeeSearch' => 'Funcionário não encontrado!'])
                ->withInput();
        }

        $employees = Employeee::orderBy('fullName')->get();
        return view('salaryPayment.create', compact('employee', 'employees'));
    }

    public function calculateDiscount(Request $request)
    {
        $request->validate([
            'employeeId' => 'required|exists:employeees,id',
            'baseSalary' => 'required|numeric',
            'subsidies'  => 'required|numeric',
            'workMonth'  => 'required|date_format:Y-m',
        ]);

        $employeeId = $request->employeeId;
        $baseSalary = $request->baseSalary;
        $subsidies  = $request->subsidies;
        $refDate    = Carbon::parse("{$request->workMonth}-01");

        $startDate = $refDate->copy()->startOfMonth();
        $endDate   = $refDate->copy()->endOfMonth();

        $totalWeekdays = $this->countWeekdays($startDate, $endDate);

        $records = AttendanceRecord::where('employeeId', $employeeId)
            ->whereBetween('recordDate', [
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d'),
            ])
            ->get();

        $presentDays   = $records->where('status', 'Presente')->count();
        $justifiedDays = $records->whereIn('status', ['Férias', 'Licença', 'Doença', 'Teletrabalho'])->count();
        $absentDays    = max(0, $totalWeekdays - ($presentDays + $justifiedDays));

        $dailyRate = $totalWeekdays > 0
            ? ($baseSalary + $subsidies) / $totalWeekdays
            : 0;

        $discount = round($dailyRate * $absentDays, 2);

        return response()->json([
            'absentDays' => $absentDays,
            'discount'   => $discount,
        ]);
    }

    private function countWeekdays(Carbon $start, Carbon $end)
    {
        $days    = 0;
        $current = $start->copy();
        while ($current->lte($end)) {
            if ($current->isWeekday()) {
                $days++;
            }
            $current->addDay();
        }
        return $days;
    }

    public function store(Request $request)
    {
        $request->validate([
            'employeeId'    => 'required|exists:employeees,id',
            'workMonth'     => 'required|date_format:Y-m',
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
        $data['workMonth']   = Carbon::parse($data['workMonth'] . '-01')->format('Y-m-d');
        $data['baseSalary']  = $this->parseNumber($data['baseSalary']);
        $data['subsidies']   = $this->parseNumber($data['subsidies']);
        $data['irtRate']     = $this->parseNumber($data['irtRate']);
        $data['inssRate']    = $this->parseNumber($data['inssRate']);
        $data['discount']    = $this->parseNumber($data['discount']);

        if (empty($data['paymentDate'])) {
            $data['paymentDate'] = Carbon::now()->format('Y-m-d');
        }

        $gross     = $data['baseSalary'] + $data['subsidies'];
        $irtValue  = $gross * ($data['irtRate'] / 100);
        $inssValue = $gross * ($data['inssRate'] / 100);
        $netSalary = $gross - $irtValue - $inssValue - $data['discount'];
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
        $employees     = Employeee::orderBy('fullName')->get();
        return view('salaryPayment.edit', compact('salaryPayment', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employeeId'    => 'required|exists:employeees,id',
            'workMonth'     => 'required|date_format:Y-m',
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
        $data['workMonth']   = Carbon::parse($data['workMonth'] . '-01')->format('Y-m-d');
        $data['baseSalary']  = $this->parseNumber($data['baseSalary']);
        $data['subsidies']   = $this->parseNumber($data['subsidies']);
        $data['irtRate']     = $this->parseNumber($data['irtRate']);
        $data['inssRate']    = $this->parseNumber($data['inssRate']);
        $data['discount']    = $this->parseNumber($data['discount']);

        if (empty($data['paymentDate'])) {
            $data['paymentDate'] = Carbon::now()->format('Y-m-d');
        }

        $gross     = $data['baseSalary'] + $data['subsidies'];
        $irtValue  = $gross * ($data['irtRate'] / 100);
        $inssValue = $gross * ($data['inssRate'] / 100);
        $netSalary = $gross - $irtValue - $inssValue - $data['discount'];
        $data['salaryAmount'] = $netSalary;

        $salaryPayment->update($data);

        return redirect()->route('salaryPayment.index')
                         ->with('msg', 'Pagamento de salário atualizado com sucesso.');
    }

    public function destroy($id)
    {
        SalaryPayment::findOrFail($id)->delete();
        return redirect()->route('salaryPayment.index')
                         ->with('msg', 'Pagamento de salário removido com sucesso.');
    }

    public function pdfAll()
    {
        $salaryPayments = SalaryPayment::with('employee')
            ->orderByDesc('created_at')
            ->get();

        $pdf = PDF::loadView('salaryPayment.salaryPayment_pdf', compact('salaryPayments'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('RelatorioPagamentosSalarial.pdf');
    }

    private function parseNumber($value)
    {
        if (!$value) return 0;
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);
        return floatval($value);
    }
}
