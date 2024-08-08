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
                @for ($x = 1; $x <= 7; $x++)
                    @php
                        $filteredCartas = $cartas->filter(function ($carta) use ($x) {
                            return $carta->IDTipoCarta == $x;
                        });

                        $sortedCartas = $filteredCartas->sort(function ($a, $b) {
                            if ($a->Prazo != $b->Prazo) {
                                return $b->Prazo - $a->Prazo;
                            }

                            return $b->ValorCredito - $a->ValorCredito;
                        });
                    @endphp
                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-center">
                            <img class="img-thumbnail" src="{{ asset('/images/tipoproduto/3d-rendering-house-model.jpg') }}">
                        </div>
                        <h5 class="card-title">Consórcio de Carros</h5>
                        <div class="row">
                            <div class="items">
                                @foreach ($sortedCartas as $carta)
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="card-text"><span class="text-danger">Crédito:</span>
                                                R$ {{ number_format($carta->ValorCredito, 2, ',', '.') }}</p>
                                            <p class="card-text"><span class="text-danger">Parcela Integral:</span>
                                                R$ {{ number_format($carta->ParcelaIntegral, 2, ',', '.') }}</p>
                                            <p class="card-text"><span class="text-danger">Prazo:</span> {{ $carta->Prazo }}
                                                Meses</p>
                                            <button class="btn btn-success fs-6 h-auto w-auto">Reservar</button>
                                            <button class="btn btn-info fs-6">Detalhes</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

    </div>
    
    <button class="floatSimulacao fs-5" onclick="window.location.href = '/simulacao'"><div class="mx-2">Simular Agora</div></button>
    @include('components.faleComOVendedor', ['cadastro' => $cadastro])

    <script>
        $(document).ready(function() {
            $('.items').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 10000,
                responsive: [{
                        breakpoint: 700,
                        settings: {
                            arrows: false,
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 520,
                        settings: {
                            arrows: false,
                            slidesToShow: 2,
                        }
                    },
                ]
            });
        });
    </script>
@endsection
