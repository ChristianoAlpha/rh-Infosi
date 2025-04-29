<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;

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
        return view('materials.create', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name'               => 'required|string',
            'SerialNumber'       => 'required|string|unique:materials,SerialNumber',
            'Category'           => 'required|in:infraestrutura,servicos_gerais',
            'UnitOfMeasure'      => 'required|string',
            'SupplierName'       => 'required|string',
            'SupplierIdentifier' => 'required|string',
            'EntryDate'          => 'required|date',
            'CurrentStock'       => 'required|integer|min:0',
        ]);

        Material::create($request->only([
            'Name',
            'SerialNumber',
            'Category',
            'UnitOfMeasure',
            'SupplierName',
            'SupplierIdentifier',
            'EntryDate',
            'CurrentStock',
            'Notes'
        ]));
        

        return redirect()
            ->route('materials.index', ['category' => $request->Category])
            ->with('msg','Material cadastrado com sucesso.');
    }

        

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $request->validate([
            'Name'          => 'required|string',
            'UnitOfMeasure' => 'required|string',
            'Notes'         => 'nullable|string',
        ]);

        $material->update($request->only([
            'Name',
            'UnitOfMeasure',
            'Notes'
        ]));

        return redirect()
            ->route('materials.index', ['category' => $material->Category])
            ->with('msg','Material atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $category = $material->Category;
        $material->delete();

        return redirect()
            ->route('materials.index', ['category' => $category])
            ->with('msg','Material removido com sucesso.');
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