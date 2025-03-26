<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function showLoginForm()
    {
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

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('/'); 
        }

        return redirect()->back()->withErrors(['email' => 'Credenciais inválidas']);
    }

    // Faz logout
    public function logout()
    {
        Auth::logout();
        return redirect('login')->with('msg', 'Você saiu do sistema!');
    }

    // Exibe o formulário de recuperação de senha
    public function showForgotPasswordForm()
    {
        return view('auth.forgotPassword');
    }

    // Envia o link de redefinição de senha
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    // Exibe o formulário de redefinição de senha
    public function showResetForm($token)
    {
        return view('auth.resetPassword', ['token' => $token]);
    }

    // Processa a redefinição de senha
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
