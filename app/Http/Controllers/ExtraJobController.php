<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExtraJob;
use App\Models\Employeee;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ExtraJobController extends Controller
{
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
        // Normaliza totalValue
        $rawTotal  = $request->input('totalValue');
        $normTotal = str_replace('.', '', $rawTotal);
        $normTotal = str_replace(',', '.', $normTotal);
        $request->merge(['totalValue' => $normTotal]);

        // Normaliza bonus[]
        $rawBonus = $request->input('bonus', []);
        foreach ($rawBonus as $empId => $val) {
            $n = str_replace('.', '', $val);
            $n = str_replace(',', '.', $n);
            $normalizedBonus[$empId] = $n;
        }
        $request->merge(['bonus' => $normalizedBonus ?? []]);

        // Validação
        $request->validate([
            'title'        => 'required|string',
            'totalValue'   => 'required|numeric',
            'participants' => 'required|array|min:1',
            'bonus'        => 'nullable|array',
            'bonus.*'      => 'nullable|numeric',
        ]);

        // Extrai dados
        $totalValue = floatval($request->totalValue);
        $parts      = $request->participants;
        $bonus      = $request->bonus ?? [];

        // Filtra ajustes != 0
        $actualBonus = [];
        foreach ($parts as $empId) {
            $adj = floatval($bonus[$empId] ?? 0);
            if ($adj !== 0.0) {
                $actualBonus[$empId] = $adj;
            }
        }

        // Calcula fatias
        $fixedShare        = array_sum($actualBonus);
        $variableEmployees = array_diff($parts, array_keys($actualBonus));
        $variableCount     = count($variableEmployees);
        $remaining         = $totalValue - $fixedShare;
        $baseShare         = $variableCount
                               ? round($remaining / $variableCount, 2)
                               : 0;

        // Cria o ExtraJob
        $job = ExtraJob::create([
            'title'      => $request->title,
            'totalValue' => $totalValue,
        ]);

        // Anexa participantes
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
        // Normaliza totalValue
        $rawTotal  = $request->input('totalValue');
        $normTotal = str_replace('.', '', $rawTotal);
        $normTotal = str_replace(',', '.', $normTotal);
        $request->merge(['totalValue' => $normTotal]);

        // Normaliza bonus[]
        $rawBonus = $request->input('bonus', []);
        foreach ($rawBonus as $empId => $val) {
            $n = str_replace('.', '', $val);
            $n = str_replace(',', '.', $n);
            $normalizedBonus[$empId] = $n;
        }
        $request->merge(['bonus' => $normalizedBonus ?? []]);

        // Validação
        $request->validate([
            'title'        => 'required|string',
            'totalValue'   => 'required|numeric',
            'participants' => 'required|array|min:1',
            'bonus'        => 'nullable|array',
            'bonus.*'      => 'nullable|numeric',
        ]);

        // Extrai dados
        $job        = ExtraJob::findOrFail($id);
        $totalValue = floatval($request->totalValue);
        $parts      = $request->participants;
        $bonus      = $request->bonus ?? [];

        // Filtra ajustes != 0
        $actualBonus = [];
        foreach ($parts as $empId) {
            $adj = floatval($bonus[$empId] ?? 0);
            if ($adj !== 0.0) {
                $actualBonus[$empId] = $adj;
            }
        }

        // Recalcula fatias
        $fixedShare        = array_sum($actualBonus);
        $variableEmployees = array_diff($parts, array_keys($actualBonus));
        $variableCount     = count($variableEmployees);
        $remaining         = $totalValue - $fixedShare;
        $baseShare         = $variableCount
                               ? round($remaining / $variableCount, 2)
                               : 0;

        // Atualiza o ExtraJob
        $job->update([
            'title'      => $request->title,
            'totalValue' => $totalValue,
        ]);

        // Re-anexa participantes
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

    // PDF de todos os trabalhos
    public function pdfAll()
    {
        $jobs = ExtraJob::with('employees')->orderByDesc('created_at')->get();
        $pdf  = PDF::loadView('Extras.extraJobs_pdf', compact('jobs'))
                   ->setPaper('a4','portrait');
        return $pdf->stream('ExtraJobs_All.pdf');
    }

    // PDF de um trabalho específico
    public function pdfShow($id)
    {
        $job = ExtraJob::with('employees')->findOrFail($id);
        $pdf = PDF::loadView('Extras.extraJob_pdf', compact('job'))
                  ->setPaper('a4','portrait');
        return $pdf->stream("ExtraJob_{$job->id}.pdf");
    }
}
