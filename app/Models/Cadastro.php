<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    use HasFactory;

    protected $table = 'Cadastro';
    protected $primaryKey = 'IDCadastro';

    public $timestamps = false;
    
    protected $fillable = [
        'IDUltimoCadastroVendedor',
        'ObservacoesUltimoVendedor',
        'DataUltimoVendedor',
        'IDCadastroVendedor',
        'IDCadastroIndicador',
        'IDCadastroVendedorIndicado',
        'Nome',
        'Telefone',
        'CPF',
        'Email',
        'CEP',
        'Endereco',
        'Complemento',
        'Bairro',
        'Cidade',
        'Estado',
        'Origem',
        'TipoCadastro',
        'DataNascimento',
        'DataCadastro',
        'Observacoes',
        'NumeroCasa',
        'Curriculo',
        'AtividadeVendedor',
        'PrevisaoAtividadeVendedor',
    ];
}
