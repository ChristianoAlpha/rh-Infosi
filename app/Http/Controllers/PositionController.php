<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Position;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class PositionController extends Controller
{
    public function index()
    {
        $data = Position::orderByDesc('id')->get();
        // Carrega todos os cargos para o filtro
        $allPositions = Position::all();
        return view('position.index', compact('data', 'allPositions'));
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


    public function pdf($positionId)
{
    $position = Position::with(['employees.department', 'employees.specialty'])->findOrFail($positionId);
    $pdf = PDF::loadView('position.employeee_pdf', compact('position'));
    return $pdf->stream('RelatorioCargo.pdf');
}

    

    public function pdfAll()
    {
        $allPositions = Position::all();
        $pdf = PDF::loadView('position.position_all_pdf', compact('allPositions'));
        return $pdf->stream('RelatorioTodosCargos.pdf');
    }

    public function employeee(Request $request)
{
    $positionId = $request->input('position');
    // Use "employees" no with()
    $position = Position::with(['employees.department', 'employees.specialty'])->findOrFail($positionId);
    return view('position.employeee', compact('position'));
}






    public function destroy($id)
    {
        Position::where('id', $id)->delete();
        return redirect('positions');
    }
}