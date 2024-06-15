<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use App\Models\HistoricoAcesso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        $leadsIndicados = Cadastro::where('IDCadastroIndicador', $user->IDCadastro)
            ->where('IDCadastroVendedor', '<>', $user->IDCadastro)
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

    public function indexEmpresa()
    {
        $empresas = all('Empresa');

        return [
            'view' => $this->getViewPath() . '/indexEmpresa.php',
            'data' => ['title' => 'Dashboard', 'empresas' => $empresas]
        ];
    }

    public function contas()
    {
        $connect = connect();

        $query = $connect->query("SELECT * FROM `Usuario` as U INNER JOIN Cadastro as C on C.IDCadastro = U.IDCadastro ORDER BY AdminConfirmado, ContaSuspendida ASC");
        $contas = $query->fetchAll();

        return [
            'view' => $this->getViewPath() . '/contas.php',
            'data' => ['title' => 'Contas em Aprovação', 'contas' => $contas]
        ];
    }

    public function perfilUsuario()
    {
        return [
            'view' => $this->getViewPath() . '/perfilUsuario.php',
            'data' => ['title' => 'Perfil']
        ];
    }

    public function createEmpresa()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return [
                'view' => $this->getViewPath() . '/createEmpresa.php',
                'data' => ['title' => 'Cadastrar Empresa']
            ];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cnpj = preg_replace('/\D/', '', filter_input(INPUT_POST, 'cnpj', FILTER_SANITIZE_NUMBER_INT));
            $razaoSocial = filter_input(INPUT_POST, 'razaoSocial');
            $nomeFantasia = filter_input(INPUT_POST, 'nomeFantasia');
            $telefoneEmpresa = preg_replace('/\D/', '', filter_input(INPUT_POST, 'telefoneEmpresa', FILTER_SANITIZE_NUMBER_INT));
            $nomeRepresentante = filter_input(INPUT_POST, 'nomeRepresentante');
            $celularRepresentante = preg_replace('/\D/', '', filter_input(INPUT_POST, 'celularRepresentante', FILTER_SANITIZE_NUMBER_INT));
            $emailRepresentante = filter_input(INPUT_POST, 'emailRepresentante');
            $cep = preg_replace('/\D/', '', filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_NUMBER_INT));
            $endereco = filter_input(INPUT_POST, 'endereco');
            $numero = filter_input(INPUT_POST, 'numero');
            $complemento = filter_input(INPUT_POST, 'complemento');
            $bairro = filter_input(INPUT_POST, 'bairro');
            $cidade = filter_input(INPUT_POST, 'cidade');
            $estado = filter_input(INPUT_POST, 'estado');
            $tipoEmpresa = filter_input(INPUT_POST, 'tipoEmpresa');
            $observacoes = filter_input(INPUT_POST, 'observacoes');

            if (findBy('Empresa', 'CNPJ', $cnpj)) {
                setFlash('error', 'Já existe um cadastro com esse CNPJ!');
                redirect('/public/index.php/dashboard/createEmpresa');
                exit;
            }

            $dadosEmpresa = array(
                'CNPJ' => $cnpj,
                'RazaoSocial' => $razaoSocial,
                'NomeFantasia' => $nomeFantasia,
                'Telefone' => $telefoneEmpresa,
                'NomeRepresentante' => $nomeRepresentante,
                'CelularRepresentante' => $celularRepresentante,
                'EmailRepresentante' => $emailRepresentante,
                'CEP' => $cep,
                'Endereco' => $endereco,
                'Numero' => $numero,
                'Bairro' => $bairro,
                'Cidade' => $cidade,
                'Estado' => $estado,
                'Complemento' => $complemento,
                'TipoEmpresa' => $tipoEmpresa,
                'DataCadastro' => date('Y-m-d H:i:s'),
                'Observacoes' => $observacoes,
            );

            if (create('Empresa', $dadosEmpresa)) {

                setFlash('success', 'Empresa cadastrada!');
                redirect('/public/index.php/dashboard/createEmpresa');
                exit;
            }

            setFlash('error', 'Houve algum erro ao cadastrar os dados, tente novamente!');
            redirect('/public/index.php/dashboard/createEmpresa');
        }
    }

    public function createCartaVendida()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $connect = connect();

            $tiposCartas = all('TipoCarta');
            $cadastros = all('Cadastro');


            $query = $connect->query("SELECT IDEmpresa, NomeFantasia FROM Empresa WHERE TipoEmpresa = 'Administradora'");
            $administradoras = $query->fetchAll();
            return [
                'view' => $this->getViewPath() . '/createCartaVendida.php',
                'data' => ['title' => 'Cadastrar Carta Vendida', 'tiposCartas' => $tiposCartas, 'administradoras' => $administradoras, 'cadastros' => $cadastros]
            ];
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }

    public function historicoAcesso()
    {
        $acessos = HistoricoAcesso::with(['usuario.cadastro'])->orderBy('DataEntrada', 'DESC')->get();

        return view('dashboard.historicoAcesso', compact('acessos'));
    }
}
