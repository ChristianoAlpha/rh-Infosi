<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Employeee;
use App\Models\Department;

class EmployeeeController extends Controller
{
    
    public function index()
    {
        // A variavel data, vai retvai retornar e passar todos os dados para a view

        $data = Employeee::orderByDesc('id', 'desc')->get();
        return view('employeee.index', ['data'=>$data]);
    }

  
    public function create()
    {
        //
        $data=Department::orderByDesc('id', 'desc')->get();
        return view('employeee.create', ['departments'=>$data]);
    }

  
    public function store(Request $request)
    {
        //request(pedido)
        $request->validate([
            'fullName'=>'required',
            'photo'=>'required|image|mimes:jpg,png,gif',
            'address'=>'required',
            'mobile'=>'required',
            'status'=>'required'

        ]);

        /*--para pegar a foto, usamos o rename photo, pois se o usuario tiver o mesmo nome pode gerar conflito então fizemos: $renamePhoto=time().$photo->getClientOriginalExtension();
        o  $dest=public_path('/images'); diz o destino no caminho publico a onde irão estas imagens e vão na pasta imagens.
        */

      
        $photo=$request->file('photo');
        $renamePhoto =time().$photo->getClientOriginalExtension();
        $dest=public_path('/images');
        $photo->move($dest, $renamePhoto);

        #codigo para guardar os dados criados
        $data=new Employeee();
        $data->departmentId=$request->depart;
        $data->fullName=$request->fullName;
        $data->photo=$renamePhoto;
        $data->address=$request->address;
        $data->mobile=$request->mobile;
        $data->status=$request->status;
        $data->save();

        return redirect('employeee/create')->with('msg', 'Dados submentidos com sucesso');
    }

  
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
