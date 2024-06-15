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
        'RazaoSocial',
        'Telefone',
        'CPF',
        'Email',
        'CEP',
        'Endereco',
        'Complemento',
        'Bairro',
        'NumeroCasa',
        'Cidade',
        'Estado',
        'Origem',
        'IDTipoCartaInteresse',
        'TipoCadastro',
        'DataNascimento',
        'DataCadastro',
        'Observacoes',
        'Curriculo',
        'AtividadeVendedor',
        'PrevisaoAtividadeVendedor',
    ];
}
