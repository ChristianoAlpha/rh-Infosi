<?php
//usarmos ou referencirmos um controller, devemos passar o caminho deste controller sempre
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SpecialtyController;



#Rotas da area Admin
Route::get('/', [AdminController::class, 'index']);
Route::get('admin/login', [AdminController::class, 'login']);
Route::post('admin/login', [AdminController::class, 'submit_login']);
Route::post('admin/logout', [AdminController::class, 'logout']);





/*Rotas relacionadas ao departamento.(todo funcionario pertence a um departamento)

Route::resource('nome_da_referencia', Nome_do_controladorController::class);
é uma forma rápida de criar todas as rotas básicas para operações CRUD (Criar, Ler, Atualizar, Deletar) para um recurso, no caso, o "departamento". */




#caminhos employeee aulas 
Route::resource('employeee', EmployeeeController::class);
#rota para deletar um departamento
Route::get('employeee/{id}/delete', [EmployeeeController::class, 'destroy']);

#rota para listar funcionarios pertencentes a um determinado departamento
Route::get('depart/employeee', [DepartmentController::class, 'employeee'])->name('depart.employeee');

#rota para deletar um departamento
Route::resource('depart', DepartmentController::class);
Route::get('depart/{id}/delete', [DepartmentController::class, 'destroy']);



#caminhos Cargos  
Route::resource('positions', PositionController::class);
Route::get('positions/{id}/delete', [PositionController::class, 'destroy']);

#caminhos Especialidades 
Route::resource('specialties', SpecialtyController::class);
Route::get('specialties/{id}/delete', [SpecialtyController::class, 'destroy']);

#rota para a geração de pdf.
Route::get('depart/{departmentId}/pdf', [DepartmentController::class, 'employeeePdf'])
     ->name('depart.employeee.pdf');