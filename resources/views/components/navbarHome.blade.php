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
                @foreach ($items as $item)
                    @if ($item['auth'] === 'guest' && auth()->guest())
                        <li class="nav-item mx-3">
                            <a href="{{ $item['url'] }}" class="nav-link text-primary">{{ $item['label'] }}</a>
                        </li>
                    @elseif ($item['auth'] === 'auth' && auth()->check())
                        <li class="nav-item mx-3">
                            <a href="{{ $item['url'] }}" class="nav-link text-primary">{{ $item['label'] }}</a>
                        </li>
                    @elseif ($item['auth'] === 'all')
                        <li class="nav-item mx-3">
                            <a href="{{ $item['url'] }}" class="nav-link text-primary">{{ $item['label'] }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>
