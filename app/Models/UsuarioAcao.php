<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class UsuarioAcao extends Model
{
    use HasFactory;

    protected $table = 'UsuarioAcao';
    protected $primaryKey = 'IDUsuarioAcao';
    public $timestamps = false;
    protected $fillable = [
        'IDUsuario',
        'Descricao',
        'DataHora',
        'EnderecoIp',
        'Navegador',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'IDUsuario', 'IDUsuario');
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->dataHora = now();
        });
    }

    public static function registrarAcao(int $IDUsuario, string $descricao)
    {
        return self::create([
            'IDUsuario' => $IDUsuario,
            'Descricao' => $descricao,
            'EnderecoIp' => request()->ip(),
            'Navegador' => request()->header('User-Agent'),
        ]);
    }
}
