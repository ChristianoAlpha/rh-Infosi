<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specialty;

class SpecialtyController extends Controller
{
    public function index()
    {
        $data = Specialty::orderByDesc('id')->get();
        return view('specialty.index', ['data' => $data]);
    }

    public function create()
    {
        return view('specialty.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        
        $data = new Specialty();
        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();

        return redirect('specialties/create')->with('msg', 'Especialidade criada!');
    }

  
    public function show($id)
    {
        $data = Specialty::find($id);
        return view('specialty.show', ['data' => $data]);
    }

    public function edit($id)
    {
        $data = Specialty::find($id);
        return view('specialty.edit', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        
        $data = Specialty::find($id);
        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();

        return redirect('specialty/'.$id.'/edit')->with('msg', 'Cargo atualizado!');
    }


    public function destroy($id)
    {
        Specialty::where('id', $id)->delete();
        return redirect('specialties');
    }
}