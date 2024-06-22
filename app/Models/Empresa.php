<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'Empresa';
    protected $primaryKey = 'IDEmpresa';

    public $timestamps = false;

    protected $fillable = [
        'CNPJ',
        'NomeFantasia',
        'RazaoSocial',
        'Telefone',
        'NomeRepresentante',
        'CelularRepresentante',
        'EmailRepresentante',
        'CEP',
        'Endereco',
        'Numero',
        'Bairro',
        'Cidade',
        'Estado',
        'Complemento',
        'TipoEmpresa',
        'DataCadastro',
        'Observacoes',
    ];
}
