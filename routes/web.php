<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/logear', [AuthController::class, 'logear'])->name('logear');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [AuthController::class, 'home'])->name('home');
    Route::get('/admin/home', [AuthController::class, 'adminHome'])->name('admin.home');
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
