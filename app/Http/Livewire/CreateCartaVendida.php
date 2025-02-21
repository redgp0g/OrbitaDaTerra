<?php

namespace App\Http\Livewire;

use App\Models\Cadastro;
use App\Models\CartaVendida;
use App\Models\Empresa;
use App\Models\TipoCarta;
use Livewire\Component;

class CreateCartaVendida extends Component
{
    public $IDEmpresaAdministradora, $Nome, $Celular, $IDTipoCarta, $ValorCredito, $ValorPago, $ValorVenda,
        $SaldoDevedor, $ParcelasPagas, $ParcelasPagar, $ValorParcela, $DiaVencimento, $ValorGarantia, $Grupo,
        $Cota, $TaxaTransferencia, $ComissaoAutorizada, $Contemplada, $IDCadastroConsorciado,$Observacoes;

    public $administradoras, $tiposCartas, $autorizada;


    public function mount($idAutorizada = 8)
    {
        $this->autorizada = Empresa::find($idAutorizada) ?: Empresa::find(8);
        $this->tiposCartas = TipoCarta::all();
        $this->administradoras = Empresa::where('TipoEmpresa', 'Administradora')->get();
    }

    public function updatedCelular()
    {
        $cadastro = Cadastro::where('Telefone', preg_replace('/\D/', '', $this->Celular))->first();
        if ($cadastro) {
            $this->Nome = $cadastro->Nome;
            $this->IDCadastroConsorciado = $cadastro->IDCadastro;
        } else {
            $this->Nome = '';
            $this->IDCadastroConsorciado = null;
        }
    }

    public function submit()
    {
        if (!$this->IDCadastroConsorciado) {
            $cadastro = Cadastro::create([
                'Nome' => $this->Nome,
                'Telefone' => preg_replace('/\D/', '', $this->Celular),
                'TipoCadastro' => 'Consorciado',
            ]);

            $this->IDCadastroConsorciado = $cadastro->IDCadastro;
        }

        $this->ValorCredito = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $this->ValorCredito));
        $this->ValorPago = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $this->ValorPago));
        $this->ValorVenda = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $this->ValorVenda));
        $this->SaldoDevedor = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $this->SaldoDevedor));
        $this->ValorParcela = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $this->ValorParcela));
        $this->ValorGarantia = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $this->ValorGarantia));
        $this->TaxaTransferencia = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $this->TaxaTransferencia));
        if($this->IDEmpresaAdministradora == ""){
            $this->IDEmpresaAdministradora = null;
        }
        CartaVendida::create([
            'IDEmpresaAdministradora' => $this->IDEmpresaAdministradora,
            'IDCadastroConsorciado' => $this->IDCadastroConsorciado,
            'IDTipoCarta' => $this->IDTipoCarta,
            'ValorCredito' => $this->ValorCredito,
            'ValorPago' => $this->ValorPago,
            'ValorVenda' => $this->ValorVenda,
            'SaldoDevedor' => $this->SaldoDevedor,
            'ParcelasPagas' => $this->ParcelasPagas,
            'ParcelasPagar' => $this->ParcelasPagar,
            'ValorParcela' => $this->ValorParcela,
            'ValorGarantia' => $this->ValorGarantia,
            'DiaVencimento' => $this->DiaVencimento,
            'Grupo' => $this->Grupo,
            'Cota' => $this->Cota,
            'TaxaTransferencia' => $this->TaxaTransferencia,
            'ComissaoAutorizada' => $this->ComissaoAutorizada,
            'Contemplada' => $this->Contemplada,
            'IDEmpresaAutorizada' => $this->autorizada->IDEmpresa,
            'Observacoes' => $this->Observacoes,
            'Status' => 'Em Aprovação',
        ]);

        return redirect()->to('/carta-a-venda')->with('alerta', 'Sua carta está em aprovação!');
    }


    public function render()
    {
        return view('livewire.create-carta-vendida');
    }
}
