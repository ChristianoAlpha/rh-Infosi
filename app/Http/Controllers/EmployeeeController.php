<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employeee;
use App\Models\Department;
use App\Models\Position;
use App\Models\Specialty;
use App\Models\EmployeeType;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmployeeeController extends Controller
{
    #Para o meu index do Funcionario
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
        $employeeTypes =EmployeeType::all();

        return view('employeee.create', compact('departments', 'positions', 'specialties', 'employeeTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'depart'      => 'required',
            'fullName'    => 'required',
            'address'     => 'required',
            'mobile'      => 'required',
            'fatherName' => 'required',
            'motherName' => 'required',
            'bi'          => 'required|unique:employeees',
            'birth_date'  => 'required|date|date_format:Y-m-d|before_or_equal:today|after_or_equal:' . Carbon::now()->subYears(120)->format('Y-m-d'),
            'nationality' => 'required',
            'gender'      => 'required',
            'email'       => 'required|email|unique:employeees',
            'employeeTypeId'   => 'required|exists:employee_types,id',
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
        $data->phone_code = $request->phone_code;
        $data->fatherName  = $request->fatherName;
        $data->motherName  = $request->motherName;
        $data->bi           = $request->bi;
        $data->birth_date   = $request->birth_date;
        $data->nationality  = $request->nationality;
        $data->gender       = $request->gender;
        $data->email        = $request->email;
        $data->employeeTypeId  = $request->employeeTypeId;
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
        $employeeTypes  = EmployeeType::all();
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
            'employeeTypeId'   => 'required|exists:employee_types,id',
            'nationality' => 'required'
        ]);

        $data = Employeee::findOrFail($id);
        $data->departmentId = $request->depart;
        $data->fullName     = $request->fullName;
        $data->employeeTypeId  = $request->employeeTypeId;
        $data->address      = $request->address;
        $data->mobile       = $request->mobile;
        $data->phone_code = $request->phone_code;
        $data->nationality  = $request->nationality;
        $data->save();

        return redirect()->route('employeee.edit', $id)->with('msg', 'Dados atualizados com sucesso');
    }




     // ========== Perfil unico de cada usuario ==========
    public function myProfile()
{
    // aqui Pegamos o usuário logado
    $user = Auth::user();

    // Se por algum motivo não tiver employee(funcionario) vinculado, diremos...
    if (! $user->employee) {
        return redirect('/')
            ->withErrors(['msg' => 'Este usuário não está vinculado a um Funcionário.']);
    }

    $employee = $user->employee;
    return view('employeee.myprofile', compact('employee'));
}


    // ========== Filtro por datas ==========

    public function filterByDate(Request $request)
{
    // Carrega lista de tipos de funcionário (para repassar à view do filtro)
    $employeeTypes = EmployeeType::all();

    //Se nenhum parâmetro (data ou tipo) foi enviado, apenas carrega a view simples do filtro
    if (!$request->has('start_date') && !$request->has('end_date') && !$request->has('employeeTypeId')) {
        return view('employeee.filter', [
            'employeeTypes' => $employeeTypes,
        ]);
    }

    //Recupera os valores do form (podem estar vazios ou não)
    $startDate = $request->input('start_date');
    $endDate   = $request->input('end_date');
    $typeId    = $request->input('employeeTypeId');
    // $query  cria um ponto de partida para uma consulta no banco de dados.
    $query = Employeee::query();

    //Filtro por data (caso usuário tenha informado)
    //    Se o usuário não informar as datas, não filtra por created_at
    if ($startDate && $endDate) {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        // Aplica o filtro por intervalo de datas
        $start = Carbon::parse($startDate)->startOfDay();
        $end   = Carbon::parse($endDate)->endOfDay();
        $query->whereBetween('created_at', [$start, $end]);
    }

    //Filtro por tipo de funcionário (caso o usuário selecione)   //vai Verificar se o ID existe na tabela employee_types
    if ($typeId) {
        $query->where('employeeTypeId', $typeId);
    }

    // aqui ela vai Executar a query busca final
    $filtered = $query->orderByDesc('id')->get();

    // Vai Retornar a view, passando a lista filtrada, as datas, o tipo selecionado e a lista de tipos // Para depois popular no <select>
    return view('employeee.filter', [
        'employeeTypes' => $employeeTypes,  
        'filtered'      => $filtered,
        'start'         => $startDate,
        'end'           => $endDate,
        'selectedType'  => $typeId,
    ]);
}

/**
 * Gera o PDF com base no filtro aplicado (datas e/ou tipo).
 */
public function pdfFiltered(Request $request)
{
    //Recupera os valores que vêm da requisição
    $startDate = $request->input('start_date');
    $endDate   = $request->input('end_date');
    $typeId    = $request->input('employeeTypeId');

    $query = Employeee::query();

    //  Se usuário informou datas, filtra
    if ($startDate && $endDate) {
  
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $start = Carbon::parse($startDate)->startOfDay();
        $end   = Carbon::parse($endDate)->endOfDay();

        $query->whereBetween('created_at', [$start, $end]);
    }

    // Se usuário informou tipo de funcionário, filtra
    if ($typeId) {
        $query->where('employeeTypeId', $typeId);
    }

    $filtered = $query->orderByDesc('id')->get();

    // 6. Gera PDF
    $pdf = PDF::loadView('employeee.filtered_pdf', [
        'filtered'   => $filtered,
        'startDate'  => $startDate,
        'endDate'    => $endDate,
        'typeId'     => $typeId, 
    ])->setPaper('a3', 'landscape');

    return $pdf->stream("RelatorioFuncionariosFiltrados.pdf");
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
