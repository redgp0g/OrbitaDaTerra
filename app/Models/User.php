<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    
    protected $table = 'Usuario';
    protected $primaryKey = 'IDUsuario';

    protected $fillable = [
        'Login',
        'Senha',
        'IDCadastro',
        'DataCadastro',
        'EmailConfirmado',
        'CodigoVerificacaoEmail',
        'AdminConfirmado',
        'ContaSuspendida',
        'TokeRecuperacaoSenha',
        'is_migrated'
    ];

    protected $hidden = [
        'Senha',
    ];

    public $timestamps = false;
    
    public function getAuthPassword()
    {
        return $this->Senha;
    }

    protected static function booted()
    {
        static::creating(function ($usuario) {
            $usuario->DataCadastro = now();
            $usuario->EmailConfirmado = 0;
            $usuario->AdminConfirmado = 0;
            $usuario->ContaSuspendida = 0;
        });
    }

    public function  cadastro() {
        return $this->belongsTo(Cadastro::class, 'IDCadastro','IDCadastro');
    }
}
