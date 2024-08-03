<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use App\Models\CartaVendida;
use App\Models\Empresa;
use App\Models\HistoricoAcesso;
use App\Models\TipoCarta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        $leadsIndicados = Cadastro::select('L.*', 'I.Nome as NomeIndicador')
            ->from('Cadastro as L')
            ->join('Cadastro as I', 'L.IDCadastroIndicador', '=', 'I.IDCadastro')
            ->where('L.IDCadastroIndicador', $user->IDCadastro)
            ->where('L.IDCadastroVendedor', '<>', $user->IDCadastro)
            ->get();


        $leads = Cadastro::select('L.*', 'I.Nome as NomeIndicador')
            ->from('Cadastro as L')
            ->join('Cadastro as I', 'L.IDCadastroIndicador', '=', 'I.IDCadastro')
            ->where('L.IDCadastroVendedor', $user->IDCadastro)
            ->orderBy('L.PrevisaoAtividadeVendedor')
            ->orderByDesc('L.DataCadastro')
            ->get();


        return view('dashboard.index', compact('leadsIndicados', 'leads'));
    }

    public function leads()
    {
        $leads = Cadastro::select('L.*', 'I.Nome as NomeIndicador','V.Nome as NomeVendedor')
            ->from('Cadastro as L')
            ->join('Cadastro as I', 'L.IDCadastroIndicador', '=', 'I.IDCadastro')
            ->join('Cadastro as V', 'L.IDCadastroVendedor', '=', 'V.IDCadastro')
            ->orderBy('L.PrevisaoAtividadeVendedor')
            ->orderByDesc('L.DataCadastro')
            ->get();


        return view('dashboard.leads', compact('leads'));
    }

    public function empresas()
    {
        $empresas = Empresa::all();

        return view('dashboard.empresa', compact('empresas'));
    }

    public function contas()
    {
        $contas = User::with('cadastro')->orderBy('AdminConfirmado')->get();

        return view('dashboard.contas', compact('contas'));
    }

    public function perfil()
    {
        return view('dashboard.perfil');
    }

    public function createEmpresa()
    {
        return view('dashboard.createEmpresa');
    }

    public function storeEmpresa(Request $request)
    {
        $data = $request->all();
        $data['CNPJ'] = preg_replace('/\D/', '', $data['CNPJ']);
        $data['Telefone'] = preg_replace('/\D/', '', $data['Telefone']);
        $data['CelularRepresentante'] = preg_replace('/\D/', '', $data['CelularRepresentante']);
        $data['CEP'] = preg_replace('/\D/', '', $data['CEP']);

        if (Empresa::where('CNPJ', $data['CNPJ'])->exists()) {
            return redirect()->back()->with('erro', 'Já existe um cadastro com esse CNPJ!');
        }
    
        Empresa::create($data);
        return view('dashboard.empresas');
    }

    public function historicoAcesso()
    {
        $acessos = HistoricoAcesso::with(['usuario.cadastro'])->orderBy('DataEntrada', 'DESC')->get();

        return view('dashboard.historicoAcesso', compact('acessos'));
    }
}
