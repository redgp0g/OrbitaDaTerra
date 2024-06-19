<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartaVendida extends Model
{
    use HasFactory;

    protected $table = 'CartaVendida';
    protected $primaryKey = 'IDCartaVendida';

    public $timestamps = false;

    protected $fillable = [
        'IDEmpresaAdministradora',
        'IDEmpresaAutorizada',
        'IDCadastroConsorciado',
        'IDCadastroVendedor',
        'IDTipoCarta',
        'Status',
        'ValorCredito',
        'ValorPago',
        'ValorVenda',
        'SaldoDevedor',
        'ParcelasPagas',
        'ParcelasPagar',
        'ValorParcela',
        'DiaVencimento',
        'ValorGarantia',
        'Grupo',
        'Cota',
        'TaxaTransferencia',
        'Contemplada',
    ];
}
