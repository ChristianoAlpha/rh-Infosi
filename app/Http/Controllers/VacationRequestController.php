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
     * - Funcionário (ou intern) vê somente os seus pedidos.
     * - Chefe de departamento vê os pedidos dos funcionários do seu departamento.
     * - Admin e Diretor veem todos.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'employee' || $user->role === 'intern') {
            // Funcionário normal ou estagiário: filtra pelos seus próprios pedidos
            $employeeId = $user->employee->id ?? null;
            $data = VacationRequest::where('employeeId', $employeeId)
                ->orderByDesc('id')
                ->get();
        } elseif ($user->role === 'department_head') {
            // Chefe de departamento: filtra os pedidos dos funcionários do mesmo departamento
            $deptId = $user->employee->departmentId ?? null;
            $data = VacationRequest::with('employee')
                ->whereHas('employee', function($query) use ($deptId) {
                    $query->where('departmentId', $deptId);
                })
                ->orderByDesc('id')
                ->get();
        } else {
            // Admin e Diretor: vê todos os pedidos
            $data = VacationRequest::with('employee')
                ->orderByDesc('id')
                ->get();
        }

        return view('vacationRequest.index', compact('data'));
    }

    /**
     * Exibe o formulário para criação de pedido de férias.
     * - Admin, Diretor e Chefe de Departamento: exibem a view de busca para selecionar o funcionário.
     * - Funcionário ou Intern: já utiliza seus próprios dados.
     */
    public function create()
    {
        $user = Auth::user();

        if (in_array($user->role, ['admin', 'director', 'department_head'])) {
            return view('vacationRequest.createSearch');
        } else {
            $employee = $user->employee;
            $vacationTypes = ['15 dias', '30 dias', '22 dias úteis', '11 dias úteis'];
            return view('vacationRequest.createEmployee', compact('employee', 'vacationTypes'));
        }
    }

    /**
     * Busca funcionário por ID ou Nome – utilizado na view para Admin/Diretor/Chefe.
     */
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

        return view('vacationRequest.createSearch', [
            'employee' => $employee,
            'vacationTypes' => ['15 dias', '30 dias', '22 dias úteis', '11 dias úteis'],
        ]);
    }

    /**
     * Armazena um novo pedido de férias.
     * Se o usuário for funcionário ou intern, utiliza o ID do próprio usuário.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validação comum
        $rules = [
            'vacationType'  => 'required|in:15 dias,30 dias,22 dias úteis,11 dias úteis',
            'vacationStart' => 'required|date',
            'vacationEnd'   => 'required|date|after_or_equal:vacationStart',
            'supportDocument' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xlsx',
        ];
        $request->validate($rules, [
            'vacationType.in' => 'O tipo de férias selecionado é inválido.',
        ]);

        // Determina o employeeId:
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

        // Processa upload do documento, se houver
        if ($request->hasFile('supportDocument')) {
            $file = $request->file('supportDocument');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('vacation_requests', $filename, 'public');
            $data['supportDocument'] = $path;
            $data['originalFileName'] = $file->getClientOriginalName();
        }

        // Define status inicial e comentário
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
     * Função auxiliar para contar os dias úteis entre duas datas (exclui sábados e domingos)
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

    public function show($id)
    {
        $data = VacationRequest::with('employee')->findOrFail($id);
        return view('vacationRequest.show', compact('data'));
    }

    public function edit($id)
    {
        $data = VacationRequest::findOrFail($id);
        return view('vacationRequest.edit', compact('data'));
    }

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

    public function pdfAll()
    {
        $allRequests = VacationRequest::with('employee')->get();
        $pdf = PDF::loadView('vacationRequest.vacationRequest_pdf', compact('allRequests'))
                  ->setPaper('a3', 'portrait');
        return $pdf->stream('RelatorioPedidosFerias.pdf');
    }

    // Métodos de aprovação para o chefe de departamento
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
