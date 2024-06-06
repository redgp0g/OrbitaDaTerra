@extends('master')
@section('title', 'Cartas Novas')
@section('conteudo')
    @include('components.navbarHome', [
        'items' => [
            ['label' => 'Cartas Contempladas', 'url' => url('/contempladas/' . $cadastro->IDCadastro), 'auth' => 'guest'],
            ['label' => 'Dashboard', 'url' => url('/dashboard'), 'auth' => 'auth'],
            ['label' => 'Acessar Conta', 'url' => url('/usuario'), 'auth' => 'guest'],
            ['label' => 'Cadastrar-se', 'url' => url('/usuario' . $cadastro->IDCadastro), 'auth' => 'guest'],
            ['label' => 'Fazer Simulação', 'url' => url('/simulacao/' . $cadastro->IDCadastro), 'auth' => 'auth'],
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
                    <div class="col-md-12">
                        <div class="row">
                            <div class="items">
                                @foreach ($sortedCartas as $carta)
                                    <div class="card">
                                        <img src="{{ asset('/images/tipoproduto/' . $carta->tipocarta->Imagem) }}">
                                        <div class="card-body">
                                            <h5 class="card-title">Consórcio de {{ $carta->Descricao }}</h5>
                                            <p class="card-text"><span class="text-danger">Crédito:</span>
                                                R${{ number_format($carta->ValorCredito, 2, ',', '.') }}</p>
                                            <p class="card-text"><span class="text-danger">Parcela Integral:</span>
                                                R${{ number_format($carta->ParcelaIntegral, 2, ',', '.') }}</p>
                                            <p class="card-text"><span class="text-danger">Parcela Flex
                                                    ({{ number_format($carta->PercentualFlex) }}%)
                                                    : </span>
                                                R${{ number_format($carta->ParcelaFlex, 2, ',', '.') }}</p>
                                            <p class="card-text"><span class="text-danger">Prazo:</span> {{ $carta->Prazo }}
                                                Meses</p>
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

    <dialog id="dialogFaleVendedor" class="rounded rounded-4 border border-0 p-5" style="z-index: 100;">
        <button style="right: 10px; top:10px" class="position-absolute" id="fecharDialog"
            onclick="dialogFaleVendedor.close()"><i class="fa fa-times"></i></button>
        <h2 class="mb-2">Preencha para conversar com um Vendedor</h2>
        <h4 class="text-center text-danger fs-6">Os campos com * são obrigatórios</h4>
        <form id="enviarDados" method="post" action="/public/index.php/enviardados">
            <div class="mb-3">
                <label for="Nome" class="form-label">Nome <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="Nome" name="Nome" placeholder="Nome" autofocus
                    required />
            </div>
            <div class="mb-3">
                <label for="celular" class="form-label">Celular <span class="text-danger">*</span></label>
                <input type="text" class="form-control celular" id="celular" name="Telefone"
                    placeholder="Digite seu celular com DDD" maxlength="16" required pattern="\(\d{2}\) \d{5}-\d{4}" />
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control email" name="Email" placeholder="Digite seu e-mail" />
            </div>
            <input type="hidden" name="numerovendedor" id="numerovendedor" value="<?php echo $cadastro->Telefone; ?>">
            <button type="submit" id="btnCadastro" class="btn btn-primary d-grid w-100">Continuar</button>
        </form>
    </dialog>

    <button class="float fs-1" target="_blank" id="btnmodal" onclick="dialogFaleVendedor.showModal()"><i
            class="fa fa-whatsapp px-2"></i></button>

    <script>
        const dialogFaleVendedor = document.getElementById('dialogFaleVendedor');

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

        $('.email').on('focusout', function() {
            let email = this.val();
            validarEmail(email, this);
        });
    </script>
@endsection
