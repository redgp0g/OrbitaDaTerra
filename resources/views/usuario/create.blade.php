@extends('master')
@section('title', 'Cadastrar-se')
@section('conteudo')
    @if ($mensagem = Session::get('erro'))
        @include('components.alert', ['mensagem' => $mensagem, 'style' => 'danger'])
    @endif
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic py-5">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center d-flex">
                            <img src="{{ asset('/images/logo.png') }}" height="100px">
                        </div>
                        <h4 class="mb-2">Faça parte de nosso time 🚀</h4>

                        <p class="text-primary mb-4">Cadastrar Conta</p>
                        <form id="formCadastrar" class="mb-3" action="{{ url('usuario/store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="Nome">Nome</label>
                                        <input type="text" class="form-control" id="Nome" name="Nome"
                                            placeholder="Nome" autofocus required />
                                    </div>
                                    <div class="mb-3 d-flex flex-column">
                                        <label class="form-label" for="Telefone">Celular</label>
                                        <input type="text" class="form-control celular" id="Telefone" name="Telefone" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="CPF">CPF</label>
                                        <input type="text" class="form-control cpf" id="CPF" name="CPF"
                                            placeholder="CPF" required oninput="mascaraCPF(this)" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="Email">E-mail</label>
                                        <input type="email" class="form-control" id="Email" name="Email"
                                            placeholder="Digite seu e-mail" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="DataNascimento">Data de Nascimento</label>
                                        <input type="date" class="form-control" id="DataNascimento" name="DataNascimento"
                                            required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="Senha">Senha</label>
                                        <input type="password" id="Senha" class="form-control" name="Senha"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="ConfirmacaoSenha">Confirmação da Senha</label>
                                        <input type="password" id="ConfirmacaoSenha" class="form-control"
                                            name="ConfirmacaoSenha" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="TipoCadastro">Perfil de Interesse</label>
                                        <select class="form-control" id="TipoCadastro" name="TipoCadastro" required>
                                            <option selected disabled value="">Selecione o Perfil</option>
                                            <option value="Vendedor">Vendedor</option>
                                            <option value="Indicador">Indicador</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="CEP">CEP</label>
                                        <input type="text" class="form-control cep" id="CEP" name="CEP"
                                            placeholder="CEP" maxlength="10" required oninput="mascaraCEP(this)" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="Endereco">Endereço</label>
                                        <input type="text" class="form-control" id="Endereco" name="Endereco"
                                            placeholder="Endereço" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="Bairro">Bairro</label>
                                        <input class="form-control" type="text" id="Bairro" name="Bairro"
                                            placeholder="Bairro" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="Cidade">Cidade</label>
                                        <input class="form-control" type="text" id="Cidade" name="Cidade"
                                            placeholder="Cidade" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="Estado">Estado</label>
                                        <input class="form-control" type="text" id="Estado" name="Estado"
                                            placeholder="Estado" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="NumeroCasa">Número</label>
                                        <input type="number" class="form-control" id="NumeroCasa" name="NumeroCasa"
                                            placeholder="N° da Casa" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="Complemente">Complemento</label>
                                        <input type="text" class="form-control" id="Complemento" name="Complemento"
                                            placeholder="Complemento" />
                                    </div>
                                    <div class="mb-3 d-none div-vendedorindicado">
                                        <label class="form-label">Vendedor que será indicado</label>
                                        <input type="text" name="idcadastroVendedorIndicado" class="form-control"
                                            disabled value="{{ $vendedorIndicado->Nome }}" />
                                    </div>
                                    <div class="mb-3 d-none div-curriculo">
                                        <label class="form-label">Currículo</label>
                                        <input type="file" class="form-control" id="Curriculo" name="Curriculo"
                                            accept="image/*, application/pdf" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 d-none">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="toggle" name="toggle"
                                        onclick="habilitar()" />
                                    <label class="form-check-label">
                                        Eu aceito os
                                        <a href="#">Termos de Privacidade</a>
                                    </label>
                                </div>
                            </div>
                            <input id="IDVendedorIndicado" type="hidden" name="IDVendedorIndicado" value="">
                            <button type="submit" id="btnCadastro"
                                class="btn btn-primary d-grid w-100">Cadastrar</button>
                        </form>
                    </div>
                    <p class="text-center">
                        <span>Já tem uma conta?</span>
                        <a href="{{ url('usuario') }}">
                            <span>Faça login aqui.</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const idVendedorIndicado = {{ $vendedorIndicado->IDCadastro }};
        const input = document.querySelector(".celular");
        const iti = window.intlTelInput(input, {
            initialCountry: "br",
            separateDialCode: true,
            strictMode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.3.0/build/js/utils.js",
        });

        const hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "Telefone";
        input.parentNode.appendChild(hiddenInput);

        $('#formCadastrar').submit(function(event) {
            let celular = iti.getNumber();
            if (celular.startsWith('+55') && celular.length < 14) {
                alert('Telefone Incorreto!');
                return;
            }
            hiddenInput.value = celular;
        });

        function verificarSenha() {
            var senha = $("#Senha").val();
            var confirmacaoSenha = $("#ConfirmacaoSenha").val();

            if (senha !== confirmacaoSenha) {
                alert('As senhas não coincidem!');
                $("#Senha").val("");
                $("#ConfirmacaoSenha").val("");
                $("#Senha").focus();
            }
        }

        $("#TipoCadastro").on("change", function() {
            var perfilSelecionado = $(this).val();

            if (perfilSelecionado === "Vendedor") {
                // $(".div-curriculo").removeClass("d-none");
                $(".div-vendedorindicado").addClass("d-none");
                $("#IDVendedorIndicado").val('');
            } else {
                // $(".div-curriculo").addClass("d-none");
                $(".div-vendedorindicado").removeClass("d-none");
                $("#IDVendedorIndicado").val(idVendedorIndicado);
            }
        });

        $("#ConfirmacaoSenha").on("focusout", function() {
            verificarSenha();
        });

        $("#CPF").on("focusout", function() {
            var cpf = $(this).val().replace(/[^0-9]/g, '');
            if (cpf.length === 11) {
                validarCPF(cpf);
            }
        });
    </script>
@endsection
