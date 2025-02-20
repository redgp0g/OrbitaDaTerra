<?php

use App\Http\Controllers\api\CadastroController;
use App\Http\Controllers\api\CartaController;
use App\Http\Controllers\api\CartaVendidaController;
use App\Http\Controllers\api\EmpresaController;
use App\Http\Controllers\api\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::prefix('cadastros')->group(function () {
    Route::get('/', [CadastroController::class, 'index']);
    Route::get('{id}', [CadastroController::class, 'show'])->where('id', '[0-9]+');
    Route::post('/', [CadastroController::class, 'store']);
    Route::put('{id}', [CadastroController::class, 'update'])->where('id', '[0-9]+');
    Route::put('excluirLead/{id}', [CadastroController::class, 'excluirLead'])->where('id', '[0-9]+');
});

Route::prefix('usuario')->group(function () {
    Route::put('/ativar/{id}', [UsuarioController::class, 'ativar'])->where('id', '[0-9]+');
    Route::put('/suspender/{id}', [UsuarioController::class, 'suspender'])->where('id', '[0-9]+');
});

Route::post('/cartas/simulacao', [CartaController::class, 'simulacao']);
Route::get('/prazos/tipocarta/{idTipoCarta}', [CartaController::class, 'buscarPrazosPorTipoCarta'])->where('idTipoCarta','[0-9]+');
Route::get('/creditos/tipocarta/{idTipoCarta}', [CartaController::class, 'buscarCreditosPorTipoCarta'])->where('idTipoCarta','[0-9]+');

Route::put('/cartaAVenda/aprovar/{id}', [CartaVendidaController::class, 'aprovar'])->where('id','[0-9]+');
Route::put('/cartaAVenda/bloquear/{id}', [CartaVendidaController::class, 'bloquear'])->where('id','[0-9]+');

Route::delete('/empresas/{id}', [EmpresaController::class, 'delete'])->where('id','[0-9]+');