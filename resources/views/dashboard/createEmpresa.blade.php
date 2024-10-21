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
              <label class="form-label" for="CNPJ">CNPJ</label>
              <input class="form-control" id="CNPJ" name="CNPJ" type="text" maxlength="18" placeholder="CNPJ" oninput="mascaraCNPJ(this)" required />
            </div>
            <div class="mb-3 col-md-5">
              <label class="form-label " for="RazaoSocial">Razão Social</label>
              <input class="form-control uppercase" id="RazaoSocial" name="RazaoSocial" type="text" placeholder="Razão Social" required />
            </div>
            <div class="mb-3 col-md-4">
              <label class="form-label" for="NomeFantasia">Nome Fantasia</label>
              <input class="form-control uppercase" id="NomeFantasia" name="NomeFantasia" type="text" placeholder="Nome Fantasia" required />
            </div>
            <div class="mb-3 col-md-3">
              <label class="form-label" for="Telefone">Telefone Empresa</label>
              <input class="form-control telefone" id="Telefone" name="Telefone" type="text" placeholder="Telefone da Empresa" required />

            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label" for="NomeRepresentante">Nome do Representante </label>
              <input class="form-control uppercase" id="NomeRepresentante" name="NomeRepresentante" type="text" placeholder="Nome do Representante" required />
            </div>
            <div class="mb-3 col-md-3">
              <label class="form-label" for="CelularRepresentante">Celular do Representante</label>
              <input class="form-control celular" id="CelularRepresentante" name="CelularRepresentante" type="text" placeholder="Celular do Representante" required />
            </div>
            <div class="mb-3 col-md-4">
              <label class="form-label" for="EmailRepresentante">E-mail</label>
              <input class="form-control" id="EmailRepresentante" name="EmailRepresentante" type="email" placeholder="E-mail" required />
            </div>
            <div class="mb-3 col-md-2">
              <label class="form-label" for="CEP">CEP</label>
              <input class="form-control" class="form-control" id="CEP" name="CEP" type="text" oninput="mascaraCEP(this)" maxlength="9" placeholder="CEP"
                required />
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label" for="Endereco">Endereço</label>
              <input class="form-control uppercase" id="Endereco" name="Endereco" type="text" placeholder="Endereço" required />
            </div>
            <div class="mb-3 col-md-2">
              <label class="form-label" for="Numero">Número</label>
              <input class="form-control" id="Numero" name="Numero" type="number" placeholder="Número" required />
            </div>
            <div class="mb-3 col-md-4">
              <label class="form-label" for="Complemento">Complemento</label>
              <input class="form-control uppercase" id="Complemento" name="Complemento" type="text" placeholder="Complemento" />
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label" for="Bairro">Bairro</label>
              <input class="form-control uppercase" id="Bairro" name="Bairro" type="text" placeholder="Bairro" required />
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label" for="Cidade">Cidade</label>
              <input class="form-control uppercase" id="Cidade" name="Cidade" type="text" placeholder="Cidade" required />
            </div>
            <div class="mb-3 col-md-2">
              <label class="form-label" for="Estado">Estado</label>
              <input class="form-control uppercase" id="Estado" name="Estado" type="text" placeholder="Estado" required />
            </div>
            <div class="mb-3 col-md-3 d-flex align-items-center78">
              <div class="form-check form-check-inline">
                <input class="form-check-input" id="tipoEmpresa1" name="TipoEmpresa" type="radio" value="Autorizada">
                <label class="form-check-label" for="tipoEmpresa1">Autorizada</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" id="tipoEmpresa2" name="TipoEmpresa" type="radio" value="Administradora">
                <label class="form-check-label" for="tipoEmpresa2">Administradora</label>
              </div>
            </div>
            <div class="mb-3 col-md-12">
              <label class="form-label" for="Observacoes">Observações</label>
              <textarea class="form-control" id="Observacoes" name="Observacoes" rows="4"></textarea>
            </div>
          </div>
          <div class="mb-3 col-md-4">
            <button class="btn btn-success me-2" type="submit">Cadastrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
