<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoAcesso extends Model
{
    use HasFactory;

    protected $table = 'HistoricoAcesso';
    protected $primaryKey = 'IDHistoricoAcesso';

    public $timestamps = false;

    protected $fillable = [
        'IDUsuario',
        'DataEntrada',
        'DataSaida'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'IDUsuario', 'IDUsuario');
    }
}
