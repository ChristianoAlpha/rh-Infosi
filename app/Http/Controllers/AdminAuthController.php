<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Employeee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class AdminAuthController extends Controller
{
    // Lista todos os administradores
    public function index()
    {
        $admins = Admin::with('employee')->orderBy('id')->get();
        return view('admins.index', compact('admins'));
    }

    // Exibe o formulário para criar um novo administrador
    public function create()
    {
        // Se desejar vincular um funcionário, busque os funcionários
        $employees = Employeee::orderBy('fullName')->get();
        return view('admins.create', compact('employees'));
    }

    // Armazena o novo administrador
    public function store(Request $request)
    {
        $request->validate([
            'employeeId' => 'nullable|exists:employeees,id',
            'role'       => 'required|in:admin,director,department_head,employee',
            'email'      => 'required|email|unique:admins,email',
            'password'   => 'required|min:6|confirmed',
        ]);

        Admin::create([
            'employeeId' => $request->employeeId,
            'role'       => $request->role,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

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
}
