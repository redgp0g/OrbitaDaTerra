<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta name="description"
          content="Descubra as melhores opções de cartas de consórcio no mercado. Compare e adquira a carta ideal para realizar seus sonhos de forma planejada e segura.">
    <meta name="keywords"
          content="cartas de consórcio, consórcio, consórcio imobiliário, consórcio de veículos, carta de crédito, comprar consórcio, melhores cartas de consórcio">

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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('node_modules/intl-tel-input/build/css/intlTelInput.css') }}" rel="stylesheet">
    <link href="{{ asset('node_modules/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <script src="{{ asset('node_modules/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/build/' . $manifest['js/app.js']['file']) }}"></script>
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
    @yield('conteudo')
</div>
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5BMDJS2N" style="display:none;visibility:hidden"
            height="0"
            width="0"></iframe>
</noscript>

@include('partials.footer')
</body>

</html>
