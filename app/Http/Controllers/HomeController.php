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
        $cadastro = Cadastro::find($idVendedor)->TipoCadastro == 'Vendedor' ? Cadastro::find($idVendedor) : Cadastro::find(38);
        $cartas = Carta::with('TipoCarta')->get();
        $tiposCartas = TipoCarta::all();

        return view('home/index', compact('cadastro', 'cartas', 'tiposCartas'));
    }

    public function contempladas($idVendedor = 38)
    {
        $cadastro = Cadastro::find($idVendedor)->TipoCadastro == 'Vendedor' ? Cadastro::find($idVendedor) : Cadastro::find(38);
        $cartasVendidas = CartaVendida::with('tipoCarta')->with('empresaAdministradora')->with('empresaAutorizada')->with('cadastroConsorciado')->with('cadastroVendedor')->get();

        return view('home/contempladas', compact('cadastro','cartasVendidas'));
    }

    public function simulacao($idVendedor = 38)
    {
        $cadastro = Cadastro::find($idVendedor)->TipoCadastro == 'Vendedor' ? Cadastro::find($idVendedor) : Cadastro::find(38);
        $tiposCarta = TipoCarta::all();

        return view('home/simulacao', compact('cadastro','tiposCarta'));
    }

    public function createCartaVendida($idAutorizada)
    {
        $autorizada = Empresa::find($idAutorizada);
        if (!$autorizada) {
            abort(404);
        }
        $tiposCartas = TipoCarta::all();
        $administradoras = Empresa::where('TipoEmpresa', 'Administradora')->get();

        return view('home/createCartaVendida', compact('tiposCartas', 'administradoras', 'autorizada'));
    }

    public function storeCartaVendida(Request $request)
    {
        $data = $request->all();
    
        CartaVendida::create($data);
        return redirect('/contempladas/' . Auth::user()->IDCadastro);
    }
}
