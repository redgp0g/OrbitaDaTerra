<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simulacao extends Model
{
    use HasFactory;

    protected $table = 'Simulacao';
    protected $primaryKey = 'IDSimulacao';
    
    public $timestamps = false;

    protected $fillable = [
        'IDCadastro',
        'IDTipoCarta',
        'Credito',
        'Prazo',
    ];
}
