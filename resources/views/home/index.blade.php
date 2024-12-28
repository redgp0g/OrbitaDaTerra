@extends('master')
@section('title', 'Cartas Novas')
@section('conteudo')
  @include('components.navbarHome', ['cadastroId' => $cadastro->IDCadastro])

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
                <img alt="imagem do produto" class="img-thumbnail " src="{{ asset('/images/tipoproduto/' . $tipoCarta->Imagem) }}">
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
                        <button class="btn btn-success" data-carta-categoria="{{ $carta->TipoCarta->Descricao }}"
                          data-carta-valor="R$ {{ number_format($carta->ValorCredito, 2, ',', '.') }}"
                          data-carta-flex="R$ {{ number_format($carta->ParcelaFlex, 2, ',', '.') }}" data-carta-prazo="{{ $carta->Prazo }}" onclick="comprarCarta(this)"><i
                            class="fa fa-shopping-cart"></i> Comprar</button>
                        <a class="btn btn-info fs-6 my-3" href="{{ url('/detalhesCartaNova/' . $carta->IDCarta . '/' . $cadastro->IDCadastro) }}">Detalhes</a>
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

  @include('components.floatMenu', ['cadastro' => $cadastro, 'vendedor' => $vendedor])

  <script>
    function comprarCarta(button) {
      var numeroVendedor = {{ $vendedor->Telefone }}
      var mensagemPadrao = "Olá, eu gostaria de comprar um Consórcio de " + button.dataset.cartaCategoria +
        "! Valor de crédito: " + button.dataset.cartaValor + ", Parcela Flex: " + button.dataset.cartaFlex +
        ", Prazo: " + button.dataset.cartaPrazo + " meses";

      mensagemPadrao = encodeURIComponent(mensagemPadrao);
  
      window.location.href = 'https://api.whatsapp.com/send?phone=' + numeroVendedor + '&text=' +
          mensagemPadrao;
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
