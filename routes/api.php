<?php

use App\Http\Controllers\HolidayPlanController;
use App\Http\Controllers\UserAuthController;
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

Route::post('register',[UserAuthController::class,'register']);
Route::post('login',[UserAuthController::class,'login']);
Route::post('logout',[UserAuthController::class,'logout'])
    ->middleware('auth:sanctum');

Route::post('/holiday-plans', [HolidayPlanController::class, 'create'])->middleware('auth:sanctum');
Route::get('/holiday-plans', [HolidayPlanController::class, 'index'])->middleware('auth:sanctum');
Route::get('/holiday-plans/{id}', [HolidayPlanController::class, 'show'])->middleware('auth:sanctum');
Route::put('/holiday-plans/{id}', [HolidayPlanController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/holiday-plans/{id}', [HolidayPlanController::class, 'destroy'])->middleware('auth:sanctum');
