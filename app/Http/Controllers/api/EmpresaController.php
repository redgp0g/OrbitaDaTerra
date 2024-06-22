<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    public function delete($id)
    {
        $cadastro = Empresa::find($id);
        $cadastro->delete();
        return response()->json($cadastro);
    }

}
