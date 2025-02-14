<?php
//usarmos ou referencirmos um controller, devemos passar o caminho deste controller sempre
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeeController;



#Rotas da area Admin
Route::get('/', [AdminController::class, 'index']);
Route::get('admin/login', [AdminController::class, 'login']);
Route::post('admin/login', [AdminController::class, 'submit_login']);
Route::post('admin/logout', [AdminController::class, 'logout']);





// Exibe o formulário de cadastro de funcionário
Route::get('employee/create', [EmployeeController::class, 'create']);

// Processa o formulário e salva os dados
Route::post('employee', [EmployeeController::class, 'store']);









/*Rotas relacionadas ao departamento.(todo funcionario pertence a um departamento)

Route::resource('nome_da_referencia', Nome_do_controladorController::class);
é uma forma rápida de criar todas as rotas básicas para operações CRUD (Criar, Ler, Atualizar, Deletar) para um recurso, no caso, o "departamento". */

Route::resource('depart', DepartmentController::class);
#rota para deletar um departamento
Route::get('depart/{id}/delete', [DepartmentController::class, 'destroy']);


#caminhos employeee aulas 

Route::resource('employeee', EmployeeeController::class);
#rota para deletar um departamento
Route::get('employeee/{id}/delete', [EmployeeeController::class, 'destroy']);