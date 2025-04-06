<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\Casillero;
use App\Http\Controllers\CasilleroController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ReciboController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//User
Route::get('user', [PerfilController::class, 'index'])->name('mostrar_perfil');
Route::post('/user/{id}/update-avatar', [PerfilController::class, 'updateAvatar'])->name('user.updateAvatar');
Route::delete('/user/{id}/delete-avatar', [PerfilController::class, 'deleteAvatar'])->name('user.deleteAvatar');
Route::post('user-perfil', [PerfilController::class, 'perfilUpdate'])->name('user.perfilUpdate');

//Cliente
Route::get('cliente', [ClienteController::class, 'index'])->name('mostrar_cliente');
Route::post('/cliente-register', [ClienteController::class, 'store']);
Route::get('/cliente/edit/{id}', [ClienteController::class, 'edit']);
Route::put('/cliente-update/{id}', [ClienteController::class, 'update']);
Route::get('/clientes/search', [ClienteController::class, 'search'])->name('clientes.search');

//Inscripcion
Route::get('/inscripcion', [InscripcionController::class, 'index'])->name('mostrar_inscripcion');
Route::post('/inscripcion-register', [InscripcionController::class, 'store']);
Route::get('/inscripcion/edit/{id}', [InscripcionController::class, 'edit']);
Route::put('/inscripcion-update/{id}', [InscripcionController::class, 'update']);
Route::get('/inscripcion/actualizar', [InscripcionController::class, 'actualizarEstados'])->name('actualizar_estados');
Route::post('/inscripcion/renovar/{id}', [InscripcionController::class, 'renovarInscripcion'])->name('renovar_inscripcion');
Route::get('/buscar-cliente', [InscripcionController::class, 'buscar'])->name('buscar.cliente');
//historial de inscripciones
Route::get('/historial-inscripciones', [InscripcionController::class, 'historial'])->name('historial_inscripciones');
Route::get('/historial-inscripciones/export-pdf', [InscripcionController::class, 'exportPDF'])->name('historial_inscripciones.pdf');
Route::get('/historial-inscripciones/export-excel', [InscripcionController::class, 'exportExcel'])->name('historial_inscripciones.excel');
//historial de un cliente inscrito
Route::get('/clientes/historial/{id}', [InscripcionController::class, 'verHistorial'])->name('historial_cliente');
Route::get('/clientes/historial/{id}/pdf', [InscripcionController::class, 'exportarPDF'])->name('exportar_historial_pdf');

//recibo de cliente inscrito
Route::post('/recibo/pagar', [InscripcionController::class, 'pagarRecibo'])->name('pagar_recibo');
Route::get('/recibo/{id}', [ReciboController::class, 'show']);
//recibos de un cliente
Route::get('/cliente/{id}/recibos', [ReciboController::class, 'verRecibos'])->name('historial_recibos_cliente');

//recibo pdf
Route::get('/recibo/pdf/{id}', [ReciboController::class, 'generarRecibo'])->name('recibo.pdf');



//Paquete
Route::get('paquete', [PaqueteController::class, 'index'])->name('mostrar_paquete');
Route::post('/paquete-register', [PaqueteController::class, 'store']);
Route::get('/paquete/edit/{id}', [PaqueteController::class, 'edit']);
Route::put('/paquete-update/{id}', [PaqueteController::class, 'update']);

//Casillero
Route::get('casillero', [CasilleroController::class, 'index'])->name('mostrar_casillero');
Route::post('/casillero-register', [CasilleroController::class, 'store']);
Route::get('/casillero/edit/{id}', [CasilleroController::class, 'edit']);
Route::put('/casillero-update/{id}', [CasilleroController::class, 'update']);

//Asisencia
Route::get('asistenia', [AsistenciaController::class, 'index'])->name('mostrar_asistencia');
Route::post('/asistencia-register', [AsistenciaController::class, 'store'])->name('asistencia.store'); // Registrar asistencia
Route::get('/asistencia/buscar', [AsistenciaController::class, 'buscar'])->name('asistencia.buscar');
Route::get('/api/clientes-vigentes', [AsistenciaController::class, 'buscarVigentes']);
Route::put('/asistencia/finalizar/{id}', [AsistenciaController::class, 'finalizarAsistencia'])->name('asistencia.finalizar'); // Finalizar asistencia
