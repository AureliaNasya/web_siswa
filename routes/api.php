<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StudentController; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DashboardController; 
use App\Http\Controllers\API\CityController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('students', StudentController::class);
    Route::get('/dashboard-stats', [DashboardController::class, 'getStats']);
    Route::apiResource('/cities', CityController::class);
});