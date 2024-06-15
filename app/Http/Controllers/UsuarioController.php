<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use App\Models\Funcao;
use App\Models\HistoricoAcesso;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function auth(Request $request)
    {
        $request->validate([
            'Login' => ['required', 'email'],
            'Senha' => ['required'],
        ]);

        $credenciais = [
            'login' => $request->input('Login'),
            'password' => $request->input('Senha'),
        ];

        if (Auth::attempt($credenciais)) {
            $user = Auth::user();

            if (
                $user->AdminConfirmado &&
                $user->EmailConfirmado &&
                !$user->ContaSuspendida
            ) {
                HistoricoAcesso::create([
                    'IDUsuario' => $user->IDUsuario,
                    'DataEntrada' => now(),
                ]);
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            } else {
                Auth::logout();
                return redirect()->route('usuario.login')->with('erro', 'Usuário não autorizado. Verifique se o administrador liberou seu acesso e seu email está confirmado e se sua conta não está suspensa.');
            }
        } else {
            return redirect()->back()->with('erro', 'Usuário ou senha incorreta.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function create($idVendedorIndicado = 38)
    {
        $vendedorIndicado = Cadastro::find($idVendedorIndicado);

        $funcoes = Funcao::all();

        return view('usuario.create', compact('funcoes', 'vendedorIndicado'));
    }


    public function store(Request $request)
    {
        try {
            $cadastro = $request->all();
            $cadastro['Telefone'] = preg_replace("/[^0-9]/", "", $cadastro['Telefone']);
            $cadastro['CPF'] = preg_replace('/\D/', '', $cadastro['CPF']);
            $cadastro['CEP'] = preg_replace('/\D/', '', $cadastro['CEP']);
            $cadastro['Senha'] = bcrypt($cadastro['Senha']);
            $cadastro['Origem'] = 'Cadastra-se';
            $codigoVerificacaoEmail = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            $cadastrado = Cadastro::create($cadastro) ?? Cadastro::where('Email', $cadastro['Email'])->first()->update($cadastro);

            $dataAtual = now();

            $mensagemNotificacao = $dataAtual . " <br> O usuário: " . $cadastro['Nome'] . "</strong>, email: " . $cadastro['Email'] . "</strong>, celular: " . $cadastro['Telefone'] . " acabou de efetuar um  Cadastro de Conta em nosso sistema. <br><br> Equipe Orbita.";

            $mensagemUsuario = "Olá " . $cadastro['Nome'] . ":<br>
        Recebemos uma solicitação de cadastro, caso não tenha sido você, não precisa fazer nada, mas se foi você, acesse o link abaixo para continuar seu registro no nosso sistema para verificar seu email!
        <br>
        <br>
        *****************************************************************
        <br>
                <font color='blue'><a href='https://www.orbitadaterraconsorcio.com.br/public/index.php/usuario/emailVerification/login/" . $cadastro['Email'] . "/codigoverificacaoemail/" . $codigoVerificacaoEmail . "' style='text-decoration:none;'>Link</a></font>
        <br>
        ******************************************************************
        <br><br>
        Equipe Orbita.";


            $dataUsuario = array(
                'Login' => $cadastrado->Email,
                'Senha' => $cadastro['Senha'],
                'IDCadastro' => $cadastrado->IDCadastro,
                'CodigoVerificacaoEmail' => $codigoVerificacaoEmail,
            );

            User::create($dataUsuario);

            // sendEmail($mensagemNotificacao, 'Cadastro de Usuário', 'denilson@orbitadaterra.com.br');
            // sendEmail($mensagemUsuario, 'Verificação de Email', $cadastrado->Email);
            return redirect("usuario/auth")->with('sucesso', 'Cadastrado com sucesso! Verifique a sua caixa de entrada do email para realizar a validação!');
        } catch (Exception $ex) {
            if ($cadastrado) {
                Cadastro::destroy($cadastrado->IDCadastro);
            }
            return redirect()->back()->with('erro', 'Houve um erro ao cadastrar o usuário:' . $ex->getMessage());
        }
    }
}
