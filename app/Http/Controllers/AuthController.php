<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
       

class AuthController extends Controller
{
    // Exibe o formulário de login
    public function showLoginForm()
    {
        // Se já estiver logado, redireciona para a minha  dashboard
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.login'); 
       
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

        // Tenta autenticar com guard web, cortesia dada pelo Laravel Sactum
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Se der certo, para redirecionar para a minha dashboard
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
