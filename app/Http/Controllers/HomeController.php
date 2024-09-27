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
        $cartasVendidas = CartaVendida::with('tipoCarta')->with('empresaAdministradora')->with('empresaAutorizada')->with('cadastroConsorciado')->with('cadastroVendedor')->get();

        return view('home/cartasAVenda', compact('cadastro', 'cartasVendidas', 'vendedor'));
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
        
        $tiposCartas = TipoCarta::all();
        $administradoras = Empresa::where('TipoEmpresa', 'Administradora')->get();

        return view('home/createCartaVendida', compact('tiposCartas', 'administradoras', 'autorizada'));
    }

    public function storeCartaVendida(Request $request)
    {
        $data = $request->all();
        $data['ValorCredito'] = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $data['ValorCredito']));
        $data['ValorPago'] = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $data['ValorCredito']));
        $data['ValorVenda'] = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $data['ValorCredito']));
        $data['SaldoDevedor'] = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $data['ValorCredito']));
        $data['ValorParcela'] = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $data['ValorCredito']));
        $data['ValorGarantia'] = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $data['ValorCredito']));
        $data['TaxaTransferencia'] = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $data['ValorCredito']));
        
        CartaVendida::create($data);
        return redirect('/cartasAVenda/' . Auth::user()->IDCadastro);
    }
}
