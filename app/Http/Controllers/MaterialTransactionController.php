<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MaterialTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class MaterialTransactionController extends Controller
{
    /**
     * Exibe o histórico de transações (entrada + saída) filtrado por categoria,
     * data e tipo.
     */
    public function index(Request $request, $category)
    {
        $query = MaterialTransaction::whereHas('material', fn($q) => $q->where('Category', $category))
            ->with(['material', 'department', 'creator']);

        // filtros por data e tipo
        if ($request->filled('startDate')) {
            $query->whereDate('TransactionDate', '>=', $request->startDate);
        }
        if ($request->filled('endDate')) {
            $query->whereDate('TransactionDate', '<=', $request->endDate);
        }
        if ($request->filled('type') && in_array($request->type, ['in', 'out'])) {
            $query->where('TransactionType', $request->type);
        }

        $txs = $query->orderByDesc('TransactionDate')->get();

        return view('material_transactions.index', compact('txs', 'category'));
    }

    /**
     * Exibe o formulário para registrar uma entrada ou saída.
     * O segmento 3 da URL deve ser "in" ou "out".
     */
    public function create(Request $request, $category)
    {
        $type      = $request->segment(3); // "in" ou "out"
        $materials = Material::where('Category', $category)->get();

        return view('material_transactions.create', compact('materials', 'category', 'type'));
    }

    /**
     * Armazena a transação (entrada ou saída), ajusta o estoque do material
     * e registra quem fez e de qual departamento.
     */
    public function store(Request $request, $category)
    {
        $type = $request->segment(3); // "in" ou "out"

        $request->validate([
            'MaterialId'      => 'required|exists:materials,id',
            'TransactionDate' => 'required|date',
            'Quantity'        => 'required|integer|min:1',
            'Notes'           => 'nullable|string',
        ]);

        // Buscar o material e atualizar o estoque
        $m     = Material::findOrFail($request->MaterialId);
        $delta = $type === 'in' ? $request->Quantity : -$request->Quantity;
        $m->increment('CurrentStock', $delta);

        // Obter o departamento do usuário logado (Employeee é o próprio usuário)
        $user = Auth::user();
        if (! $user->departmentId) {
            return redirect()->back()
                             ->with('error', 'Não foi possível identificar seu departamento.');
        }

        // Criar a transação
        MaterialTransaction::create([
            'MaterialId'         => $m->id,
            'TransactionType'    => $type,
            'TransactionDate'    => $request->TransactionDate,
            'Quantity'           => $request->Quantity,
            'SupplierName'       => $type === 'in' ? $m->SupplierName : null,
            'SupplierIdentifier' => $type === 'in' ? $m->SupplierIdentifier : null,
            'DepartmentId'       => $user->departmentId,
            'CreatedBy'          => Auth::id(),
            'Notes'              => $request->Notes,
        ]);

        return redirect()
            ->route('materials.transactions.index', ['category' => $m->Category])
            ->with('msg', 'Transação registrada com sucesso.');
    }

    /**
     * Gera e faz download do PDF de entradas.
     */
    public function reportIn(Request $request, $category)
    {
        $txs = MaterialTransaction::where('TransactionType', 'in')
            ->whereHas('material', fn($q) => $q->where('Category', $category))
            ->with(['material', 'department', 'creator'])
            ->orderByDesc('TransactionDate')
            ->get();

        return Pdf::loadView('material_transactions.report-in', compact('txs', 'category'))
            ->setPaper('a4', 'landscape')
            ->stream("Entradas_{$category}.pdf");
    }

    /**
     * Gera e faz download do PDF de saídas.
     */
    public function reportOut(Request $request, $category)
    {
        $txs = MaterialTransaction::where('TransactionType', 'out')
            ->whereHas('material', fn($q) => $q->where('Category', $category))
            ->with(['material', 'department', 'creator'])
            ->orderByDesc('TransactionDate')
            ->get();

        return Pdf::loadView('material_transactions.report-out', compact('txs', 'category'))
            ->setPaper('a4', 'landscape')
            ->stream("Saidas_{$category}.pdf");
    }

    /**
     * Gera e faz download do PDF de todas as transações.
     */
    public function reportAll(Request $request, $category)
    {
        $txs = MaterialTransaction::whereHas('material', fn($q) => $q->where('Category', $category))
            ->with(['material', 'department', 'creator'])
            ->orderByDesc('TransactionDate')
            ->get();

        return Pdf::loadView('material_transactions.report-all', compact('txs', 'category'))
            ->setPaper('a4', 'landscape')
            ->stream("TodasTransacoes_{$category}.pdf");
    }
}

$columns = [
    'Nome do Material' => 'name',
    'Quantidade' => 'quantity',
    'Preço Unitário' => 'unit_price',
    'Data de Entrada' => function($result) {
        return \Carbon\Carbon::parse($result->created_at)->format('d/m/Y');
    },
];