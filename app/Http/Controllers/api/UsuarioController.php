<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UsuarioController extends Controller
{
    public function ativar($id) {
        User::find($id)->update(['Status' => 'Ativa']);
        return response()->json('Conta Ativada', 200);
    }
    public function suspender($id) {
        User::find($id)->update(['Status' => 'Suspendida']);
        return response()->json('Conta Suspensa', 200);
    }
}
