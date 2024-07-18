@extends('master')
@section('title', 'Simulação')
@section('conteudo')

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic py-5">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center d-flex">
                            <img src="{{ asset('/images/logo.png') }}" height="100px">
                        </div>
                        <div>
                            <h4 class="mb-2">Dados</h4>
                            <p class="text-primary mb-4">Informe seus dados para prosseguir</p>
                            <div id="simulacao-dados-lead">
                                <div class="card-body">
                                    <form id="formSimulacaoDados">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="simulacao-nome">Nome:</label>
                                                <input type="text" class="form-control" name="Nome"
                                                    id="simulacao-nome" required placeholder="Nome">
                                            </div>
                                            <div class="d-flex flex-column form-group col-md-6">
                                                <label class="form-label" for="simulacao-celular">Celular:</label>
                                                <input type="text" class="form-control celular" name=""
                                                    id="simulacao-celular" required>
                                            </div>
                                            <input type="hidden" name="Origem" value="Lead fez a Simulação">
                                            <input type="hidden" name="TipoCadastro" value="Lead">
                                            @if ($cadastro->TipoCadastro == 'Vendedor')
                                                <input type="hidden" name="IDCadastroVendedor"
                                                    value="{{ $cadastro->IDCadastro }}">
                                            @else
                                                <input type="hidden" name="IDCadastroVendedor"
                                                    value="{{ $cadastro->IDCadastroVendedorIndicado }}">
                                            @endif
                                            <input type="hidden" name="IDCadastroIndicador"
                                                value="{{ $cadastro->IDCadastro }}">
                                            <button type="submit" class="btn btn-primary">Próximo</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="simulacao-dados" class="d-none vw-auto">
                                <h5 class="mb-3">Simulação</h5>
                                <form id="formSimulacao" method="POST">
                                    <div class="form-group col-sm-6">
                                        <label class="form-label" for="IDTipoCarta">Consórcio:</label>
                                        <select id="IDTipoCarta" name="IDTipoCarta" class="selectpicker form-control"
                                            data-style="py-0" required>
                                            <option value="" selected disabled>Selecione o Consórcio</option>
                                            @foreach ($tiposCarta as $tipo)
                                                <option value="{{ $tipo->IDTipoCarta }}">{{ $tipo->Descricao }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="simulacao2" class="d-none row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="Credito">Valor do Crédito:</label>
                                            <select id="Credito" name="Credito" class="form-control select2" multiple
                                                required>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="Prazo">Prazo:</label>
                                            <select id="Prazo" name="Prazo" class="selectpicker form-control"
                                                required>
                                                <option value="" selected disabled>Selecione o Prazo</option>
                                            </select>
                                        </div>
                                        <input type="hidden" id="IDCadastro" name="IDCadastro">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Gerar Simulação</button>
                                </form>
                            </div>
                            <div id="simulacao" class="mt-4 d-none">
                                <table id="tableSimulacao" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Crédito</th>
                                            <th>Parcela Integral</th>
                                            <th>Parcela Flex</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="justify-content-center d-flex">www.orbitadaterraconsorcio.com.br</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        const input = document.querySelector(".celular");
        const iti = window.intlTelInput(input, {
            initialCountry: "br",
            strictMode: true,
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.3.0/build/js/utils.js",
        });

        const hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "Telefone";
        input.parentNode.appendChild(hiddenInput);

        $('#formSimulacaoDados').submit(function(event) {
            event.preventDefault();
            let celular = iti.getNumber();
            if (celular.startsWith('+55') && celular.length < 14) {
                alert('Celular Incorreto!');
                return;
            }
            hiddenInput.value = celular;
            let formData = $(this).serialize();

            $.ajax({
                url: '/api/cadastros',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    $('#IDCadastro').val(response.IDCadastro);
                    $('#simulacao-dados-lead').hide();
                    $('#simulacao-dados').removeClass('d-none');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Erro na requisição AJAX:', textStatus, errorThrown);
                    alert('Erro na requisição AJAX.');
                }
            });
        });


        $('#IDTipoCarta').change(async function() {
            let tipoCartaId = $(this).val();

            try {
                var creditos = await $.ajax({
                    url: '/api/creditos/tipocarta/' + tipoCartaId,
                    type: 'GET',
                    contentType: 'json',
                });

                var prazos = await $.ajax({
                    url: '/api/prazos/tipocarta/' + tipoCartaId,
                    type: 'GET',
                    contentType: 'json',
                });

                $('#Credito').empty();
                $.each(creditos, function(index, obj) {
                    var valorFormatado = obj.toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                    $('#Credito').append('<option value="' + obj + '">' +
                        valorFormatado + '</option>');
                });
                $('.select2').select2({
                    placeholder: "Selecione os Créditos",
                    width: '100%',
                    closeOnSelect: false,
                    maximumSelectionLength: 7,
                    language: {
                        maximumSelected: function() {
                            return "O máximo de Créditos é 7";
                        },
                        noResults: function() {
                            return "Nenhum resultado encontrado";
                        }
                    }
                });


                $('#Prazo').empty();
                $('#Prazo').append('<option value="" selected disabled>Selecione o Prazo</option>');
                $.each(prazos, function(index, obj) {
                    $('#Prazo').append('<option value="' + obj + '">' + obj +
                        ' meses</option>');
                });

                $('#simulacao2').removeClass('d-none');
            } catch (error) {
                console.error(error);
                alert('Houve um erro com esse tipo de carta, por favor tente outro!');
            }
        });

        $('#formSimulacao').submit(function(event) {
            event.preventDefault();
            let form = new FormData();
            $('#simulacao').addClass('d-none');

            var creditos = [];

            $('#Credito').select2('data').forEach(element => {
                creditos.push(element.id);
            });

            form.append('IDTipoCarta', $('#IDTipoCarta').val());
            form.append('Prazo', $('#Prazo').val());
            form.append('IDCadastro', $('#IDCadastro').val());
            form.append('ValorCredito', JSON.stringify(creditos));

            $.ajax({
                url: '/api/cartas/simulacao',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data) {
                    preencherTabela(data);
                },
                error: function(xhr, status, error) {
                    alert('Houve um erro ao gerar a simulação!');
                }
            });
        });

        function preencherTabela(data) {
            $('#tableSimulacao tbody').empty();

            if (data.length === 0) {
                alert('Nenhuma carta encontrada, por favor, tente gerar com outras informações!')
                return;
            }

            data.forEach(function(item) {
                var valorCredito = item.ValorCredito.toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });

                var parcelaIntegral = parseFloat(item.ParcelaIntegral.replace('.', ',')).toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });

                if (item.ParcelaFlex == item.ParcelaIntegral) {
                    var parcelaFlex = "";
                } else {
                    var parcelaFlex = parseFloat(item.ParcelaFlex.replace('.', ',')).toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                }

                var row = $('<tr>').append(
                    $('<td>').text(valorCredito),
                    $('<td>').text(parcelaIntegral),
                    $('<td>').text(parcelaFlex),
                    $('<td>').append(
                        $('<button>')
                        .addClass('btn btn-info btn-quero-esse')
                        .data('carta-valor', item.ValorCredito)
                        .data('carta-integral', item.ParcelaIntegral)
                        .data('carta-flex', item.ParcelaFlex)
                        .data('carta-tipo', item.tipo_carta.Descricao)
                        .data('carta-prazo', item.Prazo)
                        .text('Quero esse!')
                        .click(function() {
                            var numeroVendedor = {{ $cadastro->Telefone }};
                            var mensagemPadrao =
                                "Olá, eu gostaria de reservar uma carta nova! Valor de crédito: " +
                                $(this).data('carta-valor') +
                                ", Parcela Flex: " + $(this).data('carta-flex') +
                                ", Parcela Integral: " + $(this).data('carta-integral') +
                                ", Carta de " + $(this).data('carta-tipo') +
                                ", Prazo: " + $(this).data('carta-prazo') +
                                " meses. Valor de crédito: " + $(this).data('carta-integral');

                            mensagemPadrao = encodeURIComponent(mensagemPadrao);

                            var linkWhatsApp = 'https://api.whatsapp.com/send?phone=' + numeroVendedor +
                                '&text=' + mensagemPadrao;

                            window.location.href = linkWhatsApp;
                        })
                    )
                );

                $('#tableSimulacao tbody').append(row);
            });
            $('#simulacao').removeClass('d-none');
        }
    </script>
@endsection
