@extends('dashboard')
@section('pagina')
@section('title', 'Perfil')

<div class="col-16">
    <div id="profile-profile">
        <div class="card">
            <div class="card-header">
                <div class="header-title">
                    <h4 class="card-title">Perfil</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div>
                        <h3 class="d-inline-block">{{ auth()->user()->cadastro->Nome }}</h3>
                        <p class="d-inline-block pl-3"> - {{ auth()->user()->cadastro->TipoCadastro }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-title">
                    <h4 class="card-title">Dados da Conta</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mt-2">
                            <h6 class="mb-1">Cadastrado:</h6>
                            <p>{{ auth()->user()->cadastro->DataCadastro }}</p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Contato:</h6>
                            <p class="celular">{{ auth()->user()->cadastro->Telefone }}</p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Email:</h6>
                            <p>{{ auth()->user()->cadastro->Email }}</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mt-2">
                            <h6 class="mb-1">CPF:</h6>
                            <p>{{ auth()->user()->cadastro->CPF }}</p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">CEP:</h6>
                            <p class="celular">{{ auth()->user()->cadastro->CEP }}</p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Data Nascimento:</h6>
                            <p>{{ auth()->user()->cadastro->DataNascimento }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
