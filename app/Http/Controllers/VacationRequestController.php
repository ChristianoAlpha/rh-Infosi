<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VacationRequest;
use App\Models\Employeee;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VacationRequestController extends Controller
{
    /**
     * Exibe a lista de pedidos de férias.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'employee' || $user->role === 'intern') {
            $employeeId = $user->employee->id ?? null;
            $data = VacationRequest::where('employeeId', $employeeId)
                        ->orderByDesc('id')
                        ->get();
        } elseif ($user->role === 'department_head') {
            $deptId = $user->employee->departmentId ?? null;
            $data = VacationRequest::with('employee')
                ->whereHas('employee', function ($query) use ($deptId) {
                    $query->where('departmentId', $deptId)
                          ->where('employmentStatus', 'active');
                })
                ->orderByDesc('id')
                ->get();
        } else {
            $data = VacationRequest::with('employee')
                        ->orderByDesc('id')
                        ->get();
        }
        return view('vacationRequest.index', compact('data'));
    }

    /**
     * Exibe o formulário para criar um novo pedido de férias.
     */
    public function create()
    {
        $user = Auth::user();
        $vacationTypes = ['15 dias', '30 dias', '22 dias úteis', '11 dias úteis'];
        if (in_array($user->role, ['admin', 'director', 'department_head'])) {
            return view('vacationRequest.createSearch', compact('vacationTypes'));
        } else {
            $employee = $user->employee;
            return view('vacationRequest.createEmployee', compact('employee', 'vacationTypes'));
        }
    }

    /**
     * Busca um funcionário por ID ou Nome.
     */
    public function searchEmployee(Request $request)
    {
        $request->validate([
            'employeeSearch' => 'required|string',
        ]);
        $term = $request->employeeSearch;
        $employee = Employeee::where('employmentStatus', 'active')
            ->where(function($q) use ($term) {
                $q->where('id', $term)
                  ->orWhere('fullName', 'LIKE', "%$term%");
            })->first();
        if (!$employee) {
            return redirect()->back()
                ->withErrors(['employeeSearch' => 'Funcionário não encontrado!'])
                ->withInput();
        }
        $vacationTypes = ['15 dias', '30 dias', '22 dias úteis', '11 dias úteis'];
        return view('vacationRequest.createSearch', [
            'employee' => $employee,
            'vacationTypes' => $vacationTypes,
        ]);
    }

    /**
     * Armazena o pedido de férias.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'vacationType'  => 'required|in:15 dias,30 dias,22 dias úteis,11 dias úteis',
            'vacationStart' => 'required|date',
            'vacationEnd'   => 'required|date|after_or_equal:vacationStart',
            'supportDocument' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xlsx',
        ];
        $request->validate($rules, [
            'vacationType.in' => 'O tipo de férias selecionado é inválido.',
        ]);
        if (in_array($user->role, ['employee', 'intern'])) {
            $employeeId = $user->employee->id ?? null;
        } else {
            $request->validate([
                'employeeId' => 'required|integer|exists:employeees,id'
            ]);
            $employeeId = $request->employeeId;
        }
        $vacationType = $request->vacationType;
        $start = Carbon::parse($request->vacationStart);
        $end = Carbon::parse($request->vacationEnd);
        $totalDays = $end->diffInDays($start) + 1;
        if (in_array($vacationType, ['15 dias', '30 dias'])) {
            $expected = intval(explode(' ', $vacationType)[0]);
            if ($totalDays != $expected) {
                return redirect()->back()
                    ->withErrors(['vacationEnd' => "Para '$vacationType', o intervalo deve ser exatamente $expected dias."])
                    ->withInput();
            }
        } elseif (in_array($vacationType, ['22 dias úteis', '11 dias úteis'])) {
            $expected = intval(explode(' ', $vacationType)[0]);
            $weekdays = $this->countWeekdays($start, $end);
            if ($weekdays != $expected) {
                return redirect()->back()
                    ->withErrors(['vacationEnd' => "Para '$vacationType', o intervalo deve ser exatamente $expected dias úteis."])
                    ->withInput();
            }
        }
        $data = $request->all();
        if ($request->hasFile('supportDocument')) {
            $file = $request->file('supportDocument');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('vacation_requests', $filename, 'public');
            $data['supportDocument'] = $path;
            $data['originalFileName'] = $file->getClientOriginalName();
        }
        $data['approvalStatus'] = 'Pendente';
        $data['approvalComment'] = null;
        VacationRequest::create([
            'employeeId'       => $employeeId,
            'vacationType'     => $vacationType,
            'vacationStart'    => $request->vacationStart,
            'vacationEnd'      => $request->vacationEnd,
            'reason'           => $request->reason ?? null,
            'supportDocument'  => $data['supportDocument'] ?? null,
            'originalFileName' => $data['originalFileName'] ?? null,
            'approvalStatus'   => $data['approvalStatus'],
            'approvalComment'  => $data['approvalComment'],
        ]);
        return redirect()->route('vacationRequest.index')
            ->with('msg', 'Pedido de férias registrado com sucesso!');
    }

    /**
     * Conta os dias úteis entre duas datas.
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

    /**
     * Exibe os detalhes do pedido de férias.
     */
    public function show($id)
    {
        $data = VacationRequest::with('employee')->findOrFail($id);
        return view('vacationRequest.show', compact('data'));
    }

    /**
     * Exibe o formulário para editar um pedido de férias.
     */
    public function edit($id)
    {
        $data = VacationRequest::findOrFail($id);
        return view('vacationRequest.edit', compact('data'));
    }

    /**
     * Atualiza o pedido de férias.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'vacationType'  => 'required|in:15 dias,30 dias,22 dias úteis,11 dias úteis',
            'vacationStart' => 'required|date',
            'vacationEnd'   => 'required|date|after_or_equal:vacationStart',
            'supportDocument' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xlsx',
        ], [
            'vacationType.in' => 'O tipo de férias selecionado é inválido.',
        ]);

        $vacationType = $request->vacationType;
        $start = Carbon::parse($request->vacationStart);
        $end = Carbon::parse($request->vacationEnd);
        $totalDays = $end->diffInDays($start) + 1;

        if (in_array($vacationType, ['15 dias', '30 dias'])) {
            $expected = intval(explode(' ', $vacationType)[0]);
            if ($totalDays != $expected) {
                return redirect()->back()
                    ->withErrors(['vacationEnd' => "Para '$vacationType', o intervalo deve ser exatamente $expected dias."])
                    ->withInput();
            }
        } elseif (in_array($vacationType, ['22 dias úteis', '11 dias úteis'])) {
            $expected = intval(explode(' ', $vacationType)[0]);
            $weekdays = $this->countWeekdays($start, $end);
            if ($weekdays != $expected) {
                return redirect()->back()
                    ->withErrors(['vacationEnd' => "Para '$vacationType', o intervalo deve ser exatamente $expected dias úteis."])
                    ->withInput();
            }
        }

        $vacationRequest = VacationRequest::findOrFail($id);
        $data = $request->all();
        if ($request->hasFile('supportDocument')) {
            if ($vacationRequest->supportDocument && Storage::disk('public')->exists($vacationRequest->supportDocument)) {
                Storage::disk('public')->delete($vacationRequest->supportDocument);
            }
            $file = $request->file('supportDocument');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('vacation_requests', $filename, 'public');
            $data['supportDocument'] = $path;
            $data['originalFileName'] = $file->getClientOriginalName();
        } else {
            $data['supportDocument'] = $vacationRequest->supportDocument;
            $data['originalFileName'] = $vacationRequest->originalFileName;
        }

        $vacationRequest->update([
            'vacationType'      => $vacationType,
            'vacationStart'     => $request->vacationStart,
            'vacationEnd'       => $request->vacationEnd,
            'reason'            => $request->reason ?? null,
            'supportDocument'   => $data['supportDocument'] ?? null,
            'originalFileName'  => $data['originalFileName'] ?? null,
        ]);

        return redirect()->route('vacationRequest.edit', $id)
            ->with('msg', 'Pedido de férias atualizado com sucesso!');
    }

    /**
     * Gera um PDF com todos os pedidos de férias.
     */
    public function pdfAll()
    {
        $allRequests = VacationRequest::with('employee')->get();
        $pdf = PDF::loadView('vacationRequest.vacationRequest_pdf', compact('allRequests'))
                  ->setPaper('a3', 'portrait');
        return $pdf->stream('RelatorioPedidosFerias.pdf');
    }

    /**
     * Exibe o resumo por departamento dos pedidos de férias.
     */
    public function departmentSummary()
    {
        $vacationRequests = VacationRequest::with('employee.department')->get();
        $summary = [];
        foreach ($vacationRequests as $request) {
            $deptTitle = $request->employee->department->title ?? 'Departamento Desconhecido';
            if (!isset($summary[$deptTitle])) {
                $summary[$deptTitle] = [
                    'department' => $deptTitle,
                    'total'      => 0,
                    'approved'   => 0,
                    'pending'    => 0,
                    'rejected'   => 0,
                ];
            }
            $summary[$deptTitle]['total']++;
            $status = strtolower($request->approvalStatus);
            if ($status == 'approved' || $status == 'aprovado') {
                $summary[$deptTitle]['approved']++;
            } elseif ($status == 'rejected' || $status == 'recusado') {
                $summary[$deptTitle]['rejected']++;
            } else {
                $summary[$deptTitle]['pending']++;
            }
        }
        $summaryData = array_values($summary);
        return view('vacationRequest.departmentSummary', compact('summaryData'));
    }

    /**
     * Método de aprovação para o chefe de departamento.
     */
    public function approval($departmentId)
    {
        $data = VacationRequest::with('employee')
            ->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('departmentId', $departmentId);
            })
            ->orderByDesc('id')
            ->get();
        return view('vacationRequest.approval', compact('data'));
    }

    /**
     * Atualiza o status de aprovação de um pedido de férias.
     */
    public function updateApproval(Request $request, $id)
    {
        $request->validate([
            'approvalStatus'  => 'required|in:Aprovado,Recusado,Pendente',
            'approvalComment' => 'nullable|string',
        ]);
        $vacation = VacationRequest::findOrFail($id);
        $vacation->approvalStatus = $request->approvalStatus;
        $vacation->approvalComment = $request->approvalComment;
        $vacation->save();
        return redirect()->back()->with('msg', 'Status atualizado com sucesso!');
    }
}
