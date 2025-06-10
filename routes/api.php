<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthAPI;
use App\Http\Controllers\API\DashboardAPI;
use App\Http\Controllers\API\KotaAPI;
use App\Http\Controllers\API\SiswaAPI;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth', [AuthAPI::class, 'auth']);
Route::prefix('admin')->group(function() {
    Route::get('/dashboard', [DashboardAPI::class, 'index'])->name('admin.index');

    Route::prefix('kota')->group(function() {
        Route::get('/', [KotaAPI::class, 'index']);
        Route::post('/store', [KotaAPI::class, 'store']);
        Route::put('/{id}/update', [KotaAPI::class, 'update']);
        Route::get('/{id}', [KotaAPI::class, 'show']);
        Route::delete('/{id}', [KotaAPI::class, 'destroy']);
    });

    Route::prefix('siswa')->group(function() {
        Route::get('/', [SiswaAPI::class, 'index']);
        Route::post('/store', [SiswaAPI::class, 'store']);
        Route::put('/{id}/update', [SiswaAPI::class, 'update']);
        Route::get('/{id}', [SiswaAPI::class, 'show']);
        Route::delete('/{id}', [SiswaAPI::class, 'destroy']);
    });
}); 