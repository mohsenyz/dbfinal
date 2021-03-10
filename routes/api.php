<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeAbsenceController;
use App\Http\Controllers\EmployeeAssistanceController;
use App\Http\Controllers\EmployeeContractController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeDeductionController;
use App\Http\Controllers\EmployeeEarningController;
use App\Http\Controllers\EmployeeLoanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function ($router) {

    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);

});

Route::group(['middleware' => ['auth:api']], function ($router) {

    Route::get('contract', [EmployeeContractController::class, 'currentEmployeeList']);
    Route::get('company/contract/expiring_next_month', [EmployeeContractController::class, 'companyContractsExpiringNextMonth']);
    Route::get('contract/active', [EmployeeContractController::class, 'currentEmployeeActive']);
    Route::get('employee/{employee}/contract', [EmployeeContractController::class, 'index']);
    Route::get('employee/{employee}/contract/active', [EmployeeContractController::class, 'active']);
    Route::post('employee/{employee}/contract', [EmployeeContractController::class, 'store']);
    Route::put('employee/{employee}/contract/{contract:id}', [EmployeeContractController::class, 'update']);

    Route::get('employee', [EmployeeController::class, 'index']);
    Route::post('employee', [EmployeeController::class, 'store']);
    Route::get('employee/{employee}', [EmployeeController::class, 'show']);
    Route::put('employee/{employee}', [EmployeeController::class, 'update']);
    Route::delete('employee/{employee}', [EmployeeController::class, 'destroy']);

    Route::get('/employee/{employee}/deduction', [EmployeeDeductionController::class, 'index']);
    Route::post('/employee/{employee}/deduction', [EmployeeDeductionController::class, 'store']);
    Route::get('/employee/{employee}/deduction/{deduction:id}', [EmployeeDeductionController::class, 'show']);
    Route::put('/employee/{employee}/deduction/{deduction:id}', [EmployeeDeductionController::class, 'update']);
    Route::delete('/employee/{employee}/deduction/{deduction:id}', [EmployeeDeductionController::class, 'destroy']);

    Route::get('/employee/{employee}/earning', [EmployeeEarningController::class, 'index']);
    Route::post('/employee/{employee}/earning', [EmployeeEarningController::class, 'store']);
    Route::get('/employee/{employee}/earning/{earning:id}', [EmployeeEarningController::class, 'show']);
    Route::put('/employee/{employee}/earning/{earning:id}', [EmployeeEarningController::class, 'update']);
    Route::delete('/employee/{employee}/earning/{earning:id}', [EmployeeEarningController::class, 'destroy']);

    Route::put('company', [CompanyController::class, 'updateCurrent']);


    // absences (1h)
    Route::get('/employee/{employee}/absence', [EmployeeAbsenceController::class, 'index']);
    Route::post('/employee/{employee}/absence', [EmployeeAbsenceController::class, 'store']);
    Route::post('/employee/{employee}/absence/{absence:id}/accept', [EmployeeAbsenceController::class, 'accept']);
    Route::post('/employee/{employee}/absence/{absence:id}/reject', [EmployeeAbsenceController::class, 'reject']);
    Route::get('/employee/{employee}/absence/{absence:id}', [EmployeeAbsenceController::class, 'show']);
    Route::put('/employee/{employee}/absence/{absence:id}', [EmployeeAbsenceController::class, 'update']);
    Route::delete('/employee/{employee}/absence/{absence:id}', [EmployeeAbsenceController::class, 'destroy']);


    // assistance (1h)
    Route::get('/employee/{employee}/assistance', [EmployeeAssistanceController::class, 'index']);
    Route::post('/employee/{employee}/assistance', [EmployeeAssistanceController::class, 'store']);
    Route::post('/employee/{employee}/assistance/{assistance:id}/accept', [EmployeeAssistanceController::class, 'accept']);
    Route::post('/employee/{employee}/assistance/{assistance:id}/reject', [EmployeeAssistanceController::class, 'reject']);
    Route::post('/employee/{employee}/assistance/{assistance:id}/pay', [EmployeeAssistanceController::class, 'pay']);
    Route::get('/employee/{employee}/assistance/{assistance:id}', [EmployeeAssistanceController::class, 'show']);
    Route::put('/employee/{employee}/assistance/{assistance:id}', [EmployeeAssistanceController::class, 'update']);
    Route::delete('/employee/{employee}/assistance/{assistance:id}', [EmployeeAssistanceController::class, 'destroy']);

    // installment and loan (1h)
    Route::get('/employee/{employee}/loan', [EmployeeLoanController::class, 'index']);
    Route::post('/employee/{employee}/loan', [EmployeeLoanController::class, 'store']);
    Route::post('/employee/{employee}/loan/{loan:id}/accept', [EmployeeLoanController::class, 'accept']);
    Route::post('/employee/{employee}/loan/{loan:id}/reject', [EmployeeLoanController::class, 'reject']);
    Route::post('/employee/{employee}/loan/{loan:id}/pay', [EmployeeLoanController::class, 'pay']);
    Route::post('/employee/{employee}/loan/{loan:id}/{installment:ins_id}', [EmployeeLoanController::class, 'payInstallment']);
    Route::get('/employee/{employee}/loan/{loan:id}', [EmployeeLoanController::class, 'show']);
    Route::put('/employee/{employee}/loan/{loan:id}', [EmployeeLoanController::class, 'update']);
    Route::delete('/employee/{employee}/loan/{loan:id}', [EmployeeLoanController::class, 'destroy']);

    // paycheck (1h)



    // timesheet (1h)



});
