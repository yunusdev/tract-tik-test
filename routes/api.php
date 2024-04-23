<?php

use App\Http\Controllers\EmployeeController;
use App\Schemas\EmployeeProvider1;
use App\Schemas\EmployeeProvider2;
use Illuminate\Http\Request;
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

Route::apiResource('{provider}/employees', EmployeeController::class)
    ->whereIn('provider', [EmployeeProvider1::$providerName, EmployeeProvider2::$providerName]);
