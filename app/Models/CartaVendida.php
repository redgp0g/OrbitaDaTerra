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

    public function tipoCarta()
    {
        return $this->belongsTo(TipoCarta::class, 'IDTipoCarta', 'IDTipoCarta');
    }

    public function empresaAdministradora()
    {
        return $this->belongsTo(Empresa::class, 'IDEmpresaAdministradora', 'IDEmpresa');
    }
    
    public function empresaAutorizada()
    {
        return $this->belongsTo(Empresa::class, 'IDEmpresaAutorizada', 'IDEmpresa');
    }
    
    public function cadastroConsorciado()
    {
        return $this->belongsTo(Cadastro::class, 'IDCadastroConsorciado', 'IDCadastro');
    }
    
    public function cadastroVendedor()
    {
        return $this->belongsTo(Cadastro::class, 'IDCadastroVendedor', 'IDCadastro');
    }

}
