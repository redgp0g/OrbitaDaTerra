<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carta extends Model
{
    use HasFactory;

    protected $table = 'Carta';
    protected $primaryKey = 'IDCarta';

    public $timestamps = false;
    
    public function tipoCarta()
    {
        return $this->belongsTo(TipoCarta::class, 'IDTipoCarta', 'IDTipoCarta');
    }
}
