<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use App\Models\Carta;
use App\Models\CartaVendida;
use App\Models\Empresa;
use App\Models\TipoCarta;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($idVendedor = 38)
    {
        $cadastro = Cadastro::find($idVendedor);

        if (!$cadastro || !in_array($cadastro->TipoCadastro, ['Vendedor', 'Indicador'])) {
            $cadastro = Cadastro::find(38);
        }

        $vendedor = $cadastro->TipoCadastro == 'Vendedor' ? $cadastro : Cadastro::find($cadastro->IDCadastroVendedorIndicado);

        return view('home/index', compact('cadastro', 'vendedor'));
    }

    public function cartasAVenda($idVendedor = 38)
    {
        $cadastro = Cadastro::find($idVendedor);

        if (!$cadastro || !in_array($cadastro->TipoCadastro, ['Vendedor', 'Indicador'])) {
            $cadastro = Cadastro::find(38);
        }

        $vendedor = $cadastro->TipoCadastro == 'Vendedor' ? $cadastro : Cadastro::find($cadastro->IDCadastroVendedorIndicado);
        $cartasVendidas = CartaVendida::with('tipoCarta')->with('empresaAdministradora')->with('empresaAutorizada')->with('cadastroConsorciado')->with('cadastroVendedor')->where('Status', 'Aprovada')->get();

        return view('home/cartasAVenda', compact('cadastro', 'cartasVendidas', 'vendedor'));
    }

    public function detalhesCartaNova($idCarta, $idVendedor = 38)
    {
        $cadastro = Cadastro::find($idVendedor);

        if (!$cadastro || !in_array($cadastro->TipoCadastro, ['Vendedor', 'Indicador'])) {
            $cadastro = Cadastro::find(38);
        }

        $vendedor = $cadastro->TipoCadastro == 'Vendedor' ? $cadastro : Cadastro::find($cadastro->IDCadastroVendedorIndicado);
        $carta = Carta::find($idCarta);
        $cartasSemelhantes = Carta::where('IDTipoCarta', $carta->IDTipoCarta)->where('IDCarta', '<>', $carta->IDCarta)->take(4)->get();
        return view('home/detalhesCartaNova', compact('carta', 'cadastro', 'vendedor', 'cartasSemelhantes'));
    }

    public function simulacao($idVendedor = 38)
    {
        $cadastro = Cadastro::find($idVendedor);

        if (!$cadastro || !in_array($cadastro->TipoCadastro, ['Vendedor', 'Indicador'])) {
            $cadastro = Cadastro::find(38);
        }

        $vendedor = $cadastro->TipoCadastro == 'Vendedor' ? $cadastro : Cadastro::find($cadastro->IDCadastroVendedorIndicado);
        $tiposCarta = TipoCarta::all();

        return view('home/simulacao', compact('cadastro', 'tiposCarta', 'vendedor'));
    }
}
