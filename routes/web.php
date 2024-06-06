<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/{idVendedor?}', [HomeController::class, 'index']);
Route::get('/contempladas/{idVendedor?}', [HomeController::class, 'contempladas']);

});
