<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom border-primary border-3">
    <div class="container-fluid">
        <div class="d-flex w-lg-100 pe-4">
            <a class="navbar-brand mx-5 mb-2" href="#">
                <img src="{{ asset('images/logo.png') }}" height="60px">
            </a>
            <div class="w-100 d-flex justify-content-end align-items-center d-lg-none">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 fs-6">
                <li class="nav-item mx-3">
                    <a href="{{ url('/' . $cadastroId) }}" class="nav-link {{ request()->is($cadastroId) ? 'text-warning' : 'text-primary' }}">Cartas Novas</a>
                </li>
                <li class="nav-item mx-3">
                    <a href="{{ url('/cartasAVenda/' . $cadastroId) }}" class="nav-link {{ request()->is('cartasAVenda*') ? 'text-warning' : 'text-primary' }}">Cartas À Venda</a>
                </li>
                @if(auth()->check())
                    <li class="nav-item mx-3">
                        <a href="{{ url('/dashboard') }}" class="nav-link text-primary">Dashboard</a>
                    </li>
                @endif
                @if(auth()->guest())
                    <li class="nav-item mx-3">
                        <a href="{{ url('/usuario') }}" class="nav-link text-primary">Acessar Conta</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a href="{{ url('/usuario/create/' . $cadastroId) }}" class="nav-link text-primary">Cadastrar-Se</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
