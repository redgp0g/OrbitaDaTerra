@extends('master')
@section('title', 'Cartas Novas')
@section('conteudo')
    @include('components.navbarHome', [
        'items' => [
            [
                'label' => 'Cartas À Venda',
                'url' => url('/cartasAVenda/' . $cadastro->IDCadastro),
                'auth' => 'all',
            ],
            ['label' => 'Dashboard', 'url' => url('/dashboard'), 'auth' => 'auth'],
            ['label' => 'Acessar Conta', 'url' => url('/usuario'), 'auth' => 'guest'],
            [
                'label' => 'Cadastrar-se',
                'url' => url('/usuario/create/' . $cadastro->IDCadastro),
                'auth' => 'guest',
            ],
        ],
    ])

    <div class="section 3 mt-3" style="min-height: 85vh;">
        <div class="container">
            <div class="row">
                @foreach ($tiposCartas as $tipoCarta)
                    @php
                        $cartasPorTipo = $cartas->filter(function ($carta) use ($tipoCarta) {
                            return $carta->IDTipoCarta == $tipoCarta->IDTipoCarta;
                        });
                    @endphp
                    @if ($cartasPorTipo->count() > 0)
                        <div class="col-md-4">
                            <h2 class="card-title fs-4 text-center mb-1">Consórcio de <span
                                    style="color: #1e9ef3">{{ $tipoCarta->Descricao }}</span></h2>
                            <div class="d-flex align-items-center justify-content-center">
                                <img class="img-thumbnail " src="{{ asset('/images/tipoproduto/' . $tipoCarta->Imagem) }}">
                            </div>
                            <div class="row">
                                <div class="items">
                                    @foreach ($cartasPorTipo as $carta)
                                        <div class="card">
                                            <div class="card-body">
                                                <span class="text-danger">Crédito</span>
                                                <p>R$ {{ number_format($carta->ValorCredito, 2, ',', '.') }}</p>
                                                <span class="text-danger">Parcela Flex</span>
                                                <p>R$ {{ number_format($carta->ParcelaFlex, 2, ',', '.') }}</p>
                                                <span class="text-danger">Prazo</span>
                                                <p>{{ $carta->Prazo }} Meses</p>
                                                <button class="btn btn-success"
                                                    data-carta-categoria="{{ $carta->TipoCarta->Descricao }}"
                                                    data-carta-valor="R$ {{ number_format($carta->ValorCredito, 2, ',', '.') }}"
                                                    data-carta-flex="R$ {{ number_format($carta->ParcelaFlex, 2, ',', '.') }}"
                                                    data-carta-prazo="{{ $carta->Prazo }}"
                                                    onclick="comprarCarta(this)">Comprar</button>
                                                {{-- <button class="btn btn-info fs-6">Detalhes</button> --}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="d-flex align-items-end flex-column position-fixed bottom-0 end-0 m-5 gap-3" style="z-index: 1100;">
        @include('components.faleComOVendedor', ['cadastro' => $cadastro])
        {{-- <livewire:simulacao :cadastro="$cadastro" :vendedor="$vendedor" /> --}}
        <button class="fs-5 p-1 text-white rounded rounded-pill" style="background-color: #1e9ef3" onclick="window.location.href = '/simulacao/{{ $cadastro->IDCadastro }}'">Simular Agora</button>
        <button class="fs-5 bg-success text-white rounded rounded-pill p-1 px-2" onclick="window.location.href = '/carta-a-venda/8'">Venda sua Carta</button>
    </div>

    <script>
        function comprarCarta(button) {
            var numeroVendedor = {{ $vendedor->Telefone }}
            var mensagemPadrao = "Olá, eu gostaria de comprar um Consórcio de " + button.dataset.cartaCategoria +
                "! Valor de crédito: " + button.dataset.cartaValor + ", Parcela Flex: " + button.dataset.cartaFlex +
                ", Prazo: " + button.dataset.cartaPrazo + " meses";

            mensagemPadrao = encodeURIComponent(mensagemPadrao);

            var linkWhatsApp = 'https://api.whatsapp.com/send?phone=' + numeroVendedor + '&text=' +
                mensagemPadrao;

            window.location.href = linkWhatsApp;
        }
        $(document).ready(function() {
            $('.items').slick({
                infinite: true,
                slidesToShow: 2,
                slidesToScroll: 1,
                autoplay: true,
                arrows: false,
                autoplaySpeed: 10000,
            });
        });
    </script>
@endsection