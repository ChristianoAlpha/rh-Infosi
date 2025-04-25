<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MaterialTransaction;
use Illuminate\Support\Facades\Auth;

class MaterialTransactionController extends Controller
{
    public function create($type, Request $r)
    {
        $cat = $r->get('category');
        $materials = Material::where('category',$cat)->get();
        return view('material_transactions.create', compact('materials','type','cat'));
    }

    public function store($type, Request $r)
    {
        $r->validate([
            'materialId'=>'required|exists:materials,id',
            'quantity'=>'required|integer|min:1',
        ]);
        $m     = Material::findOrFail($r->materialId);
        $delta = $type==='in' ? $r->quantity : -$r->quantity;
        $m->increment('currentStock',$delta);

        MaterialTransaction::create([
            'materialId'=>$m->id,
            'transactionType'=>$type,
            'quantity'=>$r->quantity,
            'departmentId'=>Auth::user()->employee->departmentId,
            'createdBy'=>Auth::id(),
            'note'=>$r->note,
        ]);

        return redirect()->route('materials.index',['category'=>$m->category])
                         ->with('msg','Transação registrada');
    }

    public function index(Request $r)
    {
        $cat = $r->get('category');
        $txs = MaterialTransaction::whereHas('material', fn($q)=>$q->where('category',$cat))
                                   ->with(['material','department'])
                                   ->orderByDesc('created_at')
                                   ->get();
        return view('material_transactions.index', compact('txs','cat'));
    }
}