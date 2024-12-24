@extends('master')
@section('title', 'Detalhes da Carta Nova')

@section('conteudo')
  @include('components.navbarHome', ['cadastroId' => $cadastro->IDCadastro])

  <div class="section mt-3">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-12">
          <div id="product-main-img">
            <div class="product-preview">
              <img class="img-thumbnail" src="{{ asset('/images/tipoproduto/' . $carta->tipoCarta->Imagem) }}">
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="product-details">
            <h2 class="product-name">Consórcio de {{ $carta->tipoCarta->Descricao }}</h2>
            <div>
              <h3 class="product-price">R$ {{ number_format($carta->ValorCredito, 2, ',', '.') }}</h3>
            </div>
            <ul class="product fs-5 my-3">
              <li>Parcela Integral: R$ {{ number_format($carta->ParcelaIntegral, 2, ',', '.') }}</li>
              <li>Parcela Flex: R$ {{ number_format($carta->ParcelaFlex, 2, ',', '.') }}</li>
              <li>Prazo: {{ $carta->Prazo }} Meses</li>
              <li>Grupo: {{ $carta->Grupo }}</li>
              {{-- <li><a href="#"><i class="fa fa-twitter"></i></a></li> --}}
            </ul>

            <div class="add-to-cart">
              <button class="btn btn-success"><i class="fa fa-shopping-cart"></i> Comprar</button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section my-3">
    <div class="container">
      <div class="row">
        <div class="section-title text-center">
          <h3 class="title">Cartas Semelhantes</h3>
        </div>
        @foreach ($cartasSemelhantes as $cartaSemelhante)
          <div class="col">
            <div class="card">
              <div class="card-body">
                <span class="text-danger">Crédito</span>
                <p>R$ {{ number_format($cartaSemelhante->ValorCredito, 2, ',', '.') }}</p>
                <span class="text-danger">Parcela Flex</span>
                <p>R$ {{ number_format($cartaSemelhante->ParcelaFlex, 2, ',', '.') }}</p>
                <span class="text-danger">Prazo</span>
                <p>{{ $carta->Prazo }} Meses</p>
                <a class="btn btn-info fs-6" href="{{ url('/detalhesCartaNova/' . $cartaSemelhante->IDCarta . '/' . $cadastro->IDCadastro) }}">Detalhes</a>
              </div>
            </div>
          </div>
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

      var linkWhatsApp = 'https://api.whatsapp.com/send?phone=' + numeroVendedor + '&text=' +
        mensagemPadrao;

      window.location.href = linkWhatsApp;
    }
  </script>
@endsection
