<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Employeee;
use App\Models\Department;
use App\Models\Position;
use App\Models\Specialty;

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


            $departments = Department::all();
            $positions = Position::all(); // Novo
            $specialties = Specialty::all(); // Novo
        return view('employeee.create', [
            'departments' => $departments,
            'positions' => $positions, // Passar para a view
            'specialties' => $specialties // Passar para a view
        ]);
    }

  
    public function store(Request $request)
    {
        //request(pedido)
        $request->validate([
            'depart'=>'required',
            'fullName'=>'required',
            'photo'=>'required|image|mimes:jpg,png,gif',
            'address'=>'required',
            'mobile'=>'required',
            'status'=>'required',
            'bi' => 'required|unique:employeees',
            'email' => 'required|email|unique:employeees',
            'position_id' => 'required|exists:positions,id',
            'specialty_id' => 'required|exists:specialties,id'

        ]);

        /*--para pegar a foto, usamos o rename photo, pois se o usuario tiver o mesmo nome pode gerar conflito então fizemos: $renamePhoto=time().$photo->getClientOriginalExtension();
        o  $dest=public_path('/images'); diz o destino no caminho publico a onde irão estas imagens e vão na pasta imagens.
        */

      
        $photo=$request->file('photo');
        $renamePhoto =time(). '.' .$photo->getClientOriginalExtension();
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
        /*
            * Exibe o formulário de edição para o registro selecionado.
            *   Recupera a lista completa de registros ordenados por ID de forma decrescente
                e busca o registro específico com base no ID fornecido, passando ambos os
                conjuntos de dados para a view 'employeee.edit'.
        */
        $departs = Department::orderByDesc('id', 'desc')->get();
        $data=Employeee::find($id);
        return view('employeee.edit', ['departs'=>$departs, 'data'=>$data]);
    }

    
    public function update(Request $request, $id)
    {
        //
         //request(pedido)
         $request->validate([
            'depart' => 'required',
            'fullName' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'status' => 'required',
            'bi' => 'required|unique:employeees,bi,'.$id,
            'email' => 'required|email|unique:employeees,email,'.$id,
        ]);
    
        $data = Employeee::find($id); // Buscar o registro existente
    
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $renamePhoto = time() . '.' . $photo->getClientOriginalExtension();
            $dest = public_path('/images');
            $photo->move($dest, $renamePhoto);
            $data->photo = $renamePhoto;
        }
    
        $data->departmentId = $request->depart;
        $data->fullName = $request->fullName;
        $data->address = $request->address;
        $data->mobile = $request->mobile;
        $data->status = $request->status;
        $data->save();
    
        return redirect()->route('employeee.edit', $id)->with('msg', 'Dados atualizados com sucesso');
    }

    
    public function destroy($id)
    {
        // //Para Deletar o Funcionario
        Employeee::where('id', $id)->delete();
        return redirect('employeee');
    }
}
