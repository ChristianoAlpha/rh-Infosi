<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index(Request $r)
    {
        $cat = $r->get('category');
        $materials = Material::where('category',$cat)->get();
        return view('materials.index', compact('materials','cat'));
    }

    public function create(Request $r)
    {
        $cat = $r->get('category');
        return view('materials.create', compact('cat'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'name'=>'required',
            'category'=>'required|in:infraestrutura,servicos_gerais',
        ]);
        Material::create($r->all());
        return redirect()->route('materials.index', ['category'=>$r->category])
                         ->with('msg','Material cadastrado');
    }

    public function edit($id)
    {
        $m = Material::findOrFail($id);
        return view('materials.edit', compact('m'));
    }

    public function update(Request $r, $id)
    {
        $m = Material::findOrFail($id);
        $r->validate(['name'=>'required']);
        $m->update($r->only('name','description'));
        return redirect()->route('materials.index',['category'=>$m->category])
                         ->with('msg','Material atualizado');
    }

    public function destroy($id)
    {
        $m = Material::findOrFail($id);
        $cat = $m->category;
        $m->delete();
        return redirect()->route('materials.index',['category'=>$cat])
                         ->with('msg','Material removido');
    }
}