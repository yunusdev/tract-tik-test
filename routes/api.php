<?php

use App\Http\Controllers\EmployeeController;
use App\Schemas\EmployeeProvider1;
use App\Schemas\EmployeeProvider2;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/employees/{employee}', [EmployeeController::class, 'get'])
        ->whereNumber('employee');
Route::post('/{provider}/employees', [EmployeeController::class, 'store'])
    ->whereIn('provider', [EmployeeProvider1::$providerName, EmployeeProvider2::$providerName]);
Route::put('/{provider}/employees/{employee}', [EmployeeController::class, 'update'])
    ->whereIn('provider', [EmployeeProvider1::$providerName, EmployeeProvider2::$providerName])
    ->whereNumber('employee');

