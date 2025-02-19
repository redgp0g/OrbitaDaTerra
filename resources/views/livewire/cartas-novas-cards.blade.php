<div>
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
              <h2 class="card-title fs-4 mb-1 text-center">Consórcio de <span
                  style="color: #1e9ef3">{{ $tipoCarta->Descricao }}</span></h2>
              <div class="d-flex align-items-center justify-content-center">
                <img class="img-thumbnail" src="{{ asset('/images/tipoproduto/' . $tipoCarta->Imagem) }}"
                  alt="imagem do produto" width="500" height="400" loading="lazy" decoding="async">
              </div>
              <div class="row">
                <div class="carousel carousel-dark slide" id="carousel-{{ $tipoCarta->IDTipoCarta }}" data-bs-ride="carousel" data-bs-interval="2000" data-bs-pause="hover">
                  <div class="carousel-inner">
                    @foreach ($cartasPorTipo->chunk(2) as $chunk)
                      <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row">
                          @foreach ($chunk as $carta)
                            <div class="col-md-6">
                              <div class="card">
                                <div class="card-body">
                                  <span class="text-danger">Crédito</span>
                                  <p>R$ {{ number_format($carta->ValorCredito, 2, ',', '.') }}</p>
                                  <span class="text-danger">Parcela Flex</span>
                                  <p>R$ {{ number_format($carta->ParcelaFlex, 2, ',', '.') }}</p>
                                  <span class="text-danger">Prazo</span>
                                  <p>{{ $carta->Prazo }} Meses</p>
                                  <button class="btn btn-success comprar"
                                    data-carta-categoria="{{ $carta->TipoCarta->Descricao }}"
                                    data-carta-valor="R$ {{ number_format($carta->ValorCredito, 2, ',', '.') }}"
                                    data-carta-flex="R$ {{ number_format($carta->ParcelaFlex, 2, ',', '.') }}"
                                    data-carta-prazo="{{ $carta->Prazo }}"><i class="fa fa-shopping-cart"></i>
                                    Comprar</button>
                                  <a class="btn btn-info fs-6 my-3"
                                    href="{{ url('/detalhesCartaNova/' . $carta->IDCarta . '/' . $cadastro->IDCadastro) }}">Detalhes</a>
                                </div>
                              </div>
                            </div>
                          @endforeach
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <button class="carousel-control-prev text-black" data-bs-target="#carousel-{{ $tipoCarta->IDTipoCarta }}"
                    data-bs-slide="prev" type="button">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" data-bs-target="#carousel-{{ $tipoCarta->IDTipoCarta }}"
                    data-bs-slide="next" type="button">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    </div>
  </div>
  @script
    <script>
      $(document).ready(function() {
        $('.comprar').click(function() {
          let button = $(this)[0];
          let numeroVendedor = {{ $vendedor->Telefone }};
          let mensagemPadrao = "Olá, eu gostaria de comprar um Consórcio de " + button.dataset.cartaCategoria +
            "! Valor de crédito: " + button.dataset.cartaValor + ", Parcela Flex: " + button.dataset.cartaFlex +
            ", Prazo: " + button.dataset.cartaPrazo + " meses";

          mensagemPadrao = encodeURIComponent(mensagemPadrao);

          window.location.href = 'https://api.whatsapp.com/send?phone=' + numeroVendedor + '&text=' +
            mensagemPadrao;
        });
      });
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ItemList",
      "itemListElement": [
    @foreach ($cartas as $index => $carta)
        {
          "@type": "ListItem",
          "position": {{ $index + 1 }},
    "item": {
        "@type": "Product",
        "name": "{{ $carta->TipoCarta->Descricao }}
            - Consórcio de R$ {{ number_format($carta->ValorCredito, 2, ',', '.') }}",
        "image": "{{ asset('/images/tipoproduto/' . $carta->TipoCarta->Imagem) }}",
        "description": "Consórcio para {{ $carta->TipoCarta->Descricao }}, com parcela flexível e vantagens incríveis.",
        "brand": {
        "@type": "Brand",
        "name": "Cartas Consórcios"
        },
        "offers": {
        "@type": "Offer",
        "priceCurrency": "BRL",
        "price": "{{ number_format($carta->ValorCredito, 2, '.', '') }}",
        "availability": "https://schema.org/InStock",
        "url": "{{ url('/detalhesCartaNova/' . $carta->IDCarta . '/' . $vendedor->idUsuario) }}"
        }
    }
    } @if (!$loop->last)
                ,
            @endif {{-- Adiciona vírgula apenas se não for o último elemento --}}
        @endforeach
        ]
    }
</script>
  @endscript
</div>
