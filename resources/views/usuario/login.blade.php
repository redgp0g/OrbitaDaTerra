@extends('master')
@section('title', 'Login')
@section('conteudo')
    <div class="wrapper">
        <section class="login-content">
            <div class="row m-0 align-items-center bg-white">
                <div class="col-md-6">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                                <div class="card-body">
                                    <div class="row">
                                        <a href="#" class="navbar-brand d-flex align-items-center mb-3">
                                            <img src="{{ asset('/images/logo.png') }}" height="80px">
                                        </a>
                                        <h2 class="mb-2 text-center">LOGIN</h2>
                                    </div>
                                    <form class="form-group" method="POST" action="{{ route('usuario.auth') }}">
                                        @csrf
                                        <div class="mb-5">
                                            <label for="login" class="form-label">Email</label>
                                            <input type="text" class="form-control" id="login" name="Login"
                                                placeholder="Entre com seu email" autofocus />
                                        </div>
                                        <div class="mb-3 form-password-toggle">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label" for="senha">Senha</label>
                                            </div>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="senha" class="form-control" name="Senha"
                                                    placeholder="Senha" aria-describedby="password" />
                                            </div>
                                            <div class="d-flex flex-row-reverse m-2">
                                                <a href="{{ route('usuario.formRecoverPassword') }}">Esqueceu a Senha?</a>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <button class="btn btn-primary d-grid w-100" type="submit">ENTRAR</button>
                                        </div>
                                    </form>
                                    <div id="msgLogin">
                                        <p class="text-center">
                                            <strong>Novo na plataforma?</strong>

                                            <a href="{{ asset('/usuario/create') }}">
                                                <span>Cadastre aqui.</span>
                                            </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-md-block d-none bg-primary p-0 overflow-hidden" style="height: 95vh;">
                    <img src="{{ asset('/images/auth/01.png') }}" class="img-fluid gradient-main animated-scaleX"
                        alt="images">
                </div>
            </div>
        </section>
    </div>
@endsection
