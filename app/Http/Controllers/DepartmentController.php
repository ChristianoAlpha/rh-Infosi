<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

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
            'title'=>'required'
        ]);

        #codigo para guardar os dados criados
        $data=new Department();
        $data->title=$request->title;
        $data->save();

        #mensagem que será direcionada a pagina depart/create
        return redirect('depart/create')->with('msg' , 'Dados Submetidos com Sucesso' );
    }

  
    public function show($id)
    {
        $data=Department::find($id);
        return view('department.show', ['data'=>$data]); 
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
        'title'=>'required'
        ]);

        #codigo para guardar os dados criados
        $data=Department::find($id);
        $data->title=$request->title;
        $data->save();

        #mensagem que será direcionada a pagina depart/create
        return redirect('depart/'.$id. '/edit' )->with('msg' , 'Dados Submetidos com Sucesso' );
    }

    

  
    public function destroy($id)
    {
        //Para Deletar o Departamento
        Department::where('id', $id)->delete();
        return redirect('depart');

    }
}
