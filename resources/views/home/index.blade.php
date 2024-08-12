@extends('master')
@section('title', 'Cartas Novas')
@section('conteudo')
    @include('components.navbarHome', [
        'items' => [
            [
                'label' => 'Cartas Contempladas',
                'url' => url('/contempladas/' . $cadastro->IDCadastro),
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

<div class="section 3" style="min-height: 85vh;">
    <div class="container">
        <div class="row">
                @foreach ($tiposCartas as $tipoCarta)
                    @php
                        $cartasPorTipo = $cartas->filter(function ($carta) use ($tipoCarta) {
                            return $carta->IDTipoCarta == $tipoCarta->IDTipoCarta;
                        }); 
                    @endphp
                    <div class="col-md-12">
                        <div class="row">
                            <div class="items">
                                @foreach ($sortedCartas as $carta)
                                    <div class="card">
                                        <img src="{{ asset('/images/tipoproduto/' . $carta->tipocarta->Imagem) }}">
                                        <div class="card-body">
                                            <h5 class="card-title">Consórcio de {{ $carta->tipocarta->Descricao }}</h5>
                                            <p class="card-text"><span class="text-danger">Crédito:</span>
                                                R$ {{ number_format($carta->ValorCredito, 2, ',', '.') }}</p>
                                            <p class="card-text"><span class="text-danger">Parcela Integral:</span>
                                                R$ {{ number_format($carta->ParcelaIntegral, 2, ',', '.') }}</p>
                                            <p class="card-text"><span class="text-danger">Parcela Flex
                                                    ({{ number_format($carta->PercentualFlex) }}%)
                                                    : </span>
                                                R$ {{ number_format($carta->ParcelaFlex, 2, ',', '.') }}</p>
                                            <p class="card-text"><span class="text-danger">Prazo:</span> {{ $carta->Prazo }}
                                                Meses</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    
    <button class="floatSimulacao fs-5" onclick="window.location.href = '/simulacao'"><div class="mx-2">Simular Agora</div></button>
    @include('components.faleComOVendedor', ['cadastro' => $cadastro])

    <script>
        $(document).ready(function() {
            $('.items').slick({
                infinite: true,
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                responsive: [{
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 700,
                        settings: {
                            arrows: false,
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 520,
                        settings: {
                            arrows: false,
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        }
                    },
                ]
            });
        });

    </script>
@endsection