<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialType;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $category  = $request->get('category');
        $materials = Material::where('Category', $category)->get();
        return view('materials.index', compact('materials','category'));
    }

    public function create(Request $request)
    {
        $category = $request->get('category');
        $types    = MaterialType::all();
        return view('materials.create', compact('category','types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Category'           => 'required|in:infraestrutura,servicos_gerais',
            'MaterialTypeId'     => 'required|exists:material_types,id',
            'Name'               => 'required',
            'SerialNumber'       => 'required|unique:materials,SerialNumber',
            'Model'              => 'required',
            'ManufactureDate'    => 'required|date',
            'SupplierName'       => 'required',
            'SupplierIdentifier' => 'required',
            'EntryDate'          => 'required|date',
            'CurrentStock'       => 'required|integer|min:0',
            'Notes'              => 'nullable',
        ]);

        Material::create($data);

        return redirect()
            ->route('materials.index', ['category'=>$data['Category']])
            ->with('msg','Material cadastrado com sucesso.');
    }

    public function edit($id, Request $r)
    {
        $material = Material::findOrFail($id);
        $category = $r->get('category',$material->Category);
        $types    = MaterialType::orderBy('name')->get();
        return view('materials.edit', compact('material','category','types'));
    }

    public function update(Request $r, $id)
    {
        $m = Material::findOrFail($id);
        $r->validate([
            'Name'            =>'required|string',
            'MaterialTypeId'  =>'required|exists:materialTypes,id',
            'Model'           =>'required|string',
            'ManufactureDate' =>'required|date',
        ]);
        $m->update($r->only([
            'Name','MaterialTypeId','Model',
            'ManufactureDate','Notes'
        ]));
        return redirect()->route('materials.index',['category'=>$m->Category])
                         ->with('msg','Material atualizado.');
    }

    public function destroy($id)
    {
        $m = Material::findOrFail($id);
        $cat = $m->Category;
        $m->delete();
        return redirect()->route('materials.index',['category'=>$cat])
                         ->with('msg','Material removido.');
    }
}
