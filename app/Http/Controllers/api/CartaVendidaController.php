<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CartaVendida;

class CartaVendidaController extends Controller
{
    public function aprovar($id)
    {
        $cartaVendida = CartaVendida::find($id);
        $cartaVendida->update(
            ['Status' => 'Aprovada']
        );
        return response()->json($cartaVendida);
    }

    public function bloquear($id)
    {
        $cartaVendida = CartaVendida::find($id);
        $cartaVendida->update(
            ['Status' => 'Bloqueada']
        );
        return response()->json($cartaVendida);
    }

}
