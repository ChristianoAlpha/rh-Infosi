<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employeee;
use App\Models\Department;
use App\Models\Position;
use App\Models\Specialty;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;

class EmployeeeController extends Controller
{
    public function index()
    {
        $data = Employeee::orderByDesc('id')->get();
        return view('employeee.index', ['data' => $data]);
    }

    public function create()
    {
        $departments = Department::all();
        $positions   = Position::all();
        $specialties = Specialty::all();

        return view('employeee.create', compact('departments', 'positions', 'specialties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'depart'      => 'required',
            'fullName'    => 'required',
            'address'     => 'required',
            'mobile'      => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'bi'          => 'required|unique:employeees',
            'birth_date'  => 'required|date|date_format:Y-m-d|before_or_equal:today|after_or_equal:' . Carbon::now()->subYears(120)->format('Y-m-d'),
            'nationality' => 'required',
            'gender'      => 'required',
            'email'       => 'required|email|unique:employeees',
            'positionId'  => 'required|exists:positions,id',
            'specialtyId' => 'required|exists:specialties,id'
        ],[
            'birth_date.date_format'     => 'A data de nascimento deve estar no formato AAAA-MM-DD.',
            'birth_date.before_or_equal' => 'A data de nascimento não pode ser superior a data atual.',
            'birth_date.after_or_equal'  => 'A data de nascimento informada é inválida.',
        ]);

        $data = new Employeee();
        $data->departmentId = $request->depart;
        $data->fullName     = $request->fullName;
        $data->address      = $request->address;
        $data->mobile       = $request->mobile;
        $data->father_name  = $request->father_name;
        $data->mother_name  = $request->mother_name;
        $data->bi           = $request->bi;
        $data->birth_date   = $request->birth_date;
        $data->nationality  = $request->nationality;
        $data->gender       = $request->gender;
        $data->email        = $request->email;
        $data->positionId   = $request->positionId;
        $data->specialtyId  = $request->specialtyId;
        $data->save();

        return redirect('employeee/create')->with('msg', 'Dados submentidos com sucesso');
    }

    public function show($id)
    {
        $data = Employeee::findOrFail($id);
        return view('employeee.show', ['data' => $data]);
    }

    public function edit($id)
    {
        $data       = Employeee::findOrFail($id);
        $departs    = Department::orderByDesc('id')->get();
        $positions  = Position::all();
        $specialties= Specialty::all();

        return view('employeee.edit', compact('data', 'departs', 'positions', 'specialties'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'depart'      => 'required',
            'fullName'    => 'required',
            'address'     => 'required',
            'mobile'      => 'required',
            'bi'          => 'required|unique:employeees,bi,'.$id,
            'email'       => 'required|email|unique:employeees,email,'.$id,
            'nationality' => 'required'
        ]);

        $data = Employeee::findOrFail($id);
        $data->departmentId = $request->depart;
        $data->fullName     = $request->fullName;
        $data->address      = $request->address;
        $data->mobile       = $request->mobile;
        $data->nationality  = $request->nationality;
        $data->save();

        return redirect()->route('employeee.edit', $id)->with('msg', 'Dados atualizados com sucesso');
    }

    // ========== Filtro por datas ==========
    public function filterByDate(Request $request)
    {
        // Se não vier datas, retorna view simples
        if (!$request->has('start_date') && !$request->has('end_date')) {
            return view('employeee.filter');
        }

        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $start = Carbon::parse($request->start_date)->startOfDay();
        $end   = Carbon::parse($request->end_date)->endOfDay();

        $filtered = Employeee::whereBetween('created_at', [$start, $end])
                             ->orderByDesc('id')
                             ->get();

        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        return view('employeee.filter', [
            'filtered' => $filtered,
            'start'    => $startDate,
            'end'      => $endDate,
        ]);
    }

    public function pdfFiltered(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $start = Carbon::parse($request->start_date)->startOfDay();
        $end   = Carbon::parse($request->end_date)->endOfDay();

        $filtered = Employeee::whereBetween('created_at', [$start, $end])
                             ->orderByDesc('id')
                             ->get();

        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        $pdf = PDF::loadView('employeee.filtered_pdf', compact('filtered', 'startDate', 'endDate'))
                  ->setPaper('a3', 'portrait');

        return $pdf->stream("RelatorioFuncionarios_{$startDate}_{$endDate}.pdf");
    }

    // ========== PDF de Todos os Funcionários ==========
    public function pdfAll()
    {
        $allEmployees = Employeee::with(['department','position','specialty'])->get();

        $pdf = PDF::loadView('employeee.employeee_pdf', compact('allEmployees'))
                  ->setPaper('a3', 'portrait');
        return $pdf->stream('RelatorioTodosFuncionarios.pdf');
    }

    public function destroy($id)
    {
        Employeee::destroy($id);
        return redirect('employeee');
    }
}
