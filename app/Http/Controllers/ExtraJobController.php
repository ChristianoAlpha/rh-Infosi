<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExtraJob;
use App\Models\Employeee;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Validation\ValidationException;

class ExtraJobController extends Controller
{
    /**
     * Valida que o valor bruto contenha apenas dígitos, pontos ou vírgulas,
     * sem letras, símbolos ou sinais de menos.
     */
    private function validateRawCurrency(string $raw, string $field)
    {
        if (strpos($raw, '-') !== false || preg_match('/[^0-9\.,]/', $raw)) {
            throw ValidationException::withMessages([
                $field => 'O valor só pode conter dígitos, pontos ou vírgulas, e não pode ser negativo.'
            ]);
        }
    }

    /**
     * Normaliza a string: retira pontos, troca vírgula por ponto,
     * para converter corretamente em float. Se vier null ou vazia, retorna 0.0.
     */
    private function normalizeCurrency($raw): float
    {
        if ($raw === null || trim($raw) === '') {
            return 0.0;
        }
        $clean = str_replace('.', '', (string)$raw);
        $clean = str_replace(',', '.', $clean);
        return (float)$clean;
    }

    public function index()
    {
        $jobs = ExtraJob::with('employees')
                        ->orderByDesc('created_at')
                        ->get();
        return view('Extras.index', compact('jobs'));
    }

    public function create()
    {
        return view('Extras.create');
    }

    public function searchEmployee(Request $request)
    {
        $q = $request->get('q');
        $emps = Employeee::with('department','admin')
                        ->where('fullName', 'LIKE', "%{$q}%")
                        ->orderBy('fullName')
                        ->limit(10)
                        ->get();

        $results = $emps->map(function($e) {
            if ($e->admin && $e->admin->role === 'director') {
                $extra = ucfirst($e->admin->directorType);
            } elseif ($e->admin && $e->admin->role === 'department_head') {
                $extra = 'Chefe de ' . ($e->department->title ?? '—');
            } else {
                $extra = 'Depto: ' . ($e->department->title ?? '-');
            }
            return [
                'id'    => $e->id,
                'text'  => $e->fullName,
                'extra' => $extra,
            ];
        });

        return response()->json($results);
    }

    public function store(Request $request)
    {
        // 1) valida raw total
        $rawTotal = (string) $request->input('totalValue', '');
        $this->validateRawCurrency($rawTotal, 'totalValue');

        // 2) valida raw bonuses
        $rawBonus = $request->input('bonus', []);
        foreach ($rawBonus as $empId => $raw) {
            if ($raw !== null) {
                $this->validateRawCurrency((string)$raw, "bonus.{$empId}");
            }
        }

        // 3) normaliza total e bonuses
        $totalValue = $this->normalizeCurrency($rawTotal);
        $normalizedBonus = [];
        foreach ($request->input('bonus', []) as $empId => $raw) {
            $normalizedBonus[$empId] = $this->normalizeCurrency($raw);
        }

        // 4) merge para validação
        $request->merge([
            'totalValue' => $totalValue,
            'bonus'      => $normalizedBonus
        ]);

        // 5) validações laravel
        $request->validate([
            'title'        => 'required|string',
            'totalValue'   => 'required|numeric|min:0',
            'participants' => 'required|array|min:1',
            'bonus'        => 'nullable|array',
            'bonus.*'      => 'nullable|numeric|min:0',
        ], [
            'totalValue.min' => 'O valor total não pode ser negativo.',
            'bonus.*.min'    => 'Os ajustes não podem ser negativos.',
        ]);

        // 6) checa soma de ajustes ≤ total
        if (array_sum($normalizedBonus) > $totalValue) {
            return back()
                ->withErrors(['bonus' => 'A soma dos ajustes não pode exceder o valor total.'])
                ->withInput();
        }

        // 7) calculo de distribuição
        $parts       = $request->participants;
        $actualBonus = [];
        foreach ($parts as $empId) {
            $adj = $normalizedBonus[$empId] ?? 0;
            if ($adj > 0) {
                $actualBonus[$empId] = $adj;
            }
        }
        $fixedShare        = array_sum($actualBonus);
        $variableEmployees = array_diff($parts, array_keys($actualBonus));
        $variableCount     = count($variableEmployees);
        $remaining         = $totalValue - $fixedShare;
        $baseShare         = $variableCount
                               ? round($remaining / $variableCount, 2)
                               : 0;

        // 8) cria ExtraJob
        $job = ExtraJob::create([
            'title'      => $request->title,
            'totalValue' => $totalValue,
        ]);

        // 9) anexa participantes
        foreach ($parts as $empId) {
            if (isset($actualBonus[$empId])) {
                $assigned        = $actualBonus[$empId];
                $bonusAdjustment = $assigned - $baseShare;
            } else {
                $assigned        = $baseShare;
                $bonusAdjustment = 0;
            }
            $job->employees()->attach($empId, [
                'bonusAdjustment' => $bonusAdjustment,
                'assignedValue'   => $assigned,
            ]);
        }

        return redirect()->route('extras.index')
                         ->with('msg','Trabalho Extra criado com sucesso.');
    }

    public function show($id)
    {
        $job = ExtraJob::with('employees')->findOrFail($id);
        return view('Extras.show', compact('job'));
    }

    public function edit($id)
    {
        $job = ExtraJob::with('employees')->findOrFail($id);
        return view('Extras.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        // mesmíssimos passos do store()

        $rawTotal = (string) $request->input('totalValue', '');
        $this->validateRawCurrency($rawTotal, 'totalValue');

        $rawBonus = $request->input('bonus', []);
        foreach ($rawBonus as $empId => $raw) {
            if ($raw !== null) {
                $this->validateRawCurrency((string)$raw, "bonus.{$empId}");
            }
        }

        $totalValue = $this->normalizeCurrency($rawTotal);
        $normalizedBonus = [];
        foreach ($request->input('bonus', []) as $empId => $raw) {
            $normalizedBonus[$empId] = $this->normalizeCurrency($raw);
        }

        $request->merge([
            'totalValue' => $totalValue,
            'bonus'      => $normalizedBonus
        ]);

        $request->validate([
            'title'        => 'required|string',
            'totalValue'   => 'required|numeric|min:0',
            'participants' => 'required|array|min:1',
            'bonus'        => 'nullable|array',
            'bonus.*'      => 'nullable|numeric|min:0',
        ], [
            'totalValue.min' => 'O valor total não pode ser negativo.',
            'bonus.*.min'    => 'Os ajustes não podem ser negativos.',
        ]);

        if (array_sum($normalizedBonus) > $totalValue) {
            return back()
                ->withErrors(['bonus' => 'A soma dos ajustes não pode exceder o valor total.'])
                ->withInput();
        }

        $parts       = $request->participants;
        $actualBonus = [];
        foreach ($parts as $empId) {
            $adj = $normalizedBonus[$empId] ?? 0;
            if ($adj > 0) {
                $actualBonus[$empId] = $adj;
            }
        }
        $fixedShare        = array_sum($actualBonus);
        $variableEmployees = array_diff($parts, array_keys($actualBonus));
        $variableCount     = count($variableEmployees);
        $remaining         = $totalValue - $fixedShare;
        $baseShare         = $variableCount
                               ? round($remaining / $variableCount, 2)
                               : 0;

        $job = ExtraJob::findOrFail($id);
        $job->update([
            'title'      => $request->title,
            'totalValue' => $totalValue,
        ]);
        $job->employees()->detach();
        foreach ($parts as $empId) {
            if (isset($actualBonus[$empId])) {
                $assigned        = $actualBonus[$empId];
                $bonusAdjustment = $assigned - $baseShare;
            } else {
                $assigned        = $baseShare;
                $bonusAdjustment = 0;
            }
            $job->employees()->attach($empId, [
                'bonusAdjustment' => $bonusAdjustment,
                'assignedValue'   => $assigned,
            ]);
        }

        return redirect()->route('extras.index')
                         ->with('msg','Trabalho Extra atualizado.');
    }

    public function destroy($id)
    {
        ExtraJob::destroy($id);
        return redirect()->route('extras.index')
                         ->with('msg','Trabalho Extra removido.');
    }

    public function pdfAll()
    {
        $jobs = ExtraJob::with('employees')->orderByDesc('created_at')->get();
        $pdf  = PDF::loadView('Extras.extraJobs_pdf', compact('jobs'))
                   ->setPaper('a4','landscape');
        return $pdf->stream('ExtraJobs_All.pdf');
    }

    public function pdfShow($id)
    {
        $job = ExtraJob::with('employees')->findOrFail($id);
        $pdf = PDF::loadView('Extras.extraJob_pdf', compact('job'))
                  ->setPaper('a4','landscape');
        return $pdf->stream("ExtraJob_{$job->id}.pdf");
    }
}
