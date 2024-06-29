<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Carta;
use App\Models\Simulacao;
use Illuminate\Http\Request;

class CartaController extends Controller
{
    public function simulacao(Request $request)
    {
        $valorCredito = json_decode($request->input('ValorCredito'));
        $idTipoCarta = $request->input('IDTipoCarta');
        $prazo = $request->input('Prazo');
        $idCadastro = $request->input('IDCadastro');
        
        $cartas = Carta::whereIn('ValorCredito', $valorCredito)->where('IDTipoCarta', $idTipoCarta)->where('Prazo', $prazo)->get();
        foreach ($valorCredito as $valor) {
            Simulacao::create([
                'IDCadastro' => $idCadastro,
                'IDTipoCarta' => $idTipoCarta,
                'Credito' => $valor,
                'Prazo' => $prazo
            ]);
        }

        return response()->json($cartas);
    }

    public function buscarPrazosPorTipoCarta($idTipoCarta)
    {
        $prazos = Carta::where('IDTipoCarta', $idTipoCarta)
            ->distinct()
            ->orderBy('Prazo', 'ASC')
            ->pluck('Prazo');

        return response()->json($prazos);
    }

    public function buscarCreditosPorTipoCarta($idTipoCarta)
    {
        $creditos = Carta::where('IDTipoCarta', $idTipoCarta)
            ->distinct()
            ->orderBy('ValorCredito', 'ASC')
            ->pluck('ValorCredito');

        return response()->json($creditos);
    }

}
