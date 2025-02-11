<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    // Exibe o formulário para adicionar um funcionário
    public function create()
    {
        return view('employee.loginemploye');

    }
    
    // Processa o formulário e salva o funcionário
    public function store(Request $request)
    {
        // Validação simples
        $validated = $request->validate([
            'name'         => 'required',
            'father'       => 'required',
            'mother'       => 'required',
            'adress'       => 'required',
            'bi'           => 'required',
            'birthDay'     => 'required',
            'nacionality'  => 'required',
            'genero'       => 'required',
            'email'        => 'required|email|unique:employees,email',
            'phone'        => 'nullable',
        ]);
        
        Employee::create($validated);
        
        return redirect()->back()->with('msg', 'Funcionário adicionado com sucesso!');
    }
}
