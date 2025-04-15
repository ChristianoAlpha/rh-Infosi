<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Department;
use App\Models\Employeee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class AdminAuthController extends Controller
{
    // Lista todos os administradores com opção de filtrar por nome do funcionário vinculado
    public function index(Request $request)
    {
        $search = $request->get('search');
    
        // Inicia a query com carregamento da relação 'employee'
        $query = \App\Models\Admin::with('employee');
    
        // Se o usuário logado for chefe de departamento ou funcionário, filtra para excluir administradores do tipo "director"
        if (auth()->user()->role === 'department_head' || auth()->user()->role === 'employee') {
            $query->where('role', '<>', 'director');
        }
    
        // Caso haja o parâmetro de pesquisa, filtra os administradores pela propriedade fullName do empregado vinculado
        if ($search) {
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('fullName', 'like', '%' . $search . '%');
            });
        }
    
        $admins = $query->orderBy('id')->get();
    
        return view('admins.index', compact('admins'));
    }
    

    // Exibe o formulário para criar um novo administrador
    public function create()
    {
        $employees = Employeee::whereDoesntHave('admin')
            ->orderBy('fullName')
            ->get();
        $departments = Department::orderBy('title')->get();
        return view('admins.create', compact('employees', 'departments'));
    }

    // Armazena o novo administrador
    public function store(Request $request)
    {
        $request->validate([
            'employeeId'            => 'nullable|exists:employeees,id',
            'role'                  => 'required|in:admin,director,department_head,employee',
            'email'                 => 'required|email|unique:admins,email',
            'password'              => 'required|min:6|confirmed',
            // Validações para chefe de departamento
            'photo'                 => 'nullable|image|max:2048',
            'department_id'         => 'nullable|required_if:role,department_head|exists:departments,id',
            'department_head_name'  => 'nullable|string|max:255',
        ]);

        $data = new Admin();
        $data->employeeId = $request->employeeId;
        $data->role = $request->role;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);

        // Lógica para Chefe de Departamento
        if ($request->role == 'department_head') {
            $data->department_id = $request->department_id;
            if ($request->hasFile('photo')) {
                $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();
                $request->file('photo')->move(public_path('frontend/images/departments'), $photoName);
                $data->photo = $photoName;
            }
        }

        // Lógica para Diretor
        if ($request->role == 'director') {
            $request->validate([
                'directorType'  => 'required|in:directorGeneral,directorTechnical,directorAdministrative',
                'directorName'  => 'nullable|string|max:255',
                'directorPhoto' => 'nullable|image|max:2048',
            ]);

            $data->directorType = $request->directorType;

            // Se não informar um nome customizado, tenta usar o nome do funcionário vinculado
            $directorName = $request->directorName;
            if (!$directorName && $data->employee) {
                $directorName = $data->employee->fullName;
            }
            $data->directorName = $directorName;

            if ($request->hasFile('directorPhoto')) {
                $photoName = time() . '_' . $request->file('directorPhoto')->getClientOriginalName();
                $request->file('directorPhoto')->move(public_path('frontend/images/directors'), $photoName);
                $data->photo = $photoName;
                $data->directorPhoto = $photoName;
            }
        }

        $data->save();

        // Se o cargo for Diretor, atualiza o funcionário vinculado removendo o vínculo com o departamento
        if ($data->role == 'director' && $data->employeeId) {
            $employee = Employeee::find($data->employeeId);
            if ($employee) {
                $employee->departmentId = null;
                $employee->save();
            }
        }

        // Se for Chefe de Departamento, atualiza os dados do Departamento
        if ($data->role == 'department_head' && $data->department_id) {
            $department = Department::find($data->department_id);
            if ($department) {
                $headName = $request->department_head_name;
                if (!$headName && $data->employee) {
                    $headName = $data->employee->fullName;
                }
                $department->department_head_name = $headName;
                $department->head_photo = $data->photo;
                $department->save();
            }
        }

        return redirect()->route('admins.index')->with('msg', 'Administrador criado com sucesso!');
    }

    // Mostra os detalhes do administrador
    public function show($id)
    {
        $admin = Admin::with('employee')->findOrFail($id);
        return view('admins.show', compact('admin'));
    }

    // Exibe o formulário para editar um administrador
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $employees = Employeee::orderBy('fullName')->get();
        return view('admins.edit', compact('admin', 'employees'));
    }

    // Atualiza os dados do administrador
    public function update(Request $request, $id)
    {
        $request->validate([
            'employeeId' => 'nullable|exists:employeees,id',
            'role'       => 'required|in:admin,director,department_head,employee',
            'email'      => 'required|email|unique:admins,email,' . $id,
            'password'   => 'nullable|min:6|confirmed',
        ]);

        $admin = Admin::findOrFail($id);
        $admin->employeeId = $request->employeeId;
        $admin->role = $request->role;
        $admin->email = $request->email;
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        // Se for Diretor, remove o vínculo do funcionário com o departamento
        if ($admin->role == 'director' && $admin->employeeId) {
            $employee = Employeee::find($admin->employeeId);
            if ($employee) {
                $employee->departmentId = null;
                $employee->save();
            }
        }

        return redirect()->route('admins.edit', $id)->with('msg', 'Administrador atualizado com sucesso!');
    }

    // Remove o administrador
    public function destroy($id)
    {
        Admin::destroy($id);
        return redirect()->route('admins.index')->with('msg', 'Administrador removido com sucesso!');
    }

    // Método de login usando o guard 'admin'
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            $token = $admin->createToken('auth_token')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'token_type'   => 'Bearer',
            ]);
        }
        return response()->json(['error' => 'Credenciais inválidas'], 401);
    }

    // Método para gerar o contrato do funcionário (PDF) a partir do administrador (somente para role 'employee')
    public function contractPdf($id)
    {
        $admin = Admin::with('employee.department')->findOrFail($id);
        if (!$admin->employee) {
            abort(404, 'Funcionário não vinculado ao administrador.');
        }
        $pdf = PDF::loadView('admins.contract_pdf', compact('admin'))
                  ->setPaper('a4', 'portrait');
        return $pdf->stream("Contrato_Admin_{$admin->id}.pdf");
    }
}
