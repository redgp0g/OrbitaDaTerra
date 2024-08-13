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
                        <h2 class="card-title fs-4 text-center mb-1">Consórcio de <span style="color: #1e9ef3">{{ $tipoCarta->Descricao }}</span></h2>
                        <div class="d-flex align-items-center justify-content-center">
                            <img class="img-thumbnail " src="{{ asset('/images/tipoproduto/' . $tipoCarta->Imagem) }}">
                        </div>
                        <div class="row">
                            <div class="items">
                                @foreach ($cartasPorTipo as $carta)
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="card-text"><span class="text-danger">Crédito:</span>
                                                R$ {{ number_format($carta->ValorCredito, 2, ',', '.') }}</p>
                                            <p class="card-text"><span class="text-danger">Parcela Flex:</span>
                                                R$ {{ number_format($carta->ParcelaFlex, 2, ',', '.') }}</p>
                                            <p class="card-text"><span class="text-danger">Prazo:</span> {{ $carta->Prazo }}
                                                Meses</p>
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
    
    <button class="floatSimulacao fs-5" onclick="window.location.href = '/simulacao/{{ $cadastro->IDCadastro }}'"><div class="mx-2">Simular Agora</div></button>
    @include('components.faleComOVendedor', ['cadastro' => $cadastro])

    <script>
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