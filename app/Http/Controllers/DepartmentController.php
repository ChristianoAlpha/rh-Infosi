<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * Funções da area Departamento
     *
     * @return \Illuminate\Http\Response
     */

    //função para ver todos os departamentos.
    public function index()
    {
        #Aqui é a onde vai aparecer os departamentos todos
        #a variavel $data vai pegar em todos os dados em departamentos e organizar em ordem decrescente(orderBydesc) e pegar  pelo Id .

        $data=Department::orderByDesc('id', 'desc')->get();

        #vai retornar e passar todos os dados para a view
        return view('department.index', ['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
      
        return view('department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title'=>'required'
        ]);
        #codigo para guardar os dados criados
        $data=new Department();
        $data->title=$request->title;
        $data->save();
        #mensagem que será direcionada a pagina depart/create
        
        return redirect('depart/create')->with('msg' , 'Data has been submitted (Dados já foram enviados)' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data=Department::find($id);
        return view('department.show', ['data'=>$data]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //para o metodo show tiramos daqui no editar. editar os dados
        $data=Department::find($id);
        return view('department.edit', ['data'=>$data]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    
        $request->validate([

        'title'=>'required'

        ]);
        #codigo para guardar os dados criados
        $data=Department::find($id);
        $data->title=$request->title;
        $data->save();
        #mensagem que será direcionada a pagina depart/create
        
        return redirect('depart/'.$id. '/edit' )->with('msg' , 'Data has been submitted (Dados já foram enviados)' );
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Department::where('id', $id)->delete();
        return redirect('depart');

    }
}
