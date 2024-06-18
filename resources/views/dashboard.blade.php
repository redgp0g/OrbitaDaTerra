@extends('master')
@section('conteudo')
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body">
            </div>
        </div>
    </div>

    @include('partials.asideDashboard')

    <main class="main-content">
        <div class="position-relative iq-banner">
            @include('partials.navbarDashboard')
            <div class="iq-navbar-header" style="height: 115px;">
                <div class="container-fluid iq-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="flex-wrap d-flex justify-content-between align-items-center">
                                <a class="py-0 d-flex align-items-center" style="margin-bottom: 16px;"
                                    href="{{ url('/' . auth()->user()->IDCadastro) }}" role="button">
                                    <div class="caption ms-3">
                                        <h6 class="mb-0 caption-title">Minha Página</h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iq-header-img">
                    <img src="{{ asset('/images/dashboard/top-header.png') }}" alt="header"
                        class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
                </div>
            </div>
        </div>
        <div class="conatiner-fluid content-inner mt-n5 py-3">
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
@endsection
