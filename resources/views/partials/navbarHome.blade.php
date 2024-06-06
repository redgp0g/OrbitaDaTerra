<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom border-primary border-3">
    <div class="container-fluid">
        <a class="navbar-brand mx-5 mb-2" href="#">
            <img src="{{ asset('images/logo.png') }}" height="60px">
        </a>

        <div class="w-100 d-flex justify-content-center align-items-center d-lg-none">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 fs-6">
                @if ($title == 'Cartas Contempladas')
                    <li class="nav-item mx-3">
                        <a href="{{ url('/' . $cadastro->IDCadastro) }}" class="nav-link text-primary">Cartas Novas</a>
                    </li>
                @else
                    <li class="nav-item mx-3">
                        <a href="{{ url('contempladas/' . $cadastro->IDCadastro) }}"
                            class="nav-link text-primary">Cartas Contempladas</a>
                    </li>
                @endif
                @auth
                    <li class="nav-item mx-3">
                        <a href="/public/index.php/dashboard" class="nav-link text-primary">Dashboard</a>
                    </li>
                @endauth
                @guest
                    <li class="nav-item mx-3">
                        <a href="/usuario" class="nav-link text-primary">Acessar Conta</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a href="{{ url('/usuario' . $cadastro->IDCadastro) }}"
                            class="nav-link text-primary">Cadastrar-se</a>
                    </li>

                @endguest
                <li class="nav-item mx-3">
                    <a class="nav-link text-primary" href="/public/index.php/simulacao/id/<?php echo $cadastro->IDCadastro; ?>">Fazer
                        Simulação</a>
                </li>
            </ul>

        </div>
    </div>
</nav>
