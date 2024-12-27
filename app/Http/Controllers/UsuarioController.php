<?php

namespace App\Http\Controllers;

use App\Mail\RecuperarSenha;
use App\Mail\SenhaAlterada;
use App\Mail\VerificacaoEmail;
use App\Models\Cadastro;
use App\Models\Funcao;
use App\Models\HistoricoAcesso;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

            if ($user->Status == 'Ativa' && $user->EmailConfirmado) {
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
            $codigoVerificacaoEmail = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            $cadastrado = Cadastro::create($cadastro) ?? Cadastro::where('Email', $cadastro['Email'])->first()->update($cadastro);

            $dataUsuario = array(
                'Login' => $cadastrado->Email,
                'Senha' => $cadastro['Senha'],
                'IDCadastro' => $cadastrado->IDCadastro,
                'CodigoVerificacaoEmail' => $codigoVerificacaoEmail,
            );
            $user = User::create($dataUsuario);

            Mail::to([$cadastrado->Email])->send(new VerificacaoEmail([
                'nome' => $cadastrado->Nome,
                'telefone' => $cadastrado->Telefone,
                'email' => $cadastrado->Email,
                'data' => now(),
                'endereco' => $cadastrado->Endereco . ', ' . $cadastrado->Bairro . ', ' . $cadastrado->Cidade . ', ' . $cadastrado->Estado,
                'id' => $cadastrado->IDCadastro,
                'codigo' => $codigoVerificacaoEmail,
            ]));
            return redirect("usuario")->with('sucesso', 'Cadastrado com sucesso! Verifique a sua caixa de entrada do email para realizar a validação!');
        } catch (Exception $ex) {
            return redirect()->back()->with('erro', 'Houve um erro ao cadastrar o usuário:' . $ex->getMessage());
        }
    }

    public function verificarEmail($id, $codigo)
    {
        $usuario = User::where('IDCadastro', $id)
            ->where('CodigoVerificacaoEmail', $codigo)
            ->first();

        if ($usuario) {
            $usuario->update([
                'EmailConfirmado' => 1,
                'CodigoVerificacaoEmail' => null,
            ]);

            return redirect('usuario')->with('sucesso', 'Seu email foi verificado com sucesso!');
        } else {
            return redirect('usuario')->with('erro', 'Link incorreto!');
        }
    }

    public function recoverPassword(Request $request)
    {
        $email = $request->input('email');
        $cadastro = Cadastro::where('Email', $email)->first();

        if (!$cadastro) {
            return redirect('/recoverPassword')->with('erro', 'Email não encontrado em nosso cadastro!');
        }
        $usuario = User::where('IDCadastro', $cadastro->IDCadastro)->first();
        
        if ($usuario->Status == "Suspendida") {
            return redirect('/recoverPassword')->with('erro', 'Essa conta foi suspendida, contate o administrador do sistema!');
        }
        $token = bin2hex(random_bytes(15));

        $usuario->update(['TokenRecuperacaoSenha' => $token]);

        Mail::to([$cadastro->Email])->send(new RecuperarSenha([
            'id' => $usuario->IDUsuario,
            'nome' => $cadastro->Nome,
            'token' => $token
        ]));

        return redirect('/usuario')->with('sucesso', 'Solicitação enviada com sucesso! Verifique sua caixa de email!');
    }

    public function changePassword(Request $request)
    {
        $token = $request->input('token');
        $id = $request->input('id');
        $senha = bcrypt($request->input('senha'));

        $usuario = User::find($id);
        if (!$usuario) {
            return redirect('/usuario')->with('erro', 'Link Inválido!');
        }
        if ($usuario->Status == "Suspendida") {
            return redirect('/usuario')->with('erro', 'Essa conta foi suspendida, contate o administrador do sistema!');
        }
        if ($usuario->TokenRecuperacaoSenha != $token) {
            return redirect('/usuario')->with('erro', 'Link Inválido!');
        }

        $usuario->update(['Senha' => $senha, 'TokenRecuperacaoSenha' => null]);

        Mail::to([$usuario->cadastro->Email])->send(new SenhaAlterada([
            'data' => now()->format('d/m/Y H:i:s'),
        ]));

        return redirect('/usuario')->with('sucesso', 'Senha alterada com sucesso!');
    }
}
