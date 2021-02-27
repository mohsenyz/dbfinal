<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeContractController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeDeductionController;
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

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);

});

Route::group(['middleware' => ['auth:api']], function ($router) {

    Route::get('contract', [EmployeeContractController::class, 'currentEmployeeList']);
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

    Route::put('company', [CompanyController::class, 'updateCurrent']);
});