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
        $data->save();

        return redirect('specialties/create')->with('msg', 'Especialidade criada!');
    }

    // ... (show, edit, update - siga o mesmo padrão do PositionController)

    public function destroy($id)
    {
        Specialty::where('id', $id)->delete();
        return redirect('specialties');
    }
}