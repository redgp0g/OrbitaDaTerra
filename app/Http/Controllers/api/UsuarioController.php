<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UsuarioController extends Controller
{
    public function liberar($id) {
        User::find($id)->update(['AdminConfirmado' => 1, 'ContaSuspendida' => 0]);
        return response()->json('Conta Suspensa', 200);
    }
    public function suspender($id) {
        User::find($id)->update(['AdminConfirmado' => 0, 'ContaSuspendida' => 1]);
        return response()->json('Conta Suspensa', 200);
    }
}
