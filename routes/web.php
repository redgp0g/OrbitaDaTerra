<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/{idVendedor?}', [HomeController::class, 'index'])->where('idVendedor','[0-9]+');
Route::get('/contempladas/{idVendedor?}', [HomeController::class, 'contempladas'])->where('idVendedor','[0-9]+');
Route::get('/simulacao/{idVendedor?}', [HomeController::class, 'simulacao'])->where('idVendedor','[0-9]+');


Route::view('/usuario', 'usuario.login')->name('usuario.login');
Route::post('/auth', [UsuarioController::class, 'auth'])->name('usuario.auth');
Route::get('/logout', [UsuarioController::class, 'logout'])->name('usuario.logout');
Route::get('/usuario/create/{id?}', [UsuarioController::class, 'create'])->name('usuario.create')->where('id','[0-9]+');
Route::post('/usuario/store', [UsuarioController::class, 'store'])->name('usuario.store');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('auth');
Route::get('/dashboard/historicoAcesso', [DashboardController::class, 'historicoAcesso'])->name('dashboard.historicoAcesso')->middleware('auth');
Route::get('/dashboard/contas', [DashboardController::class, 'contas'])->name('dashboard.contas')->middleware('auth');
Route::get('/dashboard/empresas', [DashboardController::class, 'empresas'])->name('dashboard.empresas')->middleware('auth');
Route::get('/dashboard/cartaVendida', [DashboardController::class, 'cartaVendida'])->name('dashboard.cartaVendida')->middleware('auth');