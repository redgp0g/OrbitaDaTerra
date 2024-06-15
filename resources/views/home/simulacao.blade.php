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
                                                <input type="text" class="form-control" id="simulacao-nome" required
                                                    placeholder="Nome">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="simulacao-celular">Celular:</label>
                                                <input type="text" class="form-control celular" id="simulacao-celular"
                                                    required placeholder="Celular">
                                            </div>
                                            <div class="form-group col-md-6 d-none">
                                                <label class="form-label" for="simulacao-email">Email:</label>
                                                <input type="email" class="form-control email" id="simulacao-email"
                                                    placeholder="Email">
                                            </div>
                                            <input type="hidden" name="numerovendedor" id="numerovendedor"
                                                value="<{{ $cadastro->Telefone }}">
                                            <button type="submit" class="btn btn-primary">Próximo</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="simulacao-dados" class="d-none vw-auto">
                                <h5 class="mb-3">Simulação</h5>
                                <form id="formSimulacao" class="">
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Consórcio:</label>
                                        <select id="tipoSelect" name="type" class="selectpicker form-control"
                                            data-style="py-0" required>
                                            <option value="" selected disabled>Selecione o Consórcio</option>
                                            @foreach ($tiposCarta as $tipo)
                                                <option value="{{ $tipo->IDTipoCarta }}">{{ $tipo->Descricao }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="simulacao2" class="d-none row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="pass">Valor do Crédito:</label>
                                            <select id="creditoSelect" class="form-control select2" multiple required>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="prazo">Prazo:</label>
                                            <select id="prazoSelect" class="selectpicker form-control" required>
                                                <option value="" selected disabled>Selecione o Prazo</option>
                                            </select>
                                        </div>
                                        <input type="hidden" id="idNovoLead">
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
    </div>

    <script>
        $('#formSimulacaoDados').on('submit', function() {
            event.preventDefault();
            let form = new FormData();

            form.append('nome', $('#simulacao-nome').val());
            form.append('celular', $('#simulacao-celular').val());
            form.append('email', $('#simulacao-email').val());
            form.append('numeroVendedor', $('#numerovendedor').val());

            $.ajax({
                url: '/public/index.php/enviardadosSimulacao',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#idNovoLead').val(response);
                    $('#simulacao-dados-lead').hide();
                    $('#simulacao-dados').removeClass('d-none');
                },
                error: function(xhr, status, error) {
                    alert('Houve um erro ao enviar os dados!');
                }
            });
        });

        $('#formSimulacao').on('submit', async function() {
            event.preventDefault();
            let form = new FormData();
            $('#simulacao').addClass('d-none');

            form.append('valorCredito', $('#creditoSelect').val());
            form.append('tipoCarta', $('#tipoSelect').val());
            form.append('prazo', $('#prazoSelect').val());
            form.append('idLead', $('#idNovoLead').val());

            var solicitacao = await $.ajax({
                url: '/public/index.php/gerarSimulacao',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                error: function(xhr, status, error) {
                    alert('Houve um erro ao gerar a simulação!');
                }
            });

            preencherTabela(solicitacao);
            $('#simulacao').removeClass('d-none');
        });

        $('#tipoSelect').change(async function() {
            let tipoCartaId = $(this).val();
            let form = new FormData();
            form.append('tipo_carta_id', tipoCartaId);

            try {
                var creditos = await $.ajax({
                    url: '/public/index.php/buscarCreditosPorTipoCarta',
                    type: 'POST',
                    data: form,
                    processData: false,
                    contentType: false
                });

                var prazos = await $.ajax({
                    url: '/public/index.php/buscarPrazosPorTipoCarta',
                    type: 'POST',
                    data: form,
                    processData: false,
                    contentType: false
                });

                $('#creditoSelect').empty();
                $.each(creditos, function(index, obj) {
                    var valorFormatado = obj.ValorCredito.toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                    $('#creditoSelect').append('<option value="' + obj.ValorCredito + '">' +
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


                $('#prazoSelect').empty();
                $('#prazoSelect').append('<option value="" selected disabled>Selecione o Prazo</option>');
                $.each(prazos, function(index, obj) {
                    $('#prazoSelect').append('<option value="' + obj.Prazo + '">' + obj.Prazo +
                        ' meses</option>');
                });

                $('#simulacao2').removeClass('d-none');
            } catch (error) {
                console.error(error);
                alert('Houve um erro com esse tipo de carta, por favor tente outro!');
            }
        });

        function preencherTabela(data) {
            $('#tableSimulacao tbody').empty();

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

                var row = '<tr>' +
                    '<td>' + valorCredito + '</td>' +
                    '<td>' + parcelaIntegral + '</td>' +
                    '<td>' + parcelaFlex + '</td>' +
                    '<td><button class="btn btn-info btn-quero-esse">Quero esse!</button></td>' +
                    '</tr>';

                var novaRow = $(row);

                novaRow.find('.btn-quero-esse').click(function() {
                    console.log('Botão "Quero esse!" clicado para o item:', item);
                });

                $('#tableSimulacao tbody').append(row);
            });
        }
    </script>
@endsection
