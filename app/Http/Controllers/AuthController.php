<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Employeee;

class AuthController extends Controller
{
    // Exibe o formulário de login
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
        $email = $request->input('email');

        // Verifica se o e-mail pertence a um Admin
        $admin = Admin::where('email', $email)->first();
        if ($admin) {
            $status = Password::broker('admins')->sendResetLink(['email' => $email]);
            return $status === Password::RESET_LINK_SENT
                ? back()->with('status', __($status))
                : back()->withErrors(['email' => __($status)]);
        }

        // Senão, verifica se o e-mail pertence a um Employeee
        $employee = Employeee::where('email', $email)->first();
        if ($employee) {
            $status = Password::broker('employees')->sendResetLink(['email' => $email]);
            return $status === Password::RESET_LINK_SENT
                ? back()->with('status', __($status))
                : back()->withErrors(['email' => __($status)]);
        }

        // Se não encontrar o e-mail em nenhum dos providers
        return back()->withErrors(['email' => 'E-mail não encontrado.']);
    }

    // Exibe o formulário de redefinição de senha (o token é passado via URL)
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

        $email = $request->input('email');
        $broker = null;

        // Verifica se o e-mail pertence a um Admin
        if (Admin::where('email', $email)->exists()) {
            $broker = 'admins';
        } 
        // Senão, verifica se o e-mail pertence a um Employeee
        elseif (Employeee::where('email', $email)->exists()) {
            $broker = 'employees';
        }

        if (!$broker) {
            return back()->withErrors(['email' => 'E-mail não encontrado.']);
        }

        $status = Password::broker($broker)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
