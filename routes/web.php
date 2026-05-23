<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpedienteController;
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
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{usuario}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.update');
    Route::get('/usuarios/{usuario}', [UserController::class, 'show'])->name('usuarios.show');
    Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    
    Route::get('/expedientes', function () { return view('modules.dashboard.expedientes'); })->name('expedientes.index');
    Route::get('/expedientes/buscar', [ExpedienteController::class, 'search'])->name('expedientes.search');
    Route::get('/mascotas/{mascota}/consultas', [ExpedienteController::class, 'consultasMascota'])->name('mascotas.consultas');
    Route::get('/mascotas/{mascota}/consultas/{consulta}', [ExpedienteController::class, 'detalleConsulta'])->name('mascotas.consultas.detalle');
    Route::get('/mascotas/{mascota}/consultas/{consulta}/diagnostico', [ExpedienteController::class, 'diagnostico'])->name('mascotas.consultas.diagnostico');
    Route::post('/mascotas/{mascota}/consultas/{consulta}/diagnostico', [ExpedienteController::class, 'guardarDiagnostico'])->name('mascotas.consultas.diagnostico.guardar');
    
    Route::get('/mascotas/{mascota}/consultas/{consulta}/tratamiento', [ExpedienteController::class, 'tratamiento'])->name('mascotas.consultas.tratamiento');
    Route::post('/mascotas/{mascota}/consultas/{consulta}/tratamiento', [ExpedienteController::class, 'guardarTratamiento'])->name('mascotas.consultas.tratamiento.guardar');
    
    Route::get('/mascotas/{mascota}/consultas/{consulta}/alergias', [ExpedienteController::class, 'alergias'])->name('mascotas.consultas.alergias');
    Route::post('/mascotas/{mascota}/consultas/{consulta}/alergias', [ExpedienteController::class, 'guardarAlergias'])->name('mascotas.consultas.alergias.guardar');
    
    Route::get('/mascotas/{mascota}/consultas/{consulta}/lesiones', [ExpedienteController::class, 'lesiones'])->name('mascotas.consultas.lesiones');
    Route::post('/mascotas/{mascota}/consultas/{consulta}/lesiones', [ExpedienteController::class, 'guardarLesiones'])->name('mascotas.consultas.lesiones.guardar');
    
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
