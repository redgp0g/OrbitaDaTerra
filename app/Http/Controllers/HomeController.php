<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use App\Models\Carta;
use App\Models\CartaVendida;
use App\Models\Empresa;
use App\Models\TipoCarta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index($idVendedor = 38)
    {
        $cadastro = Cadastro::find($idVendedor);

        if (!$cadastro || !in_array($cadastro->TipoCadastro, ['Vendedor', 'Indicador'])) {
            $cadastro = Cadastro::find(38);
        }

        $vendedor = $cadastro->TipoCadastro == 'Vendedor' ? $cadastro : Cadastro::find($cadastro->IDCadastroVendedorIndicado);

        $cartas = Carta::with('TipoCarta')->get();
        $tiposCartas = TipoCarta::all();

        return view('home/index', compact('cadastro', 'cartas', 'tiposCartas', 'vendedor'));
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

    public function createCartaVendida($idAutorizada = 8)
    {
        $autorizada = Empresa::find($idAutorizada);
        if (!$autorizada) {
            $autorizada = Empresa::find(8);
        }

        $tiposCartas = TipoCarta::all();
        $administradoras = Empresa::where('TipoEmpresa', 'Administradora')->get();

        return view('home/createCartaVendida', compact('tiposCartas', 'administradoras', 'autorizada'));
    }

    public function storeCartaVendida(Request $request)
    {
        $data = $request->all();
        $data['ValorCredito'] = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $data['ValorCredito']));
        $data['ValorPago'] = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $data['ValorPago']));
        $data['ValorVenda'] = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $data['ValorVenda']));
        $data['SaldoDevedor'] = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $data['SaldoDevedor']));
        $data['ValorParcela'] = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $data['ValorParcela']));
        $data['ValorGarantia'] = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $data['ValorGarantia']));
        $data['TaxaTransferencia'] = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $data['TaxaTransferencia']));

        CartaVendida::create($data);
        return redirect('/cartasAVenda');
    }
}
