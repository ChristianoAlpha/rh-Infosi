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


    public function pdf($id)
{
    // Carregar o cargo e seus funcionários
    $position = Position::with('employeee')->findOrFail($id);

    // Carregar a view e gerar PDF
    $pdf = PDF::loadView('position.employeee_pdf', compact('position'));

    // Stream para a pagina/Download para baixar direito
    return $pdf->stream('RelatorioCargo.pdf');
}

public function pdfAll()
{
    $allPositions = Position::all();
    $pdf = PDF::loadView('position.position_all_pdf', compact('allPositions'));
    return $pdf->stream('RelatorioTodosCargos.pdf');
}



    public function destroy($id)
    {
        Position::where('id', $id)->delete();
        return redirect('positions');
    }
}