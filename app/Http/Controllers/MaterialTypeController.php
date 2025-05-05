<?php

namespace App\Http\Controllers;

use App\Models\MaterialType;
use Illuminate\Http\Request;

class MaterialTypeController extends Controller
{
    public function index()
    {
        $types = MaterialType::orderBy('name')->get();
        return view('material_types.index', compact('types'));
    }

    public function create()
    {
        return view('material_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:material_types,name',
            'description' => 'nullable|string',
        ]);

        MaterialType::create($request->only(['name','description']));

        return redirect()
            ->route('material-types.index')
            ->with('msg','Tipo de Material cadastrado com sucesso.');
    }

    public function edit($id)
    {
        $type = MaterialType::findOrFail($id);
        return view('material_types.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:material_types,name,'.$id,
            'description' => 'nullable|string',
        ]);

        $type = MaterialType::findOrFail($id);
        $type->update($request->only(['name','description']));

        return redirect()
            ->route('material-types.index')
            ->with('msg','Tipo de Material atualizado com sucesso.');
    }

    public function destroy($id)
    {
        MaterialType::destroy($id);
        return redirect()
            ->route('material-types.index')
            ->with('msg','Tipo de Material removido.');
    }
}
