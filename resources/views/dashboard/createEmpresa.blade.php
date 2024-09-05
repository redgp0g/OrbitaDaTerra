@extends('dashboard')
@section('title', 'Cadastrar Empresa')
@section('pagina')
    <div class="col-16">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ url('/dashboard/storeEmpresa') }}">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="CNPJ" class="form-label">CNPJ</label>
                            <input class="form-control" type="text" id="CNPJ" maxlength="18" name="CNPJ"
                                placeholder="CNPJ" oninput="mascaraCNPJ(this)" required />
                        </div>
                        <div class="mb-3 col-md-5">
                            <label for="RazaoSocial" class="form-label ">Razão Social</label>
                            <input class="form-control uppercase" type="text" id="RazaoSocial" name="RazaoSocial"
                                placeholder="Razão Social" required />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="NomeFantasia" class="form-label">Nome Fantasia</label>
                            <input class="form-control uppercase" type="text" id="NomeFantasia" name="NomeFantasia"
                                placeholder="Nome Fantasia" required />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label" for="Telefone">Telefone Empresa</label>
                            <input class="form-control telefone" type="text" id="Telefone" name="Telefone"
                                placeholder="Telefone da Empresa" required />

                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="NomeRepresentante" class="form-label">Nome do Representante </label>
                            <input class="form-control uppercase" type="text" id="NomeRepresentante"
                                name="NomeRepresentante" placeholder="Nome do Representante" required />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label" for="CelularRepresentante">Celular do Representante</label>
                            <input class="form-control celular" type="text" id="CelularRepresentante"
                                name="CelularRepresentante" placeholder="Celular do Representante" required />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="EmailRepresentante" class="form-label">E-mail</label>
                            <input class="form-control" type="email" id="EmailRepresentante" name="EmailRepresentante"
                                placeholder="E-mail" required />
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="CEP" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="CEP" name="CEP"
                                oninput="mascaraCEP(this)" maxlength="9" placeholder="CEP" class="form-control" required />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="Endereco" class="form-label">Endereço</label>
                            <input type="text" class="form-control uppercase" id="Endereco" name="Endereco"
                                placeholder="Endereço" required />
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="Numero" class="form-label">Número</label>
                            <input type="number" class="form-control" id="Numero" name="Numero" placeholder="Número"
                                required />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="Complemento" class="form-label">Complemento</label>
                            <input type="text" class="form-control uppercase" id="Complemento" name="Complemento"
                                placeholder="Complemento" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="Bairro" class="form-label">Bairro</label>
                            <input class="form-control uppercase" type="text" id="Bairro" name="Bairro"
                                placeholder="Bairro" required />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="Cidade" class="form-label">Cidade</label>
                            <input class="form-control uppercase" type="text" id="Cidade" name="Cidade"
                                placeholder="Cidade" required />
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="Estado" class="form-label">Estado</label>
                            <input class="form-control uppercase" type="text" id="Estado" name="Estado"
                                placeholder="Estado" required />
                        </div>
                        <div class="mb-3 col-md-3 d-flex align-items-center78">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="TipoEmpresa" id="tipoEmpresa1"
                                    value="Autorizada">
                                <label class="form-check-label" for="tipoEmpresa1">Autorizada</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="TipoEmpresa" id="tipoEmpresa2"
                                    value="Administradora">
                                <label class="form-check-label" for="tipoEmpresa2">Administradora</label>
                            </div>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="Observacoes" class="form-label">Observações</label>
                            <textarea class="form-control" name="Observacoes" id="Observacoes" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="mb-3 col-md-4">
                        <button type="submit" class="btn btn-success me-2">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
