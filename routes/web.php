<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\SiswaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function() {
    Route::get('/', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/', [AuthController::class, 'auth'])->name('authenticate');
});

Route::middleware(['auth'])->group(function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::prefix('admin')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.index');

        Route::prefix('kota')->group(function() {
            Route::get('/', [KotaController::class, 'index'])->name('admin.kota.index');
            Route::get('/add', [KotaController::class, 'add'])->name('admin.kota.add');
            Route::post('/store', [KotaController::class, 'store'])->name('admin.kota.store');
            Route::get('/{id}/edit', [KotaController::class, 'edit'])->name('admin.kota.edit');
            Route::put('/{id}/update', [KotaController::class, 'update'])->name('admin.kota.update');
            Route::get('/{id}', [KotaController::class, 'show'])->name('admin.kota.show');
            Route::delete('/{id}', [KotaController::class, 'destroy'])->name('admin.kota.destroy');
        });

        Route::prefix('admin/siswa')->group(function() {
            Route::get('/', [SiswaController::class, 'index'])->name('admin.siswa.index');
            Route::get('/add', [SiswaController::class, 'add'])->name('admin.siswa.add');
            Route::post('/store', [SiswaController::class, 'store'])->name('admin.siswa.store');
            Route::get('/{id}/edit', [SiswaController::class, 'edit'])->name('admin.siswa.edit');
            Route::put('/{id}/update', [SiswaController::class, 'update'])->name('admin.siswa.update');
            Route::get('/{id}', [SiswaController::class, 'show'])->name('admin.siswa.show');
            Route::delete('/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');
        });
    });    
});