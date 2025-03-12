<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VacationRequest;
use App\Models\Employeee;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;

class VacationRequestController extends Controller
{
    public function index()
    {
        $data = VacationRequest::with('employee')->orderByDesc('id')->get();
        return view('vacationRequest.index', compact('data'));
    }

    public function create()
    {
        return view('vacationRequest.create');
    }

    /**
     * Busca funcionário por ID ou Nome.
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

        return view('vacationRequest.create', [
            'employee' => $employee,
            'vacationTypes' => ['15 dias', '30 dias', '22 dias úteis', '11 dias úteis'],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employeeId'    => 'required|integer|exists:employeees,id',
            'vacationType'  => 'required|in:15 dias,30 dias,22 dias úteis,11 dias úteis',
            'vacationStart' => 'required|date',
            'vacationEnd'   => 'required|date|after_or_equal:vacationStart',
            'supportDocument' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx',
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

        $data = $request->all();

        if ($request->hasFile('supportDocument')) {
            $file = $request->file('supportDocument');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('vacation_requests', $filename, 'public');
            $data['supportDocument'] = $path;
            $data['originalFileName'] = $file->getClientOriginalName();
        }

        // Garante que o pedido nasce com status "Pendente"
        $data['approvalStatus'] = 'Pendente';
        $data['approvalComment'] = null;

        VacationRequest::create([
            'employeeId'       => $data['employeeId'],
            'vacationType'     => $vacationType,
            'vacationStart'    => $data['vacationStart'],
            'vacationEnd'      => $data['vacationEnd'],
            'reason'           => $data['reason'] ?? null,
            'supportDocument'  => $data['supportDocument'] ?? null,
            'originalFileName' => $data['originalFileName'] ?? null,
            'approvalStatus'   => $data['approvalStatus'],
            'approvalComment'  => $data['approvalComment'],
        ]);

        return redirect()->route('vacationRequest.index')
                         ->with('msg', 'Pedido de férias registrado com sucesso!');
    }

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
            'supportDocument' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx',
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
            'vacationStart'     => $data['vacationStart'],
            'vacationEnd'       => $data['vacationEnd'],
            'reason'            => $data['reason'] ?? null,
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

    // Métodos para aprovação que será feita pelo (para o chefe de departamento)
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
