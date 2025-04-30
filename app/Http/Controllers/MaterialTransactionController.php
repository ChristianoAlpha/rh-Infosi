<?php

// app/Http/Controllers/MaterialTransactionController.php

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
        $query = MaterialTransaction::whereHas('material', fn($q)=>$q->where('Category',$category))
            ->with(['material','department','creator']);

        if($request->filled('startDate')) {
            $query->whereDate('TransactionDate','>=',$request->startDate);
        }
        if($request->filled('endDate')) {
            $query->whereDate('TransactionDate','<=',$request->endDate);
        }

        $txs = $query->orderByDesc('TransactionDate')->get();
        return view('material_transactions.index', compact('txs','category'));
    }

    protected function form($category, $type)
    {
        $materials = Material::where('Category',$category)->get();
        return view('material_transactions.create', compact('materials','category','type'));
    }

    public function createIn($category)  { return $this->form($category,'in'); }
    public function createOut($category) { return $this->form($category,'out'); }

    protected function storeTx(Request $r, $category, $type)
    {
        $data = $r->validate([
            'MaterialId'          => 'required|exists:materials,id',
            'TransactionDate'     => 'required|date',
            'Quantity'            => 'required|integer|min:1',
            'OriginOrDestination' => 'required|string',
            'DocumentationPath'   => 'nullable|file',
            'Notes'               => 'nullable|string',
        ]);

        $mat   = Material::findOrFail($data['MaterialId']);
        $delta = $type==='in' ? $data['Quantity'] : -$data['Quantity'];
        $mat->increment('CurrentStock',$delta);

        $data['TransactionType'] = $type;
        $data['DepartmentId']    = Auth::user()->employee->departmentId;
        $data['CreatedBy']       = Auth::id();

        if($r->hasFile('DocumentationPath')) {
            $data['DocumentationPath'] = $r->file('DocumentationPath')->store('docs','public');
        }

        MaterialTransaction::create($data);

        return redirect()
            ->route('materials.transactions.index',['category'=>$category])
            ->with('msg','Transação registrada.');
    }

    public function storeIn(Request $r,$category)  { return $this->storeTx($r,$category,'in'); }
    public function storeOut(Request $r,$category) { return $this->storeTx($r,$category,'out'); }

    // PDFs
    public function reportIn($category)  { return $this->pdf('in',$category,'report-in'); }
    public function reportOut($category) { return $this->pdf('out',$category,'report-out'); }
    public function reportAll($category)
    {
        $txs = MaterialTransaction::with(['material','department','creator'])
            ->whereHas('material',fn($q)=>$q->where('Category',$category))
            ->orderByDesc('TransactionDate')->get();

        return Pdf::loadView('material_transactions.report-all',compact('txs','category'))
                  ->setPaper('a4','landscape')
                  ->stream("TodasTransacoes_{$category}.pdf");
    }

    protected function pdf($type,$cat,$view)
    {
        $txs = MaterialTransaction::where('TransactionType',$type)
            ->whereHas('material',fn($q)=>$q->where('Category',$cat))
            ->with(['material','department','creator'])
            ->orderByDesc('TransactionDate')->get();

        return Pdf::loadView("material_transactions.{$view}",compact('txs','cat'))
                  ->setPaper('a4','landscape')
                  ->stream(strtoupper($type)."__{$cat}.pdf");
    }
}
