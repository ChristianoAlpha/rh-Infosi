<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\VacationRequest;
use App\Models\Employeee;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class VacationRequestController extends Controller
{
    public function index()
    {
        // Carrega todos os pedidos, com relacionamento "employee"
        $data = VacationRequest::with('employee')->orderByDesc('id')->get();
        return view('vacationRequest.index', compact('data'));
    }

    public function create()
    {
        // Para exibir a view com o formulário de busca (ID ou nome) e as outras informações.
        return view('vacationRequest.create');
    }

    /**
     * Método para buscar o funcionário por ID ou Nome.
     * Se encontrado, retornamos a mesma view, mas com $employee e os tipos de férias.
     */
    public function searchEmployee(Request $request)
    {
        $request->validate([
            'employeeSearch' => 'required|string',
        ]);

        $term = $request->employeeSearch;

        // Busca por ID exato ou nome por aproximação de pesquisa, usamos o (LIKE)
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
            // Lista de tipos de férias
            'vacationTypes' => ['15 dias', '30 dias', '22 dias úteis', '11 dias úteis'],
        ]);
    }

    public function store(Request $request)
{
    // Validação: aceita arquivos do tipo PDF, JPG, JPEG e PNG, até 2MB
    $request->validate([
        'employeeId'      => 'required|integer|exists:employeees,id',
        'vacationType'    => 'required|in:15 dias,30 dias,22 dias úteis,11 dias úteis',
        'vacationStart'   => 'required|date',
        'vacationEnd'     => 'required|date|after_or_equal:vacationStart',
        'supportDocument' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ], [
        'vacationType.in' => 'O tipo de férias selecionado é inválido.',
    ]);

    $vacationType = $request->vacationType;
    $start = Carbon::parse($request->vacationStart);
    $end = Carbon::parse($request->vacationEnd);
    $totalDays = $end->diffInDays($start) + 1; // diferença inclusiva

    // Validação extra dos dias conforme o tipo de férias
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

    $vacation = new VacationRequest();
    $vacation->employeeId    = $request->employeeId;
    $vacation->vacationType  = $vacationType;
    $vacation->vacationStart = $request->vacationStart;
    $vacation->vacationEnd   = $request->vacationEnd;
    $vacation->reason        = $request->reason;

    // Lógica de upload do (documento ou imagem)
    if ($request->hasFile('supportDocument')) {
        $file = $request->file('supportDocument');
        //Criamos uma variavel para Armazenar o nome original do documento em vez do link criado pelo storage:link.
        $originalName = $file->getClientOriginalName();
        // Salva o arquivo no diretório 'vacations' no disco 'public'
        $path = $file->store('vacations', 'public');
        
        $vacation->supportDocument  = $path;         
        $vacation->originalFileName = $originalName;  
    }

    $vacation->save();

    return redirect()->route('vacationRequest.index')
                     ->with('msg', 'Pedido de férias registrado com sucesso!');
}


    // Conta dias úteis entre duas datas
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

    // Gera PDF de todos os pedidos
    public function pdfAll()
    {
        $allRequests = VacationRequest::with('employee')->get();
        $pdf = PDF::loadView('vacationRequest.vacationRequest_pdf', compact('allRequests'))
                  ->setPaper('a3', 'landscape');
        return $pdf->stream('RelatorioPedidosFerias.pdf');
    }
}


