<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VacationRequest;
use App\Models\Employeee;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class VacationRequestController extends Controller
{
    public function index()
    {
        $data = VacationRequest::with('employee')->orderByDesc('id')->get();
        return view('vacationRequest.index', compact('data'));
    }

    public function create()
    {
        // Para o formulário de criação, precisamos buscar o funcionário.
        // Neste exemplo, o formulário de criação inclui um campo para buscar o funcionário.
        // A view 'vacationRequest.create' deverá lidar com a busca (por ID ou nome).
        return view('vacationRequest.create');
    }

    /**
     * Método para buscar funcionário por ID ou Nome.
     * Você pode adaptar para buscar por nome também.
     */
    public function searchEmployee(Request $request)
    {
        $request->validate([
            'employeeSearch' => 'required|string',
        ]);

        // Tenta encontrar por ID ou por nome (busca case-insensitive)
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
            // Lista de tipos de férias válidos (em inglês no código, mas os rótulos aparecerão em português)
            'vacationTypes' => ['15 dias', '30 dias', '22 dias úteis', '11 dias úteis'],
        ]);
    }

    public function store(Request $request)
    {
        // Validação básica
        $request->validate([
            'employeeId'   => 'required|integer|exists:employeees,id',
            'vacationType' => 'required|in:15 dias,30 dias,22 dias úteis,11 dias úteis',
            'vacationStart'=> 'required|date',
            'vacationEnd'  => 'required|date|after_or_equal:vacationStart',
        ], [
            'vacationType.in' => 'O tipo de férias selecionado é inválido.',
        ]);

        $vacationType = $request->vacationType;
        $start = Carbon::parse($request->vacationStart);
        $end = Carbon::parse($request->vacationEnd);
        $totalDays = $end->diffInDays($start) + 1; // diferença inclusiva

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

        VacationRequest::create([
            'employeeId'   => $request->employeeId,
            'vacationType' => $vacationType,
            'vacationStart'=> $request->vacationStart,
            'vacationEnd'  => $request->vacationEnd,
            'reason'       => $request->reason,
        ]);

        return redirect()->route('vacationRequest.index')
                         ->with('msg', 'Pedido de férias registrado com sucesso!');
    }

    // Função auxiliar para contar dias úteis entre duas datas (excluindo sábados e domingos)
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

    // Método para gerar PDF com todos os pedidos de férias (pode ser adaptado para filtros também)
    public function pdfAll()
    {
        $allRequests = VacationRequest::with('employee')->get();
        $pdf = PDF::loadView('vacationRequest.vacationRequest_pdf', compact('allRequests'))
                  ->setPaper('a3', 'portrait');
        return $pdf->stream('RelatorioPedidosFerias.pdf');
    }
}
