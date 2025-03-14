<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class DepartmentController extends Controller
{

    //função para ver todos os departamentos.
    public function index()
    {
        #Aqui é a onde vai aparecer os departamentos todos
        #a variavel $data vai pegar em todos os dados em departamentos e organizar em ordem decrescente(orderBydesc) e pegar  pelo Id .

        $data=Department::orderByDesc('id', 'desc')->get();

        #vai retornar e passar todos os dados para a view
        return view('department.index', ['data'=>$data]);
    }

   
    public function create()
    {
        return view('department.create');
    }

    
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'description' => 'nullable',
    ]);

    $data = new Department();
    $data->title = $request->title;
    $data->description = $request->description;
    $data->save();

    return redirect('depart/create')->with('msg', 'Dados Submetidos com Sucesso');
}
  
    public function show($id)
    {
        $data = Department::findOrFail($id);
        return view('department.show', compact('data'));
    }
    


    //listagem de funcionarios que são pertencentes a um determinado departamento
    public function employeee(Request $request)
    {
        // aqui Obtém o ID do departamento enviado via formulário
        $departmentId = $request->input('department');

        // Carrega o departamento com seus funcionários usando o relacionamento "employeee" que vem da Model
        $department = Department::with('employeee')->findOrFail($departmentId);

        return view('department.employeee', compact('department'));
    }
    


    public function edit($id)
    {
        //para o metodo show tiramos daqui no editar. editar os dados
        $departs=Department::find($id);
        return view('department.edit', ['data'=>$departs]); 
    }

   
    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'description' => 'nullable',
    ]);

    $data = Department::find($id);
    $data->title = $request->title;
    $data->description = $request->description; // Atualiza a descrição
    $data->save();

    return redirect('depart/'.$id.'/edit')->with('msg', 'Dados Submetidos com Sucesso');
}


public function employeeePdf($departmentId)
{
    // Carrega o departamento com seus funcionários
    $department = Department::with('employeee')->findOrFail($departmentId);

    // Gera o PDF a partir da view 'department.employeee_pdf'
    $pdf = PDF::loadView('department.employeee_pdf', compact('department'));


    // Você pode exibir diretamente no navegador stream e fazer download:
    return $pdf->stream('RelatorioDepartamento.pdf');
}



  
    public function destroy($id)
    {
        Department::where('id', $id)->delete();
        return redirect('depart');

    }
}
