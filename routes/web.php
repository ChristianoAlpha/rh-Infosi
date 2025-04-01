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
use App\Http\Controllers\DepartmentHeadController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SalaryPaymentController;
use App\Http\Controllers\InternEvaluationController;
use App\Http\Controllers\RetirementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;


/*
|--------------------------------------------------------------------------
| Rotas Login/Logout e Recuperação de Senha - Laravel Sanctum
|--------------------------------------------------------------------------
*/
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('forgotPassword', [AuthController::class, 'showForgotPasswordForm'])->name('forgotPassword');
Route::post('forgotPassword', [AuthController::class, 'sendResetLink'])->name('forgotPasswordEmail');
Route::get('resetPassword/{token}', [AuthController::class, 'showResetForm'])->name('resetPassword');
Route::post('resetPassword', [AuthController::class, 'resetPassword'])->name('resetPasswordUpdate');


        // Rotas adicionais para compatibilidade (opcional)
        Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [AuthController::class, 'resetPassword'])->name('password.update');



/*
|--------------------------------------------------------------------------
| Rotas Protegidas pelo middleware 'auth'
|--------------------------------------------------------------------------
*/
    Route::middleware(['auth'])->group(function() {

          // Rota principal do Dashboard
          Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
          // Rota GET com parâmetro ?status=...
          Route::get('employeee/filter-by-status', [EmployeeeController::class, 'filterByStatus'])->name('employeee.filterByStatus');


        

    // ====================== Filtros por datas (Funcionários / Estagiários) ======================
    // Funcionários
        Route::get('employeee/filter', [EmployeeeController::class, 'filterByDate'])->name('employeee.filter');
        Route::get('employeee/filter/pdf', [EmployeeeController::class, 'pdfFiltered'])->name('employeee.filter.pdf');
    // Estagiários
        Route::get('intern/filter', [InternController::class, 'filterByDate'])->name('intern.filter');
        Route::get('intern/filter/pdf', [InternController::class, 'pdfFiltered'])->name('intern.filter.pdf');

    // ====================== Rotas Para o Tipo de Funcionário (EmployeeType) ======================
        Route::resource('employeeType', EmployeeTypeController::class);

    // ====================== Funcionários (Employeee) ======================
        Route::get('employeee/pdf', [EmployeeeController::class, 'pdfAll'])->name('employeee.pdfAll');
        Route::resource('employeee', EmployeeeController::class);
        Route::get('employeee/{id}/delete', [EmployeeeController::class, 'destroy']);

    // ====================== Perfil do Funcionário ======================
    Route::get('my-profile', [EmployeeeController::class, 'myProfile'])->name('profile');

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

    
    // ====================== Pagamento de Salário (Salary Payment) ======================
        Route::get('salaryPayment/searchEmployee', [SalaryPaymentController::class, 'searchEmployee'])->name('salaryPayment.searchEmployee'); 
        Route::get('salaryPayment/pdf', [SalaryPaymentController::class, 'pdfAll'])->name('salaryPayment.pdfAll');
        Route::resource('salaryPayment', SalaryPaymentController::class);
    


    // ====================== Avaliação dos Estagiários (Intern Evaluation) ======================
        Route::get('internEvaluation/searchIntern', [InternEvaluationController::class, 'searchIntern'])->name('internEvaluation.searchIntern');
        Route::get('internEvaluation/pdf/{id}', [InternEvaluationController::class, 'pdf'])->name('internEvaluation.pdf');
        Route::get('internEvaluation/pdf', [InternEvaluationController::class, 'pdfAll'])->name('internEvaluation.pdfAll');
        Route::resource('internEvaluation', InternEvaluationController::class);
        
        

    // ====================== Mobilidade (Mobility) ======================
        Route::get('mobility/pdf', [MobilityController::class, 'pdfAll'])->name('mobility.pdfAll');
        Route::get('mobility/search-employee', [MobilityController::class, 'searchEmployee'])->name('mobility.searchEmployee');
        Route::resource('mobility', MobilityController::class);

    // ====================== Tipos de Licença (LeaveType) ======================
        Route::resource('leaveType', LeaveTypeController::class);
        Route::get('leaveType/{id}/delete', [LeaveTypeController::class, 'destroy']);

    // ====================== Pedido de Licença (LeaveRequest) ======================
        Route::get('leaveRequest/searchEmployee', [LeaveRequestController::class, 'searchEmployee'])->name('leaveRequest.searchEmployee');
        Route::get('leaveRequest/pdf', [LeaveRequestController::class, 'pdfAll'])->name('leaveRequest.pdfAll');
        Route::resource('leaveRequest', LeaveRequestController::class);
        Route::get('leaveRequest/{id}/delete', [LeaveRequestController::class, 'destroy']);


    // ====================== Pedido de Férias (Vacation Request) ======================
        Route::get('vacationRequest/departmentSummary', [VacationRequestController::class, 'departmentSummary'])->name('vacationRequest.departmentSummary');
        Route::get('vacationRequest/searchEmployee', [VacationRequestController::class, 'searchEmployee'])->name('vacationRequest.searchEmployee');
        Route::get('vacationRequest/pdf', [VacationRequestController::class, 'pdfAll'])->name('vacationRequest.pdfAll');
        Route::resource('vacationRequest', VacationRequestController::class);
        Route::get('vacationRequest/{id}/delete', [LeaveRequestController::class, 'destroy']);

    // ====================== Destacamento (Secondment) ======================
        Route::get('secondment/searchEmployee', [SecondmentController::class, 'searchEmployee'])->name('secondment.searchEmployee');
        Route::get('secondment/pdf', [SecondmentController::class, 'pdfAll'])->name('secondment.pdfAll');
        Route::resource('secondment', SecondmentController::class);

    // ====================== Reforma (Retirement) ======================
        Route::get('retirements/searchEmployee', [RetirementController::class, 'searchEmployee'])->name('retirements.searchEmployee'); 
        Route::get('retirements/pdf', [RetirementController::class, 'pdfAll'])->name('retirements.pdf');
        Route::resource('retirements', RetirementController::class);
       

    // ====================== Mapa de Efetividade (Attendance) ======================
        Route::get('attendance/pdf', [AttendanceController::class, 'pdfAll'])->name('attendance.pdfAll');
        Route::get('attendance/dashboard', [AttendanceController::class, 'dashboard'])->name('attendance.dashboard');
        Route::get('attendance/check-status', [AttendanceController::class, 'checkStatus'])->name('attendance.checkStatus');
        Route::get('attendance/createBatch', [AttendanceController::class, 'createBatch'])->name('attendance.createBatch');
        Route::post('attendance/storeBatch', [AttendanceController::class, 'storeBatch'])->name('attendance.storeBatch');
        Route::resource('attendance', AttendanceController::class)->except(['show']);




   

  
    
        // ====================== Grupo de Chefe de Departamento ======================
        
                // Rotas para o grupo de Chefe de Departamento
        Route::prefix('department-head')->name('dh.')->group(function() {
            Route::get('my-employees', [DepartmentHeadController::class, 'myEmployees'])->name('myEmployees');
            Route::get('pending-vacations', [DepartmentHeadController::class, 'pendingVacations'])->name('pendingVacations');
            Route::post('approve-vacation/{id}', [DepartmentHeadController::class, 'approveVacation'])->name('approveVacation');
            Route::post('reject-vacation/{id}', [DepartmentHeadController::class, 'rejectVacation'])->name('rejectVacation');

            // Rotas para pedidos de licença
            Route::get('pending-leaves', [DepartmentHeadController::class, 'pendingLeaves'])->name('pendingLeaves');
            Route::post('approve-leave/{id}', [DepartmentHeadController::class, 'approveLeave'])->name('approveLeave');
            Route::post('reject-leave/{id}', [DepartmentHeadController::class, 'rejectLeave'])->name('rejectLeave');

            // Rotas para pedidos de reforma (retirement)
            Route::get('reformas-pendentes', [DepartmentHeadController::class, 'pendingRetirements'])->name('pendingRetirements');
            Route::put('reformas/aprovar/{id}', [DepartmentHeadController::class, 'approveRetirement'])->name('approveRetirement');
            Route::put('reformas/rejeitar/{id}', [DepartmentHeadController::class, 'rejectRetirement'])->name('rejectRetirement');
        });

          



        
        
        Route::get('/homeRH-INFOSI', [FrontendController::class, 'index'])->name('frontend.index');
        Route::get('/sobre', [FrontendController::class, 'about'])->name('frontend.about');
        Route::get('/servicos', [FrontendController::class, 'services'])->name('frontend.services');
        Route::get('/contato', [FrontendController::class, 'contact'])->name('frontend.contact');


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


