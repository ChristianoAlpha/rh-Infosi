<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Employeee;
use App\Models\Department;
use App\Models\Position;
use App\Models\Specialty;
use App\Models\EmployeeType;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\NewEmployeeNotification;

class EmployeeeController extends Controller
{

    public function index()
    {
        $data = Employeee::orderByDesc('id')->get();
        return view('employeee.index', ['data' => $data]);
    }

    public function create()
    {
        $departments   = Department::all();
        $positions     = Position::all();
        $specialties   = Specialty::all();
        $employeeTypes = EmployeeType::all();

        return view('employeee.create', compact('departments', 'positions', 'specialties', 'employeeTypes'));
    }

    public function store(Request $request)
{
    $request->validate([
        'depart'      => 'required',
        'fullName'    => 'required',
        'address'     => 'required',
        'mobile'      => 'required',
        'fatherName'  => 'required',
        'motherName'  => 'required',
        'bi'          => 'required|unique:employeees',
        'birth_date'  => 'required|date|date_format:Y-m-d|before_or_equal:today|after_or_equal:' . \Carbon\Carbon::now()->subYears(120)->format('Y-m-d'),
        'nationality' => 'required',
        'gender'      => 'required',
        'email'       => 'required|email|unique:employeees',
        'employeeTypeId' => 'required|exists:employee_types,id',
        'positionId'  => 'required|exists:positions,id',
        'specialtyId' => 'required|exists:specialties,id',
        // Validação para o upload opcional
        'photo'       => 'nullable|image',
    ], [
        'birth_date.date_format'   => 'A data de nascimento deve estar no formato AAAA-MM-DD.',
        'birth_date.before_or_equal' => 'A data de nascimento não pode ser superior à data atual.',
        'birth_date.after_or_equal'  => 'A data de nascimento informada é inválida.',
    ]);

    $data = new Employeee();
    $data->departmentId    = $request->depart;
    $data->fullName        = $request->fullName;
    $data->address         = $request->address;
    $data->mobile          = $request->mobile;
    $data->phone_code      = $request->phone_code;
    $data->fatherName      = $request->fatherName;
    $data->motherName      = $request->motherName;
    $data->bi              = $request->bi;
    $data->birth_date      = $request->birth_date;
    $data->nationality     = $request->nationality;
    $data->gender          = $request->gender;
    $data->email           = $request->email;
    $data->employeeTypeId  = $request->employeeTypeId;
    $data->positionId      = $request->positionId;
    $data->specialtyId     = $request->specialtyId;
    $data->employmentStatus = 'active';

    // Se o funcionário for marcado como chefe de departamento, processa o upload da foto
    if($request->has('is_department_head') && $request->is_department_head) {
        if($request->hasFile('photo')) {
            $photoName = time().'_'.$request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('frontend/images/departments'), $photoName);
            $data->photo = $photoName;
        }
    }

    $data->save();

    \Illuminate\Support\Facades\Mail::to($data->email)->send(new \App\Mail\NewEmployeeNotification($data));

    return redirect('employeee/create')->with('msg', 'Dados submetidos com sucesso e e-mail enviado!');
}


    public function show($id)
    {
        $data = Employeee::findOrFail($id);
        return view('employeee.show', ['data' => $data]);
    }

    public function edit($id)
    {
        $data = Employeee::findOrFail($id);
        $departs = Department::orderByDesc('id')->get();
        $employeeTypes = EmployeeType::all();
        $positions = Position::all();
        $specialties = Specialty::all();

        return view('employeee.edit', compact('data', 'departs', 'positions', 'specialties'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'depart'         => 'required',
            'fullName'       => 'required',
            'address'        => 'required',
            'mobile'         => 'required',
            'bi'             => 'required|unique:employeees,bi,'.$id,
            'email'          => 'required|email|unique:employeees,email,'.$id,
            'employeeTypeId' => 'required|exists:employee_types,id',
            'nationality'    => 'required'
        ]);

        $data = Employeee::findOrFail($id);
        $data->departmentId = $request->depart;
        $data->fullName     = $request->fullName;
        $data->employeeTypeId = $request->employeeTypeId;
        $data->address      = $request->address;
        $data->mobile       = $request->mobile;
        $data->phone_code   = $request->phone_code;
        $data->nationality  = $request->nationality;
        $data->save();

        return redirect()->route('employeee.edit', $id)->with('msg', 'Dados atualizados com sucesso');
    }

    // Perfil único do funcionário logado
    public function myProfile()
    {
        $user = Auth::user();
        if (!$user->employee) {
            return redirect('/')->withErrors(['msg' => 'Este usuário não está vinculado a um Funcionário.']);
        }
        $employee = $user->employee;
        return view('employeee.myprofile', compact('employee'));
    }

 
    public function filterByDate(Request $request)
    {
        $employeeTypes = EmployeeType::all();

        if (!$request->has('start_date') && !$request->has('end_date') && !$request->has('employeeTypeId')) {
            return view('employeee.filter', ['employeeTypes' => $employeeTypes]);
        }

        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');
        $typeId    = $request->input('employeeTypeId');
        $query = Employeee::query();

        if ($startDate && $endDate) {
            $request->validate([
                'start_date' => 'required|date',
                'end_date'   => 'required|date|after_or_equal:start_date',
            ]);

            $start = Carbon::parse($startDate)->startOfDay();
            $end   = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        if ($typeId) {
            $query->where('employeeTypeId', $typeId);
        }

        $filtered = $query->orderByDesc('id')->get();

        return view('employeee.filter', [
            'employeeTypes' => $employeeTypes,
            'filtered'      => $filtered,
            'start'         => $startDate,
            'end'           => $endDate,
            'selectedType'  => $typeId,
        ]);
    }

    // Filtro por status (active ou retired)
    public function filterByStatus(Request $request)
    {
        $status = $request->input('status');
        $data = Employeee::where('employmentStatus', $status)->orderByDesc('id')->get();
        return view('employeee.index', ['data' => $data]);
    }

    // Gera PDF com base no filtro (datas e/ou tipo)
    public function pdfFiltered(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');
        $typeId    = $request->input('employeeTypeId');
        $query = Employeee::query();

        if ($startDate && $endDate) {
            $request->validate([
                'start_date' => 'required|date',
                'end_date'   => 'required|date|after_or_equal:start_date',
            ]);

            $start = Carbon::parse($startDate)->startOfDay();
            $end   = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        if ($typeId) {
            $query->where('employeeTypeId', $typeId);
        }

        $filtered = $query->orderByDesc('id')->get();

        $pdf = PDF::loadView('employeee.filtered_pdf', [
            'filtered'  => $filtered,
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'typeId'    => $typeId, 
        ])->setPaper('a3', 'landscape');

        return $pdf->stream("RelatorioFuncionariosFiltrados.pdf");
    }

    // Gera PDF de todos os funcionários
    public function pdfAll()
    {
        $allEmployees = Employeee::with(['department', 'position', 'specialty'])->get();
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
