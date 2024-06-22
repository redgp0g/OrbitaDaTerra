<?php

use App\Http\Controllers\api\CadastroController;
use App\Http\Controllers\api\EmpresaController;
use App\Http\Controllers\api\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cadastros', [CadastroController::class, 'index']);
Route::get('/cadastros/{id}', [CadastroController::class, 'show']);
Route::post('/cadastros', [CadastroController::class, 'store']);
Route::put('/cadastros/excluirLead/{id}', [CadastroController::class, 'excluirLead'])->where('id','[0-9]+');

Route::put('/usuario/liberar/{id}', [UsuarioController::class, 'liberar'])->where('id','[0-9]+');
Route::put('/usuario/suspender/{id}', [UsuarioController::class, 'suspender'])->where('id','[0-9]+');

Route::delete('/empresas/{id}', [EmpresaController::class, 'delete'])->where('id','[0-9]+');