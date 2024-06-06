<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCarta extends Model
{
    use HasFactory;

    protected $table = 'TipoCarta';
    protected $primaryKey = 'IDTipoCarta';

    public function cartas()
    {
        return $this->hasMany(Carta::class, 'IDTipoCarta', 'IDTipoCarta');
    }
}
