<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcao extends Model
{
    use HasFactory;

    protected $table = 'Funcao';
    protected $primaryKey = 'IDFuncao';

    public $timestamps = false;

}
