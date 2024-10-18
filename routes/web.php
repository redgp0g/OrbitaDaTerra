<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/{idVendedor?}', [HomeController::class, 'index'])->where('idVendedor','[0-9]+');
Route::get('/public/index.php/id/{idVendedor?}', [HomeController::class, 'index'])->where('idVendedor','[0-9]+');
Route::get('/cartasAVenda/{idVendedor?}', [HomeController::class, 'cartasAVenda'])->where('idVendedor','[0-9]+');
Route::get('/simulacao/{idVendedor?}', [HomeController::class, 'simulacao'])->where('idVendedor','[0-9]+');
Route::get('/carta-a-venda/{idAutorizada?}', [HomeController::class, 'createCartaVendida'])->name('cartaVendida')->where('idAutorizada','[0-9]+');
Route::post('/carta-a-venda', [HomeController::class, 'storeCartaVendida'])->name('storeCartaVendida');

Route::view('/usuario', 'usuario.login')->name('usuario.login');
Route::post('/auth', [UsuarioController::class, 'auth'])->name('usuario.auth');
Route::view('/recoverPassword', 'usuario.recoverPassword')->name('usuario.recoverPassword');
Route::post('/recoverPassword', [UsuarioController::class, 'recoverPassword']);
Route::view('/changePassword/{id}/{token}', 'usuario.changePassword')->name('usuario.changePassword')->where('id','[0-9]+');
Route::post('/changePassword', [UsuarioController::class, 'changePassword']);
Route::get('/logout', [UsuarioController::class, 'logout'])->name('usuario.logout');
Route::get('/usuario/create/{id?}', [UsuarioController::class, 'create'])->name('usuario.create')->where('id','[0-9]+');
Route::post('/usuario/store', [UsuarioController::class, 'store'])->name('usuario.store');
Route::get('/verificarEmail/{id}/{codigo}', [UsuarioController::class, 'verificarEmail'])->name('usuario.verificar-email')->where('id','[0-9]+')->where('codigo','[0-9]+');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('auth');
Route::get('/dashboard/leads', [DashboardController::class, 'leads'])->name('dashboard.leads')->middleware('auth');
Route::get('/dashboard/historicoAcesso', [DashboardController::class, 'historicoAcesso'])->name('dashboard.historicoAcesso')->middleware('auth');
Route::get('/dashboard/contas', [DashboardController::class, 'contas'])->name('dashboard.contas')->middleware('auth');
Route::get('/dashboard/cartas-a-venda', [DashboardController::class, 'cartasAVenda'])->name('dashboard.cartasAVenda')->middleware('auth');
Route::get('/dashboard/empresas', [DashboardController::class, 'empresas'])->name('dashboard.empresas')->middleware('auth');
Route::get('/dashboard/perfil', [DashboardController::class, 'perfil'])->name('dashboard.perfil')->middleware('auth');
Route::get('/dashboard/createEmpresa', [DashboardController::class, 'createEmpresa'])->name('dashboard.createEmpresa')->middleware('auth');
Route::post('/dashboard/storeEmpresa', [DashboardController::class, 'storeEmpresa'])->name('dashboard.storeEmpresa')->middleware('auth');