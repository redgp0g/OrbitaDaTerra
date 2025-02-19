<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5BMDJS2N');
    </script>
    <!-- End Google Tag Manager -->

    <meta name="description"
          content="Descubra as melhores opções de cartas de consórcio no mercado. Compare e adquira a carta ideal para realizar seus sonhos de forma planejada e segura.">
    <meta name="keywords"
          content="cartas de consórcio, consórcio, consórcio imobiliário, consórcio de veículos, carta de crédito, comprar consórcio, melhores cartas de consórcio">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11312268635"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'AW-11312268635');
    </script>
    <!-- End Google Tag -->

    <meta name="google-site-verification" content="0m0e911CLxGxr2hkn_OUwanL9jtNYJdZKY-T3bmF89I"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="{{ asset('favicon.ico') }}" rel="shortcut icon"/>

    @php
        $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
    @endphp

    <link type="text/css" href="{{ asset('public/build/' . $manifest['css/app.css']['file']) }}" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css"
          rel="stylesheet"/>
    <link type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" rel="stylesheet"/>
    <link href="{{asset('node_modules/intl-tel-input/build/css/intlTelInput.css')}}" rel="stylesheet">

    @include('partials.dashboardLinks')
    @include('partials.dashboardScripts')
</head>

<body>
<div style="min-height: 95vh;">
    @if ($mensagem = Session::get('erro'))
        @include('components.alert', ['mensagem' => $mensagem, 'style' => 'danger'])
    @endif
    @if ($mensagem = Session::get('sucesso'))
        @include('components.alert', ['mensagem' => $mensagem, 'style' => 'success'])
    @endif
    @if ($mensagem = Session::get('alerta'))
        @include('components.alert', ['mensagem' => $mensagem, 'style' => 'warning'])
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            @include('components.alert', ['mensagem' => $error, 'style' => 'danger'])
        @endforeach
    @endif
        @if (auth()->user()->IDCadastro == 31 || auth()->user()->IDCadastro == 38)
            @include('partials.asideDashboard')
        @endif
        <main class="main-content">
            <div class="position-relative iq-banner">
                @include('partials.navbarDashboard')
                <div class="iq-navbar-header" style="height: 115px;">
                    <div class="iq-header-img">
                        <img src="{{ asset('/images/dashboard/top-header.png') }}" alt="header"
                             class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
                    </div>
                </div>
            </div>
            <div class="container-fluid content-inner mt-n5 py-3">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="row row-cols-1">
                            <div class="overflow-hidden d-slider1 ">
                                <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                        <div class="card-body">
                                            <div class="progress-widget">
                                                <div class="progress-detail">
                                                    <p class="mb-2">Total LEADs</p>
                                                    <h4>{{ count($leads ?? []) }}</h4>
                                                </div>
                                                <div class="progress-detail">
                                                    <p class="mb-2">Total LEADs Indicados</p>
                                                    <h4>{{ count($leadsIndicados ?? []) }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                            </div>
                        </div>
                    </div>
                    @yield('pagina')
                </div>
            </div>
        </main>
</div>
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5BMDJS2N" style="display:none;visibility:hidden"
            height="0"
            width="0"></iframe>
</noscript>

@include('partials.footer')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{ asset('public/build/' . $manifest['js/app.js']['file']) }}"></script>
</body>

</html>

