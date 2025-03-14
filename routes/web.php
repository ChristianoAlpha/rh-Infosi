<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeeController;
use App\Http\Controllers\EmployeeTypeController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\MobilityController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\VacationRequestController;
use App\Http\Controllers\SecondmentController;
use App\Http\Controllers\DepartmentHeadController;

/*
|--------------------------------------------------------------------------
| Rotas Login/Logout (Auth) - Laravel Sanctum
|--------------------------------------------------------------------------
*/
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rotas Protegidas pelo middleware 'auth'
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function() {

    // Rota principal do Dashboard
    Route::get('/', function() {
        return view('index'); // view principal do dashboard
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Funcionalidades Gerais - Acessíveis a TODOS os usuários autenticados
    |--------------------------------------------------------------------------
    */
    // Perfil: Todo usuário autenticado pode ver seu próprio perfil
    Route::get('my-profile', [EmployeeeController::class, 'myProfile'])->name('profile');

    /*
    |--------------------------------------------------------------------------
    | Módulo Funcionários (Employeee)
    |--------------------------------------------------------------------------
    */
    // Para o módulo de Funcionários, o controller filtra para que funcionários normais vejam somente seus próprios registros
    Route::get('employeee/pdf', [EmployeeeController::class, 'pdfAll'])->name('employeee.pdfAll');
    Route::resource('employeee', EmployeeeController::class);
    Route::get('employeee/{id}/delete', [EmployeeeController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Módulo Departamentos
    |--------------------------------------------------------------------------
    */
    Route::get('depart/{departmentId}/pdf', [DepartmentController::class, 'employeeePdf'])->name('depart.employeee.pdf');
    Route::get('depart/employeee', [DepartmentController::class, 'employeee'])->name('depart.employeee');
    Route::resource('depart', DepartmentController::class);
    Route::get('depart/{id}/delete', [DepartmentController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Módulo Cargos (Positions)
    |--------------------------------------------------------------------------
    */
    Route::get('positions/employeee', [PositionController::class, 'employeee'])->name('positions.employeee.filter');
    Route::get('positions/{positionId}/pdf', [PositionController::class, 'pdf'])->name('positions.employeee.pdf');
    Route::resource('positions', PositionController::class);
    Route::get('positions/{id}/delete', [PositionController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Módulo Especialidades (Specialties)
    |--------------------------------------------------------------------------
    */
    Route::get('specialties/employeee', [SpecialtyController::class, 'employeee'])->name('specialties.employeee.filter');
    Route::get('specialties/{specialtyId}/pdf', [SpecialtyController::class, 'pdf'])->name('specialties.pdf');
    Route::resource('specialties', SpecialtyController::class);
    Route::get('specialties/{id}/delete', [SpecialtyController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Módulo Estagiários (Intern)
    |--------------------------------------------------------------------------
    */
    Route::get('intern/pdf', [InternController::class, 'pdfAll'])->name('intern.pdfAll');
    Route::resource('intern', InternController::class);
    Route::get('intern/{id}/delete', [InternController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Módulo Mobilidade (Mobility)
    |--------------------------------------------------------------------------
    */
    Route::get('mobility/pdf', [MobilityController::class, 'pdfAll'])->name('mobility.pdfAll');
    Route::get('mobility/search-employee', [MobilityController::class, 'searchEmployee'])->name('mobility.searchEmployee');
    Route::resource('mobility', MobilityController::class);

    /*
    |--------------------------------------------------------------------------
    | Módulo Tipos de Licença (LeaveType)
    |--------------------------------------------------------------------------
    */
    Route::resource('leaveType', LeaveTypeController::class);
    Route::get('leaveType/{id}/delete', [LeaveTypeController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Módulo Pedido de Licença (LeaveRequest)
    |--------------------------------------------------------------------------
    */
    // Para funcionários, o controller filtra para exibir apenas os seus próprios pedidos
    Route::get('leaveRequest/pdf', [LeaveRequestController::class, 'pdfAll'])->name('leaveRequest.pdfAll');
    Route::get('leaveRequest/searchEmployee', [LeaveRequestController::class, 'searchEmployee'])->name('leaveRequest.searchEmployee');
    Route::resource('leaveRequest', LeaveRequestController::class);
    Route::get('leaveRequest/{id}/delete', [LeaveRequestController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Módulo Pedido de Férias (Vacation Request)
    |--------------------------------------------------------------------------
    */
    // No controller, se o usuário for funcionário ("employee"), apenas os seus registros são exibidos.
    // Para Admin, Diretor e Chefe, todos os registros são exibidos.
    Route::get('vacationRequest/searchEmployee', [VacationRequestController::class, 'searchEmployee'])->name('vacationRequest.searchEmployee');
    Route::get('vacationRequest/pdf', [VacationRequestController::class, 'pdfAll'])->name('vacationRequest.pdfAll');
    Route::resource('vacationRequest', VacationRequestController::class);
    Route::get('vacationRequest/{id}/delete', [LeaveRequestController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Módulo Secondment (Destacamento)
    |--------------------------------------------------------------------------
    */
    Route::get('secondment/searchEmployee', [SecondmentController::class, 'searchEmployee'])->name('secondment.searchEmployee');
    Route::get('secondment/pdf', [SecondmentController::class, 'pdfAll'])->name('secondment.pdfAll');
    Route::resource('secondment', SecondmentController::class);

    /*
    |--------------------------------------------------------------------------
    | Grupo de Chefe de Departamento
    | Rotas exclusivas para chefes de departamento: ver funcionários do seu departamento e gerenciar pedidos de férias
    |--------------------------------------------------------------------------
    */
    Route::prefix('department-head')->name('dh.')->group(function() {
        Route::get('my-employees', [DepartmentHeadController::class, 'myEmployees'])->name('myEmployees');
        Route::get('pending-vacations', [DepartmentHeadController::class, 'pendingVacations'])->name('pendingVacations');
        Route::post('approve/{id}', [DepartmentHeadController::class, 'approveVacation'])->name('approveVacation');
        Route::post('reject/{id}', [DepartmentHeadController::class, 'rejectVacation'])->name('rejectVacation');
    });

    /*
    |--------------------------------------------------------------------------
    | Rotas de Administradores
    | Rotas exclusivas para administradores (e diretores) para gerenciar usuários e outras configurações
    |--------------------------------------------------------------------------
    */
    Route::prefix('admins')->group(function () {
        Route::get('/', [AdminAuthController::class, 'index'])->name('admins.index');
        Route::get('/create', [AdminAuthController::class, 'create'])->name('admins.create');
        Route::post('/', [AdminAuthController::class, 'store'])->name('admins.store');
        Route::get('/{id}', [AdminAuthController::class, 'show'])->name('admins.show');
        Route::get('/{id}/edit', [AdminAuthController::class, 'edit'])->name('admins.edit');
        Route::put('/{id}', [AdminAuthController::class, 'update'])->name('admins.update');
        Route::delete('/{id}', [AdminAuthController::class, 'destroy'])->name('admins.destroy');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('admins.login');
    });

});
