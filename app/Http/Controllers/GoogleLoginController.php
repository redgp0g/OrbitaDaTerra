<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UsuarioAcao;
use Google_Client;

class GoogleLoginController extends Controller
{
    public function handleGoogleCallback(Request $request)
    {
        $client = new Google_Client(['client_id' =>  env('GOOGLE_CLIENT_ID')]);
        $id_token = $request->input('credential');
        $google_user = $client->verifyIdToken($id_token);

        if (!$google_user) {
            return response()->json(['error' => 'Token inválido',], 401);
        }
        
        $user = User::where('Login', $google_user['email'])->first();
        if ($user && !$user->is_migrated) {
            $user->Senha = bcrypt($user->Senha);
            $user->is_migrated = true;
            $user->save();
        }
        if ($user && !$user->IDGoogle) {
            $user->IDGoogle = $google_user['sub'];
            $user->Foto = $google_user['picture'] ?? null;
            $user->save();
        }
        if (!$user) {
            return redirect()->route('usuario.create')->with('erro', 'Usuário não encontrado, faça seu cadastro!');
        }

        Auth::login($user);
        UsuarioAcao::registrarAcao($user->IDUsuario,'Acessou com conta google');

        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }
}
