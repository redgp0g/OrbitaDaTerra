@extends('master')
@section('title', 'Login')
@section('conteudo')
<div class="container-xxl d-flex justify-content-center align-items-center" style="height: 95vh">
      <div class="authentication-wrapper authentication-basic container-p-y">
          <div class="authentication-inner py-4">
              <div class="card">
                  <div class="card-body">
                      <div class="app-brand justify-content-center d-flex">
                          <img src="{{ asset('/images/logo.png') }}" height="110px">
                      </div>

                      <h4 class="mb-2">Esqueceu a Senha? 🔒</h4>
                      <p class="mb-4">Entre com seu email de cadastro para que possamos enviar instruções de
                          recuperação da senha!</p>

                      <form class="mb-3" action="{{ url('/recoverPassword') }}" method="post">
                        @csrf
                          <div class="mb-3">
                              <label for="email" class="form-label">Email</label>
                              <input type="email" class="form-control" id="email" name="email"
                                  placeholder="Digite seu e-mail" autofocus required>
                          </div>
                          <button type="submit" class="btn btn-primary d-grid w-100">Solicitar Recuperação</button>
                      </form>

                      <div class="text-center">
                          <a href="{{ url('usuario') }}" class="d-flex align-items-center justify-content-center">
                              Voltar para login
                          </a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection