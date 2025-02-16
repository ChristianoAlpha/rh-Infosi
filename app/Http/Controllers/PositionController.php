<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
    public function index()
    {
        $data = Position::orderByDesc('id')->get();
        return view('position.index', ['data' => $data]);
    }

    public function create()
    {
        return view('position.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        
        $data = new Position();
        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();

        return redirect('positions/create')->with('msg', 'Cargo criado!');
    }

    public function show($id)
    {
        $data = Position::find($id);
        return view('position.show', ['data' => $data]);
    }

    public function edit($id)
    {
        $data = Position::find($id);
        return view('position.edit', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        
        $data = Position::find($id);
        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();

        return redirect('positions/'.$id.'/edit')->with('msg', 'Cargo atualizado!');
    }

    public function destroy($id)
    {
        Position::where('id', $id)->delete();
        return redirect('positions');
    }
}