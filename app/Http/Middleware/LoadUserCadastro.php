<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoadUserCadastro
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cadastro = \App\Models\Cadastro::find($user->IDCadastro);
            $user->cadastro = $cadastro;
        }

        return $next($request);
    }
}
