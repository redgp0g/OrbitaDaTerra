<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
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

    <meta name="google-site-verification" content="0m0e911CLxGxr2hkn_OUwanL9jtNYJdZKY-T3bmF89I" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.3.0/build/css/intlTelInput.css">

    @include('partials.dashboardLinks')
    @include('partials.dashboardScripts')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.3.0/build/js/intlTelInput.min.js"></script>
    @livewireScripts
</head>

<body>
    <div style="min-height: 95vh;">
        @yield('conteudo')
    </div>
</body>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5BMDJS2N" height="0" width="0"
        style="display:none;visibility:hidden"></iframe></noscript>

<footer class="d-flex footer border-top border-primary border-1 z-3 justify-content-center align-items-center"
    style="height: 5vh;">
    <span>
        ©
        <script>
            document.write(new Date().getFullYear());
        </script>
        Orbita da Terra |
        por <a href="https://portfolio-gordiano.netlify.app/" target="_blank">Guilherme Gordiano</a>.
    </span>
</footer>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
