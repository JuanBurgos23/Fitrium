<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Cliente
Route::get('cliente',[ClienteController::class,'index'])->name('mostrar_cliente');
Route::post('/cliente-register', [ClienteController::class, 'store']);
Route::get('/cliente/edit/{id}', [ClienteController::class, 'edit']);
Route::put('/cliente-update/{id}', [ClienteController::class, 'update']);
Route::get('/clientes/search', [ClienteController::class, 'search'])->name('clientes.search');
