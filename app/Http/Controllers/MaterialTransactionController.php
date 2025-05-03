<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialTransactionController extends Controller
{
    public function index(Request $request, $category)
    {
        $query = MaterialTransaction::whereHas('material', fn($q) => $q->where('Category',$category))
            ->with(['material.type','department','creator']);

        if ($request->filled('startDate')) {
            $query->whereDate('TransactionDate','>=',$request->startDate);
        }
        if ($request->filled('endDate')) {
            $query->whereDate('TransactionDate','<=',$request->endDate);
        }
        if ($request->filled('type')) {
            $query->where('TransactionType',$request->type);
        }

        $txs = $query->orderByDesc('TransactionDate')->get();
        return view('material_transactions.index', compact('txs','category'));
    }

    protected function form($category, $type)
    {
        $materials = Material::where('Category',$category)
                             ->with('type')
                             ->get();
        return view('material_transactions.create', compact('materials','category','type'));
    }

    public function createIn($category)  { return $this->form($category,'in'); }
    public function createOut($category) { return $this->form($category,'out'); }

    protected function storeTx(Request $r, $category, $type)
    {
        $data = $r->validate([
            'MaterialId'            => 'required|exists:materials,id',
            'TransactionDate'       => 'required|date',
            'Quantity'              => 'required|integer|min:1',
            'OriginOrDestination'   => 'required|string',
            'DocumentationPath'     => 'nullable|file|mimes:jpg,png,pdf|max:5120',
            'Notes'                 => 'nullable|string',
        ]);

        $mat   = Material::findOrFail($data['MaterialId']);
        $delta = $type==='in' ? $data['Quantity'] : -$data['Quantity'];
        $mat->increment('CurrentStock',$delta);

        if ($r->hasFile('DocumentationPath')) {
            $data['DocumentationPath'] = $r->file('DocumentationPath')
                                         ->store('material_docs','public');
        }

        $data += [
            'TransactionType' => $type,
            'DepartmentId'    => Auth::user()->employee->departmentId,
            'CreatedBy'       => Auth::id(),
        ];

        MaterialTransaction::create($data);

        return redirect()
            ->route('materials.transactions.index',['category'=>$category])
            ->with('msg','Transação registrada com sucesso.');
    }

    public function storeIn(Request $r,$category)  { return $this->storeTx($r,$category,'in'); }
    public function storeOut(Request $r,$category) { return $this->storeTx($r,$category,'out'); }

    public function reportIn($category)
    {
        $txs = MaterialTransaction::where('TransactionType','in')
            ->whereHas('material',fn($q)=>$q->where('Category',$category))
            ->with(['material.type','department','creator'])
            ->orderByDesc('TransactionDate')
            ->get();

        return Pdf::loadView('material_transactions.report-in', compact('txs','category'))
                  ->setPaper('a4','landscape')
                  ->stream("Entradas_{$category}.pdf");
    }

    public function reportOut($category)
    {
        $txs = MaterialTransaction::where('TransactionType','out')
            ->whereHas('material',fn($q)=>$q->where('Category',$category))
            ->with(['material.type','department','creator'])
            ->orderByDesc('TransactionDate')
            ->get();

        return Pdf::loadView('material_transactions.report-out', compact('txs','category'))
                  ->setPaper('a4','landscape')
                  ->stream("Saidas_{$category}.pdf");
    }

    public function reportAll($category)
    {
        $txs = MaterialTransaction::whereHas('material',fn($q)=>$q->where('Category',$category))
            ->with(['material.type','department','creator'])
            ->orderByDesc('TransactionDate')
            ->get();

        return Pdf::loadView('material_transactions.report-all', compact('txs','category'))
                  ->setPaper('a4','landscape')
                  ->stream("TodasTransacoes_{$category}.pdf");
    }
}
