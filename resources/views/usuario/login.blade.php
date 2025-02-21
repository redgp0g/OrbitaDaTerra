@extends('master')
@section('title', 'Login')
@section('conteudo')
    <div class="wrapper">
        <section class="login-content">
            <div class="row align-items-center m-0 bg-white">
                <div class="col-md-6">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card card-transparent d-flex justify-content-center auth-card mb-0 shadow-none">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="navbar-brand d-flex align-items-center mb-3">
                                            <img src="{{ asset('/images/logo.png') }}" height="80px">
                                        </div>
                                        <h2 class="mb-2 text-center">LOGIN</h2>
                                    </div>
                                    <form class="form-group" method="POST" action="{{ route('usuario.auth') }}">
                                        @csrf
                                        <div class="mb-5">
                                            <label class="form-label" for="login">Email</label>
                                            <input class="form-control" id="login" name="Login" type="text"
                                                placeholder="Entre com seu email" autofocus />
                                        </div>
                                        <div class="form-password-toggle mb-3">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label" for="senha">Senha</label>
                                            </div>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control" id="senha" name="Senha" type="password"
                                                    aria-describedby="password" placeholder="Senha" />
                                            </div>
                                            <div class="d-flex m-2 flex-row-reverse">
                                                <a href="{{ route('usuario.recoverPassword') }}">Esqueceu a Senha?</a>
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
                <div class="col-md-6 d-md-block d-none bg-primary overflow-hidden p-0" style="height: 95vh;">
                    <img class="img-fluid gradient-main animated-scaleX" src="{{ asset('/images/auth/01.png') }}"
                        alt="images">
                </div>
            </div>
        </section>
    </div>
@endsection
