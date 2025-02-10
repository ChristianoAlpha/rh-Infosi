<?php
//usarmos ou referencirmos um controller, devemos passar o caminho deste controller sempre
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AdminController;




Route::get('/laravel', function () {
    
    return view('welcome');
});

#Rotas da area Admin
Route::get('admin', [AdminController::class, 'index']);
Route::get('admin/login', [AdminController::class, 'login']);
Route::post('admin/login', [AdminController::class, 'submit_login']);
Route::post('admin/logout', [AdminController::class, 'logout']);

//Rotas relacionadas ao departamento.(todo funcionario pertence a um departamento)
Route::resource('depart', DepartmentController::class);
