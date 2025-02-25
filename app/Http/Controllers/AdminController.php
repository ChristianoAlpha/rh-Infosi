<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    
    //função da area index do dashboard
    public function index(){

        return view('index');
    }

    //função da area login
    public function login(){

        return view('admin.login');
    }
     //função para submeter o login
     public function submit_login(Request $request){
        $request->validate([
            'username'=>'required',
            'password'=> 'required'
        ]);
        #codigo de checagem confirmar-se se a requisição feita se encontra na base de dados. senão, dá uma mensagem de erro que referenciamos na pagina de login.
        $checkAdmin=Admin::where(['username'=>$request->username, 'password'=>$request->password])->count();
        if($checkAdmin>0){
            session(['adminLogin', true]);
            return redirect('/');
        }else{
            return redirect('admin/login')->with('msg', 'Usuario/Palavra-passe Invalidos!');
        }
    }

    #area do Logout
    public function logout(){
        session()->forget('adminLogin');
        return redirect('admin/login');
    }
}
