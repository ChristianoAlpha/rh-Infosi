<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
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


// ====================== Rotas da Área Admin ======================
Route::get('/', [AdminController::class, 'index']);
Route::get('admin/login', [AdminController::class, 'login']);
Route::post('admin/login', [AdminController::class, 'submit_login']);
Route::post('admin/logout', [AdminController::class, 'logout']);

// ====================== Filtros por datas (Funcionários / Estagiários) ======================
// Funcionários
Route::get('employeee/filter', [EmployeeeController::class, 'filterByDate'])->name('employeee.filter');
Route::get('employeee/filter/pdf', [EmployeeeController::class, 'pdfFiltered'])->name('employeee.filter.pdf');
// Estagiários
Route::get('intern/filter', [InternController::class, 'filterByDate'])->name('intern.filter');
Route::get('intern/filter/pdf', [InternController::class, 'pdfFiltered'])->name('intern.filter.pdf');

// ====================== Rotas Para o Tipo de Funcionario (EmployeeTypeController) ======================
Route::resource('employeeType', EmployeeTypeController::class);


// ====================== Funcionários (Employeee) ======================
Route::get('employeee/pdf', [EmployeeeController::class, 'pdfAll'])->name('employeee.pdfAll');
Route::resource('employeee', EmployeeeController::class);
Route::get('employeee/{id}/delete', [EmployeeeController::class, 'destroy']);

// ====================== Departamentos ======================
Route::get('depart/{departmentId}/pdf', [DepartmentController::class, 'employeeePdf'])->name('depart.employeee.pdf');
Route::get('depart/employeee', [DepartmentController::class, 'employeee'])->name('depart.employeee');
Route::resource('depart', DepartmentController::class);
Route::get('depart/{id}/delete', [DepartmentController::class, 'destroy']);

// ====================== Cargos (Positions) ======================
Route::get('positions/employeee', [PositionController::class, 'employeee'])->name('positions.employeee.filter');
Route::get('positions/{positionId}/pdf', [PositionController::class, 'pdf'])->name('positions.employeee.pdf');
Route::resource('positions', PositionController::class);
Route::get('positions/{id}/delete', [PositionController::class, 'destroy']);

// ====================== Especialidades (Specialties) ======================
Route::get('specialties/employeee', [SpecialtyController::class, 'employeee'])->name('specialties.employeee.filter');
Route::get('specialties/{specialtyId}/pdf', [SpecialtyController::class, 'pdf'])->name('specialties.pdf');
Route::resource('specialties', SpecialtyController::class);
Route::get('specialties/{id}/delete', [SpecialtyController::class, 'destroy']);

// ====================== Estagiários (Intern) ======================
Route::get('intern/pdf', [InternController::class, 'pdfAll'])->name('intern.pdfAll');
Route::resource('intern', InternController::class);
Route::get('intern/{id}/delete', [InternController::class, 'destroy']);

// ====================== Mobilidade (Mobility) ======================
Route::get('mobility/pdf', [MobilityController::class, 'pdfAll'])->name('mobility.pdfAll');
Route::get('mobility/search-employee', [MobilityController::class, 'searchEmployee'])->name('mobility.searchEmployee');
Route::resource('mobility', MobilityController::class);

// ====================== Tipo de Licença (LeaveType) ======================
Route::resource('leaveType', LeaveTypeController::class);
Route::get('leaveType/{id}/delete', [LeaveTypeController::class, 'destroy']);


// ====================== Pedido de Licença (LeaveRequest) ======================
Route::get('leaveRequest/pdf', [LeaveRequestController::class, 'pdfAll'])->name('leaveRequest.pdfAll');
Route::get('leaveRequest/searchEmployee', [LeaveRequestController::class, 'searchEmployee'])->name('leaveRequest.searchEmployee');
Route::resource('leaveRequest', LeaveRequestController::class);
Route::get('leaveRequest/{id}/delete', [LeaveRequestController::class, 'destroy']);


// ====================== Pedido de Férias (Vacation Request) ======================

Route::get('vacationRequest/searchEmployee', [VacationRequestController::class, 'searchEmployee'])->name('vacationRequest.searchEmployee');
Route::get('vacationRequest/pdf', [VacationRequestController::class, 'pdfAll'])->name('vacationRequest.pdfAll');
Route::resource('vacationRequest', VacationRequestController::class);
Route::get('vacationRequest/{id}/delete', [LeaveRequestController::class, 'destroy']);

// Rotas para o módulo de Secondment (Destacamento)
Route::get('secondment/searchEmployee', [\App\Http\Controllers\SecondmentController::class, 'searchEmployee'])->name('secondment.searchEmployee');
Route::resource('secondment', \App\Http\Controllers\SecondmentController::class);



// ====================== Destacamento do Funcionario (Secondment) ======================
Route::get('secondment/searchEmployee', [SecondmentController::class, 'searchEmployee'])->name('secondment.searchEmployee');
Route::get('secondment/pdf', [SecondmentController::class, 'pdfAll'])->name('secondment.pdfAll');
Route::resource('secondment', SecondmentController::class);

