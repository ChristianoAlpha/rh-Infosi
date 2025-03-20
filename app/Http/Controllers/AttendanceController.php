<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceRecord;
use App\Models\Employeee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Exibe o formulário para registrar a presença de um funcionário para um dia específico.
     * Pode ser utilizado pelo chefe ou responsável.
     */
    public function create()
    {
        // Caso seja necessário listar todos os funcionários do departamento do chefe
        $user = Auth::user();
        if ($user->role === 'department_head') {
            $departmentId = $user->employee->departmentId;
            $employees = Employeee::where('departmentId', $departmentId)->orderBy('fullName')->get();
        } else {
            // Se for admin ou RH, lista todos
            $employees = Employeee::orderBy('fullName')->get();
        }
        return view('attendance.create', compact('employees'));
    }

    /**
     * Armazena o registro de presença.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employeeId' => 'required|exists:employeees,id',
            'recordDate' => 'required|date',
            'status'     => 'required|string', // Ex.: Presente, Ausente, Férias, Licença, etc.
        ]);

        AttendanceRecord::create($request->all());

        return redirect()->route('attendance.index')
                         ->with('msg', 'Registro de presença salvo com sucesso.');
    }

    /**
     * Lista os registros de presença.
     */
    public function index(Request $request)
    {
        // Opcional: permitir filtro por data ou funcionário
        $query = AttendanceRecord::with('employee')->orderBy('recordDate', 'desc');
        if ($request->has('date')) {
            $query->where('recordDate', $request->date);
        }
        if ($request->has('employeeId')) {
            $query->where('employeeId', $request->employeeId);
        }
        $records = $query->get();
        return view('attendance.index', compact('records'));
    }

    /**
     * Dashboard de efetividade para um período (ex.: mês atual).
     * Calcula a taxa de presença para cada funcionário.
     */
    public function dashboard(Request $request)
    {
        // Define o período (padrão: mês atual)
        $startDate = Carbon::now()->startOfMonth();
        $endDate   = Carbon::now()->endOfMonth();

        // Calcula o total de dias úteis do período (excluindo sábados e domingos)
        $totalWeekdays = $this->countWeekdays($startDate, $endDate);

        // Lista todos os funcionários ou por departamento do chefe
        $user = Auth::user();
        if ($user->role === 'department_head') {
            $departmentId = $user->employee->departmentId;
            $employees = Employeee::where('departmentId', $departmentId)->orderBy('fullName')->get();
        } else {
            $employees = Employeee::orderBy('fullName')->get();
        }

        $dashboardData = [];
        foreach ($employees as $employee) {
            // Registros de presença no período para o funcionário
            $records = AttendanceRecord::where('employeeId', $employee->id)
                        ->whereBetween('recordDate', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                        ->get();

            // Conta os dias marcados como "Presente"
            $presentDays = $records->where('status', 'Presente')->count();

            // Dias justificáveis: Férias, Licença, etc. (não contam como falta)
            $justifiedDays = $records->whereIn('status', ['Férias', 'Licença', 'Doença', 'Teletrabalho'])->count();

            // Se não houver registro para o dia, considera ausência não justificada (aqui a lógica pode ser refinada)
            $absentDays = $totalWeekdays - ($presentDays + $justifiedDays);

            // Calcula a taxa de presença (presenças reais / total de dias úteis)
            $attendanceRate = $totalWeekdays > 0 ? round(($presentDays / $totalWeekdays) * 100, 2) : 0;

            $dashboardData[] = [
                'employeeName'  => $employee->fullName,
                'department'    => $employee->department->title ?? 'Sem Departamento',
                'totalWeekdays' => $totalWeekdays,
                'presentDays'   => $presentDays,
                'justifiedDays' => $justifiedDays,
                'absentDays'    => $absentDays,
                'attendanceRate'=> $attendanceRate,
            ];
        }

        return view('attendance.dashboard', compact('dashboardData', 'startDate', 'endDate'));
    }

    /**
     * Função auxiliar: Conta os dias úteis entre duas datas.
     */
    private function countWeekdays(Carbon $start, Carbon $end)
    {
        $days = 0;
        $current = $start->copy();
        while ($current->lte($end)) {
            if ($current->isWeekday()) {
                $days++;
            }
            $current->addDay();
        }
        return $days;
    }
}
