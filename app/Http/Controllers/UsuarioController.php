<?php

namespace App\Http\Controllers;

use App\Mail\Notificacao;
use App\Models\Cadastro;
use App\Models\Funcao;
use App\Models\HistoricoAcesso;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

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

        $user = User::where('Login', $request->input('Login'))->first();

        if ($user) {
            if (!$user->is_migrated) {
                if (hash('sha256', $request->input('Senha')) === $user->Senha) {
                    $user->Senha = bcrypt($request->input('Senha'));
                    $user->is_migrated = true;
                    $user->save();

                    Auth::login($user);
                } else {
                    return redirect()->back()->with('erro', 'Usuário ou senha incorreta.');
                }
            } else {
                if (!Auth::attempt($credenciais)) {
                    return redirect()->back()->with('erro', 'Usuário ou senha incorreta.');
                }

                $user = Auth::user();
            }

            if ($user->AdminConfirmado && $user->EmailConfirmado && !$user->ContaSuspendida) {
                HistoricoAcesso::create([
                    'IDUsuario' => $user->IDUsuario,
                    'DataEntrada' => now(),
                ]);
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            } else {
                Auth::logout();
                return redirect()->route('usuario.login')->with('erro', 'Usuário não autorizado. Verifique se o administrador liberou seu acesso e se seu email está confirmado e se sua conta não está suspensa.');
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

            $user = User::create($dataUsuario);

            Mail::to(['guilhermeg2004@gmail.com'])->send(new Notificacao([
                'nome' => $cadastrado->Nome,
                'telefone' => $cadastrado->Telefone,
                'email' => $cadastrado->Email,
                'data' => $dataAtual,
                'endereco' => $cadastrado->Endereco + ', ' + $cadastrado->Bairro + ', ' + $cadastrado->Cidade + ', ' + $cadastrado->Estado,
            ]));
            // sendEmail($mensagemUsuario, 'Verificação de Email', $cadastrado->Email);
            return redirect("usuario")->with('sucesso', 'Cadastrado com sucesso! Verifique a sua caixa de entrada do email para realizar a validação!');
        } catch (Exception $ex) {
            if ($user) {
                User::destroy($user->IDUsuario);
            }
            if ($cadastrado) {
                Cadastro::destroy($cadastrado->IDCadastro);
            }
            return redirect()->back()->with('erro', 'Houve um erro ao cadastrar o usuário:' . $ex->getMessage());
        }
    }

    // public function emailVerification(Request $request)
    // {

    //     $request->validate([
    //         'login' => 'required|string',
    //         'codigoverificacaoemail' => 'required|string',
    //     ]);

    //     $login = $request->input('login');
    //     $codigoVerificacaoEmail = $request->input('codigoverificacaoemail');

    //     $usuario = User::where('Login', $login)
    //         ->where('CodigoVerificacaoEmail', $codigoVerificacaoEmail)
    //         ->first();

    //     if ($usuario) {
    //         $usuario->update([
    //             'EmailConfirmado' => 1,
    //             'CodigoVerificacaoEmail' => null,
    //         ]);

    //         return redirect('usuario')->with('sucesso', 'Seu email foi verificado com sucesso!');
    //     } else {
    //         return redirect('usuario')->with('erro', 'Link incorreto!');
    //     }
    // }

    // public function recoverPassword()
    // {

    //     if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    //         return [
    //             'view' => $this->getViewPath() . '/recoverPassword.php',
    //             'data' => ['title' => 'Recuperação de Senha']
    //         ];
    //     }

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $email = filter_input(INPUT_POST, 'email');
    //         $cadastros = fullOuterJoin('Usuario', 'Cadastro', 'IDCadastro', 'IDCadastro');
    //         $cadastroEncontrado = null;

    //         foreach ($cadastros as $cadastro) {
    //             if ($cadastro->Email == $email) {
    //                 $cadastroEncontrado = $cadastro;
    //                 break;
    //             }
    //         }

    //         if ($cadastroEncontrado) {
    //             if ($cadastroEncontrado->ContaSuspendida == 1) {
    //                 setFlash('error', 'O email ' . $email . 'pertence a uma conta que foi suspendida, caso deseje ativá-la, contate os administradores do sistema.');
    //                 return redirect('/public/index.php/usuario/recoverPassword');
    //             }
    //             $token = bin2hex(random_bytes(15));
    //             $dados = array(
    //                 'TokenRecuperacaoSenha' => $token
    //             );
    //             update('Usuario', $dados, 'IDUsuario', $cadastroEncontrado->IDUsuario);

    //             $link = "https://www.orbitadaterraconsorcio.com.br/public/index.php/usuario/changePassword/email/" . $email . "/token/" . $token;
    //             $mensagemRedefinicaoSenha = "Olá " . $cadastroEncontrado->Nome . ":<br>
    //                                 Recebemos uma solicitação de redefinição de senha na data :" . date('d/m/Y - H:m:i') . ", caso não tenha sido você, entre em contato com o administrador do sistema, caso contrário, acesse o link abaixo para redefinir sua senha!
    //                                 <br>
    //                                 <br>
    //                                 *****************************************************************
    //                                 <br>
    //                                      <font color='blue'><a href=" . $link . " style='text-decoration:none;'>" . $link . "</a></font>
    //                                 <br>
    //                                 ******************************************************************
    //                           <br><br>
    //                           Equipe Orbita.";
    //             if (sendEmail($mensagemRedefinicaoSenha, 'Redefinir Senha', $email)) {
    //                 setFlash('success', 'Solicitação enviada com sucesso! Verifique sua caixa de email, caso não tenha recebido, verifique sua caixa de spam!');
    //                 return redirect('/public/index.php/usuario/recoverPassword');
    //             } else {
    //                 $dados = array(
    //                     'TokenRecuperacaoSenha' => NULL
    //                 );
    //                 update('Usuario', $dados, 'IDUsuario', $cadastroEncontrado->IDUsuario);
    //                 setFlash('error', 'Erro! Não foi possível enviar o e-mail');
    //                 return redirect('/public/index.php/usuario/recoverPassword');
    //             }
    //         } else {
    //             setFlash('error', 'Email não encontrado em nosso cadastro!');
    //             return redirect('/public/index.php/usuario/recoverPassword');
    //         }
    //     }
    // }

    // public function changePassword($params)
    // {

    //     if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //         if ($params != []) {
    //             $email = $params['email'];
    //             $token = $params['token'];
    //             $cadastros = fullOuterJoin('Usuario', 'Cadastro', 'IDCadastro', 'IDCadastro');
    //             $cadastroEncontrado = null;

    //             foreach ($cadastros as $cadastro) {
    //                 if ($cadastro->Email == $email) {
    //                     $cadastroEncontrado = $cadastro;
    //                     break;
    //                 }
    //             }

    //             if ($cadastroEncontrado) {
    //                 if ($cadastroEncontrado->TokenRecuperacaoSenha != $token) {
    //                     setFlash('error', 'Este link não é mais válido, solicite um novo link para redefinição de senha!');
    //                     return redirect('/public/index.php/usuario/login');
    //                 }
    //                 if ($cadastroEncontrado->ContaSuspendida == 1) {
    //                     setFlash('error', 'O email ' . $email . 'pertence a uma conta que foi suspendida, caso deseje ativá-la, contate os administradores do sistema.');
    //                     return redirect('/public/index.php/usuario/login');
    //                 }
    //             } else {
    //                 setFlash('erro', 'Email não encontrado em nosso cadastro!');
    //                 return redirect('/public/index.php/usuario/login');
    //             }
    //         }
    //         return [
    //             'view' => $this->getViewPath() . '/changePassword.php',
    //             'data' => ['title' => 'Alteração de Senha', 'email' => $cadastroEncontrado->Email]
    //         ];
    //     }

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $senha = hash('sha256', filter_input(INPUT_POST, 'senha'));
    //         $email = filter_input(INPUT_POST, 'email');
    //         $cadastros = fullOuterJoin('Usuario', 'Cadastro', 'IDCadastro', 'IDCadastro');
    //         $cadastroEncontrado = null;

    //         foreach ($cadastros as $cadastro) {
    //             if ($cadastro->Email == $email) {
    //                 $cadastroEncontrado = $cadastro;
    //                 break;
    //             }
    //         }

    //         if ($cadastroEncontrado != null) {
    //             $dados = array(
    //                 'Senha' => $senha,
    //                 'TokenRecuperacaoSenha' => NULL
    //             );
    //             if (update('Usuario', $dados, 'IDUsuario', $cadastroEncontrado->IDUsuario)) {
    //                 $mensagemRedefinicaoSenha = "Olá " . $cadastroEncontrado->Nome . ":<br>
    //                     Sua senha foi alterada na data:" . date('d/m/Y - H:m:i') . ", caso não tenha sido você, entre em contato com o administrador do sistema!
    //                     <br><br>
    //                     Equipe Orbita.";
    //                 sendEmail($mensagemRedefinicaoSenha, 'Senha Alterada', $email);
    //                 setFlash('success', 'Sua senha foi alterada!');
    //                 return redirect('/public/index.php/usuario/login');
    //             }
    //             setFlash('error', 'Houve um erro ao alterar sua senha!');
    //             return redirect('/public/index.php/usuario/login');
    //         }
    //         setFlash('error', 'Link Inválido!');
    //         return redirect('/public/index.php/usuario/login');
    //     }
    // }
}
