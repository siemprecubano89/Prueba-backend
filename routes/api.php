<?php

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

Route::get('/companies', [App\Http\Controllers\Api\Company\GetCompanyListController::class, '__invoke']);
Route::post('/company', [App\Http\Controllers\Api\Company\PostCreateCompanyController::class, '__invoke']);
Route::patch('/company/{id}/status', [App\Http\Controllers\Api\Company\PatchCompanyStatusController::class, '__invoke']);
