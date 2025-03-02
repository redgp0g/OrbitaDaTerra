<?php

use App\Models\CartaVendida;
use Livewire\Volt\Component;
use App\Models\Cadastro;
use Livewire\Attributes\{Layout, Title};

new 
#[Layout('app')] 
#[Title('Detalhes Carta Vendida')] 
class extends Component {
    public $idCarta;
    public $idVendedor;

    public $cadastro;
    public $vendedor;
    public $carta;
    public $cartasSemelhantes;

    public function mount($idCarta, $idVendedor)
    {
        $this->idCarta = $idCarta;
        $this->idVendedor = $idVendedor;

        $this->cadastro = Cadastro::find($idVendedor);
        if (!$this->cadastro || !in_array($this->cadastro->TipoCadastro, ['Vendedor', 'Indicador'])) {
            $this->cadastro = Cadastro::find(38);
        }
        $this->vendedor = $this->cadastro->TipoCadastro == 'Vendedor' ? $this->cadastro : Cadastro::find($this->cadastro->IDVendedorIndicado);

        $this->carta = CartaVendida::find($idCarta);
    }

    public function chamarWhatsapp()
    {
        $numeroVendedor = $this->vendedor->Telefone;
        $mensagemPadrao = 'Olá, eu gostaria de reservar uma Carta Contemplada de ' . $this->carta->tipoCarta->Descricao . 
        '! Valor da Parcela: R$ ' . number_format($this->carta->ValorCredito, 2, ',', '.') . 
        ', Parcela Flex: R$ ' . number_format($this->carta->ParcelaFlex, 2, ',', '.') . 
        ', Parcelas à Pagar: ' . $this->carta->ParcelasPagar . ' meses';

        $mensagemPadrao = urlencode($mensagemPadrao);

        return redirect()->to('https://api.whatsapp.com/send?phone=' . $numeroVendedor . '&text=' . $mensagemPadrao); 
    }
}; 
?>

<div style="min-height: 95vh">
    @include('components.navbarHome', ['cadastroId' => $cadastro->IDCadastro])

    <div class="section mt-3">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-12">
                    <div id="product-main-img">
                        <div class="product-preview">
                            <img class="img-thumbnail"
                                src="{{ asset('/images/tipoproduto/' . $carta->tipoCarta->Imagem . '800x500.webp') }}" />
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="product-details">
                        <h2 class="product-name">Carta Contemplada de {{ $carta->TipoCarta->Descricao }}</h2>
                        <div>
                            <h3 class="product-price">R$ {{ number_format($carta->ValorCredito, 2, ',', '.') }}</h3>
                        </div>
                        <ul class="product fs-5 my-3">
                            <li>Valor da Parcela: R$ {{ number_format($carta->ValorParcela, 2, ',', '.') }}</li>
                            <li>Parcelas à Pagar: {{ $carta->ParcelasPagar }}</li>
                            <li>Dia de Vencimento: {{ $carta->DiaVencimento }}</li>
                            <li>Grupo: {{ $carta->Grupo }}</li>
                        </ul>

                        <div class="add-to-cart">
                            <button class="btn btn-success" wire:click="chamarWhatsapp({{ $carta }})">
                                <i class="fa fa-shopping-cart"></i>Reservar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.floatMenu', ['cadastro' => $cadastro, 'vendedor' => $vendedor])
</div>
