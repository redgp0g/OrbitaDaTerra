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
            $codigoVerificacaoEmail = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            $cadastrado = Cadastro::create($cadastro) ?? Cadastro::where('Email', $cadastro['Email'])->first()->update($cadastro);
            
            $dataUsuario = array(
                'Login' => $cadastrado->Email,
                'Senha' => $cadastro['Senha'],
                'IDCadastro' => $cadastrado->IDCadastro,
                'CodigoVerificacaoEmail' => $codigoVerificacaoEmail,
            );
            $user = User::create($dataUsuario);

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
}