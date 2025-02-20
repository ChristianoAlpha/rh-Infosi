<?php

namespace App\Http\Controllers;


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
        //Ordenar por ordem decrescente
        $data=Department::orderByDesc('id', 'desc')->get();


            $departments = Department::all();
            $positions = Position::all();
            $specialties = Specialty::all(); 
            return view('employeee.create', [
            'departments' => $departments,
            'positions' => $positions, 
            'specialties' => $specialties 
        ]);
    }

  
    public function store(Request $request)
    {
        //request(pedido)
        $request->validate([
            'depart' => 'required',
            'fullName' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'bi' => 'required|unique:employeees',
            'birth_date'   => 'required|date|date_format:Y-m-d|before_or_equal:today|after_or_equal:' . \Carbon\Carbon::now()->subYears(120)->format('Y-m-d'),
            'nationality' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:employeees',
            'positionId' => 'required|exists:positions,id',
            'specialtyId' => 'required|exists:specialties,id'
        ],[
            'birth_date.date_format'     => 'A data de nascimento deve estar no formato AAAA-MM-DD.',
            'birth_date.before_or_equal' => 'A data de nascimento não pode ser superior a data atual. Insira uma data igual ou anterior a hoje.',
            'birth_date.after_or_equal'  => 'A data de nascimento informada é inválida.',
        ]);

        

        /*--para pegar a foto, usamos o rename photo, pois se o usuario tiver o mesmo nome pode gerar conflito então fizemos: $renamePhoto=time().$photo->getClientOriginalExtension();
        o  $dest=public_path('/images'); diz o destino no caminho publico a onde irão estas imagens e vão na pasta imagens.
        */
            /*
        $photo=$request->file('photo');
        $renamePhoto =time(). '.' .$photo->getClientOriginalExtension();
        $dest=public_path('/images');
        $photo->move($dest, $renamePhoto);
        $data->photo = $renamePhoto;
        */
        #codigo para guardar os dados criados
        $data = new Employeee();
        $data->departmentId = $request->depart;
        $data->fullName = $request->fullName;
        $data->address = $request->address;
        $data->mobile = $request->mobile;
        $data->father_name = $request->father_name;
        $data->mother_name = $request->mother_name;
        $data->bi = $request->bi;
        $data->birth_date = $request->birth_date;
        $data->nationality = $request->nationality;
        $data->gender = $request->gender;
        $data->email = $request->email;
        $data->positionId = $request->positionId;
        $data->specialtyId = $request->specialtyId;
        $data->save();

        return redirect('employeee/create')->with('msg', 'Dados submentidos com sucesso');
    }

  
    public function show($id)
    {

        // Busca o funcionário pelo ID
        $data = Employeee::find($id);

        // Retorna a view 'employeee.show' passando os dados do funcionário
        return view('employeee.show', ['data' => $data]);
        


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
    $data = Employeee::find($id);
    $positions = Position::all();       
    $specialties = Specialty::all();      

    return view('employeee.edit', [
        'departs'     => $departs,
        'data'        => $data,
        'positions'   => $positions,
        'specialties' => $specialties
    ]);

        
    }

    
    public function update(Request $request, $id)
    {
         //request(pedido)
         $request->validate([
            'depart' => 'required',
            'fullName' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'bi' => 'required|unique:employeees,bi,'.$id,
            'email' => 'required|email|unique:employeees,email,'.$id,
        ]);
    
        $data = Employeee::find($id); // Buscar o registro existente
        $data->departmentId = $request->depart;
        $data->fullName = $request->fullName;
        $data->address = $request->address;
        $data->mobile = $request->mobile;
        $data->save();

        /*if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $renamePhoto = time() . '.' . $photo->getClientOriginalExtension();
            $dest = public_path('/images');
            $photo->move($dest, $renamePhoto);
            $data->photo = $renamePhoto;
        }
        */
    
        return redirect()->route('employeee.edit', $id)->with('msg', 'Dados atualizados com sucesso');
    }

    public function destroy($id)
    {
        // //Para Deletar o Funcionario
        Employeee::where('id', $id)->delete();
        return redirect('employeee');
    }
}
