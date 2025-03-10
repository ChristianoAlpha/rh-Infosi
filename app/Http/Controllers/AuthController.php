<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // para Auth::attempt e Auth::logout
use App\Models\Admin;                // se seu Model principal é Admin

class AuthController extends Controller
{
    // Exibe o formulário de login
    public function showLoginForm()
    {
        // Se já estiver logado, redireciona para o dashboard
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.login'); 
        // Uma view "auth.login" que extende seu layout ou algo mais simples
    }

    // Processa o login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Informe um e-mail',
            'email.email'       => 'E-mail inválido',
            'password.required' => 'Informe a senha',
        ]);

        // Tenta autenticar com guard web
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Se der certo, redireciona para o dashboard
            return redirect('/'); 
        }

        // Se falhar, volta com erro
        return redirect()->back()->withErrors(['email' => 'Credenciais inválidas']);
    }

    // Faz logout
    public function logout()
    {
        Auth::logout();
        return redirect('login')->with('msg', 'Você saiu do sistema!');
    }
}
