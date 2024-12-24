<nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
  <div class="container-fluid navbar-inner">
    <div class="logo-main">
      <img src="{{ asset('images/logo mini.png') }}" height="40px">
    </div>
    <h4 class="logo-title">ÓRBITA</h4>
    <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
      <i class="icon">
        <svg class="icon-20" width="20px" viewBox="0 0 24 24">
          <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
        </svg>
      </i>
    </div>

    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">
        <span class="mt-2 navbar-toggler-bar bar1"></span>
        <span class="navbar-toggler-bar bar2"></span>
        <span class="navbar-toggler-bar bar3"></span>
      </span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
        <li class="nav-item dropdown">
          <a class="py-0 nav-link d-flex align-items-center" id="navbarDropdown" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
            <div class="caption ms-3">
              <h6 class="mb-0 caption-title">{{ auth()->user()->cadastro->Nome }}</h6>
              <p class="mb-0 caption-sub-title d-none">Usuário</p>
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item" href="{{ url('/dashboard/perfil') }}">Perfil</a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ url('/' . auth()->user()->IDCadastro) }}">Minha Página</a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ url('/usuario/create/' . auth()->user()->IDCadastro) }}">Link para Indicador</a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ url('/logout') }}">Sair</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
