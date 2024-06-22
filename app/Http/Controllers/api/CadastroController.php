<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cadastro;
use Illuminate\Http\Request;

class CadastroController extends Controller
{
    public function index()
    {
        $cadastros = Cadastro::all();
        return response()->json($cadastros);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['Telefone'] = preg_replace('/\D/', '', $data['Telefone']);
        $cadastro = Cadastro::create($data);
        
        return response()->json($cadastro, 201);
    }
    
    public function show($id)
    {
        $cadastro = Cadastro::find($id);
        
        if (!$cadastro) {
            return response()->json(['message' => 'Cadastro não encontrado'], 404);
        }
        
        return response()->json($cadastro);
    }
    
    public function update(Request $request, $id)
    {
        $cadastro = Cadastro::find($id);
        if (is_null($cadastro)) {
            return response()->json(['message' => 'Cadastro não encontrado!'], 404);
        }
        
        $data = $request->all();
        $data['Telefone'] = preg_replace('/\D/', '', $data['Telefone']);

        $cadastro->update($data);

        return response()->json($cadastro);
    }

    public function excluirLead(Request $request, $id) {
        $data = $request->all();
        $data['DataUltimoVendedor'] = now();
        $data['IDCadastroVendedor'] = null;
        Cadastro::find($id)->update($data);
        return response()->json(201);
    }

}
