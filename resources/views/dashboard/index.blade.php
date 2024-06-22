@extends('dashboard')
@section('title', 'Dashboard')
@section('pagina')
    @php
        $primeiroNomeUsuario = explode(' ', auth()->user()->Nome)[0];
    @endphp
    <div class="col-md-12 col-lg-8">
        <div class="row">
            <div class="col-md-12">
                <div class="card" data-aos="fade-up" data-aos-delay="800">
                    <div class="mb-4 flex-wrap card-header d-flex justify-content-between align-items-center">
                        <div class="header-title d-flex">
                            <h4 class="card-title me-4">Cadastrar Novo Lead</h4>
                            <svg id="abrirFormNovoLead" class="icon-32 cursor-pointer" onclick="abrirFecharFormNovoLead()"
                                style="cursor: pointer" width="32" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.4"
                                    d="M2 7.916V16.084C2 19.623 4.276 22 7.665 22H16.335C19.724 22 22 19.623 22 16.084V7.916C22 4.378 19.723 2 16.334 2H7.665C4.276 2 2 4.378 2 7.916Z"
                                    fill="currentColor"></path>
                                <path
                                    d="M7.72033 12.8555L11.4683 16.6205C11.7503 16.9035 12.2493 16.9035 12.5323 16.6205L16.2803 12.8555C16.5723 12.5615 16.5713 12.0865 16.2773 11.7945C15.9833 11.5025 15.5093 11.5025 15.2163 11.7965L12.7493 14.2735V7.91846C12.7493 7.50346 12.4133 7.16846 11.9993 7.16846C11.5853 7.16846 11.2493 7.50346 11.2493 7.91846V14.2735L8.78333 11.7965C8.63633 11.6495 8.44433 11.5765 8.25133 11.5765C8.06033 11.5765 7.86833 11.6495 7.72233 11.7945C7.42933 12.0865 7.42833 12.5615 7.72033 12.8555Z"
                                    fill="currentColor"></path>
                            </svg>
                            <svg id="fecharFormNovoLead" class="icon-32 d-none" style="cursor: pointer"
                                onclick="abrirFecharFormNovoLead()" width="32" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.4"
                                    d="M22 16.084V7.916C22 4.377 19.724 2 16.335 2H7.665C4.276 2 2 4.377 2 7.916V16.084C2 19.622 4.277 22 7.666 22H16.335C19.724 22 22 19.622 22 16.084Z"
                                    fill="currentColor"></path>
                                <path
                                    d="M16.2792 11.1445L12.5312 7.37954C12.2492 7.09654 11.7502 7.09654 11.4672 7.37954L7.71918 11.1445C7.42718 11.4385 7.42818 11.9135 7.72218 12.2055C8.01618 12.4975 8.49018 12.4975 8.78318 12.2035L11.2502 9.72654V16.0815C11.2502 16.4965 11.5862 16.8315 12.0002 16.8315C12.4142 16.8315 12.7502 16.4965 12.7502 16.0815V9.72654L15.2162 12.2035C15.3632 12.3505 15.5552 12.4235 15.7482 12.4235C15.9392 12.4235 16.1312 12.3505 16.2772 12.2055C16.5702 11.9135 16.5712 11.4385 16.2792 11.1445Z"
                                    fill="currentColor"></path>
                            </svg>

                        </div>
                        <div id="formNovoLead" class="d-none align-items-center align-self-center">
                            <div class="card-body">
                                <div class="new-user-info">
                                    <form method="post" id="formCadastrarLead" action="{{ url('/api/cadastros') }}">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label class="form-label" for="Nome">Nome Completo:</label>
                                                <input type="text" class="form-control" name="Nome"
                                                    placeholder="Nome do lead" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="Telefone">Número de
                                                    Telefone:</label>
                                                <input type="text" class="form-control celular" name="Telefone"
                                                    id="Telefone" placeholder="Número de telefone" required
                                                    pattern="\(\d{2}\) \d{5}-\d{4}">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="form-label" for="Observacoes">Observações (Não
                                                    Obrigatório):</label>
                                                <input class="form-control" id="Observacoes" name="Observacoes"
                                                    placeholder="Observações">
                                            </div>
                                        </div>
                                        @if (auth()->user()->TipoCadastro == 'Vendedor')
                                            <input type="hidden" name="IDCadastroVendedor"
                                                value="{{ auth()->user()->IDCadastro }}">
                                        @else
                                            <input type="hidden" name="IDCadastroVendedor"
                                                value="{{ auth()->user()->IDCadastroVendedorIndicado }}">
                                        @endif
                                        <input type="hidden" name="IDCadastroIndicador"
                                            value="{{ auth()->user()->IDCadastro }}">
                                        <input type="hidden" name="TipoCadastro" value="Lead">
                                        <input type="hidden" name="Origem" value="Cadastrado no Dashboard">
                                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-16">
        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex col">
                    <div class="my-3 d-sm-flex">
                        <label class="me-1">Indicador:</label>
                        <select id="filtroIndicador" class="form-select form-select-sm w-auto"></select>
                    </div>
                    <div class="ms-lg-2 my-3 d-sm-flex">
                        <label class="me-1">Atividade:</label>
                        <select id="filtroAtividade" class="form-select form-select-sm w-auto"></select>
                    </div>
                </div>
                <table id="table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Origem</th>
                            <th>Atividade do Vendedor</th>
                            <th>Previsão Atividade</th>
                            <?php if (auth()->user()->TipoCadastro = 'Vendedor') {
                                echo '<th>Indicador</th>';
                            }
                            ?>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($leads as $lead) {
                            $telefone = preg_replace('/\D/', '', $lead->Telefone);
                            $primeiroNomeLead = explode(' ', $lead->Nome)[0];
                            $primeiroNomeIndicador = explode(' ', $lead->NomeIndicador)[0];
                            echo '<tr>';
                            echo '<td>' . $lead->Nome . '</td>';
                            echo '<td>' . $telefone . '</td>';
                            echo '<td>' . $lead->Origem . '</td>';
                            echo '<td>' . $lead->AtividadeVendedor . '</td>';
                            echo '<td>' . $lead->PrevisaoAtividadeVendedor . '</td>';
                            echo '<td>' . $lead->NomeIndicador . '</td>';
                            echo '<td>
                                                                                                                                                                                                                            <button class="btn-enviar-mensagem border-0 bg-transparent" data-nomelead="' .
                                $primeiroNomeLead .
                                '" data-telefonelead="' .
                                $telefone .
                                '" data-nomeindicador="' .
                                $primeiroNomeIndicador .
                                '">
                                                                                                                                                                                                                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="48" height="48" viewBox="0 0 48 48">
                                                                                                                                                                                                                                    <path fill="#fff" d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z"></path>
                                                                                                                                                                                                                                    <path fill="#fff" d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z"></path>
                                                                                                                                                                                                                                    <path fill="#cfd8dc" d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z"></path>
                                                                                                                                                                                                                                    <path fill="#40c351" d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z"></path>
                                                                                                                                                                                                                                    <path fill="#fff" fill-rule="evenodd" d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z" clip-rule="evenodd"></path>
                                                                                                                                                                                                                                </svg>
                                                                                                                                                                                                                            </button>
                                                                                                                                                                                                                            <button class="editar-lead btn btn-warning" data-id="' .
                                $lead->IDCadastro .
                                '">Editar</button>
                                                                                                                                                                                                                            <button class="btn btn-danger delete-lead" data-id="' .
                                $lead->IDCadastro .
                                '">Deletar</button>
                                                                                                                                                                                                                        </td>';
                            echo '</tr>';
                        }
                        ?>
                        <?php
                        foreach ($leadsIndicados as $leadIndicado) {
                            $telefone = preg_replace('/\D/', '', $leadIndicado->Telefone);
                            echo '<tr>';
                            echo '<td>' . $leadIndicado->Nome . '</td>';
                            echo '<td>' . $telefone . '</td>';
                            echo '<td>' . $leadIndicado->Origem . '</td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td>' . $leadIndicado->NomeIndicador . '</td>';
                            echo '<td></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="modal" id="editarLeadModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Lead</h5>
                    <button type="button" class="close" data-dismiss="modal" onclick="modalEditarLead.modal('hide')"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditarLead">
                        <div class="form-group">
                            <label for="nome-edit">Nome Completo:</label>
                            <input type="text" class="form-control" name="Nome" id="nome-edit" required>
                        </div>
                        <div class="form-group">
                            <label for="telefone-edit">Número de Telefone:</label>
                            <input type="text" class="form-control celular" name="Telefone" id="telefone-edit"
                                required pattern="\(\d{2}\) \d{5}-\d{4}">
                        </div>
                        <div class="form-group">
                            <label for="email-edit">Email:</label>
                            <input type="email" class="form-control" name="Email" id="email-edit">
                        </div>
                        <div class="form-group">
                            <label for="atividadeVendedor-edit">Atividade:</label>
                            <select class="form-control" name="AtividadeVendedor" id="atividadeVendedor-edit">
                                <option value="">Selecione uma Atividade</option>
                                <option value="Ligar">Ligar</option>
                                <option value="Não Atendeu a Ligação">Não Atendeu a Ligação</option>
                                <option value="Retornar Ligação">Retornar Ligação</option>
                                <option value="Número Errado">Número Errado</option>
                                <option value="Chamar no WhatsApp">Chamar no WhatsApp</option>
                                <option value="Retornar WhatsApp">Retornar WhatsApp</option>
                                <option value="Não Retornou WhatsApp">Não Retornou WhatsApp</option>
                                <option value="Número sem WhatsApp">Número sem WhatsApp</option>
                                <option value="Não tem Interesse no Momento">Não tem Interesse no Momento</option>
                                <option value="Não tem Interesse em Consórcio">Não tem Interesse em Consórcio</option>
                                <option value="SPAM não chamar mais">SPAM não chamar mais</option>
                                <option value="Negociação Futura">Negociação Futura</option>
                                <option value="Em Negociação">Em Negociação</option>
                                <option value="Enviar Proposta">Enviar Proposta</option>
                                <option value="Agendar Reunião">Agendar Reunião</option>
                                <option value="Parou de Responder">Parou de Responder</option>
                                <option value="Cliente outra Adm">Cliente outra Adm</option>
                                <option value="Cliente Servopa outra Parceira">Cliente Servopa outra Parceira</option>
                                <option value="Vendedor outra Adm">Vendedor outra Adm</option>
                                <option value="Vendedor Servopa">Vendedor Servopa</option>
                                <option value="Cliente Orbita da Terra">Cliente Orbita da Terra</option>
                                <option value="Vendedor Orbita da Terra">Vendedor Orbita da Terra</option>
                                <option value="Quer Carta Contemplada">Quer Carta Contemplada</option>
                                <option value="Quer Vender sua Contemplada">Quer Vender sua Contemplada</option>
                                <option value="Quer Vender Carnê">Quer Vender Carnê</option>
                                <option value="Quer Vender Cancelada">Quer Vender Cancelada</option>
                                <option value="Quer ser Vendedor">Quer ser Vendedor</option>
                                <option value="Quer ser Indicador">Quer ser Indicador</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email-edit">Quando Executará Atividade?</label>
                            <input type="date" class="form-control" name="PrevisaoAtividadeVendedor"
                                id="previsaoAtividadeVendedor-edit">
                        </div>
                        <div class="form-group">
                            <label for="observacoes-edit">Observações</label>
                            <textarea class="form-control" name="Observacoes" id="observacoes-edit"></textarea>
                        </div>
                        <input type="hidden" name="IDCadastro" id="cadastroId-edit" value="">
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="enviarMensagemModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <input type="hidden" id="nomeLead" value="">
                <input type="hidden" id="telefoneLead" value="">
                <input type="hidden" id="nomeIndicador" value="">
                <div class="modal-header">
                    <h5 class="modal-title">Enviar Mensagem</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        onclick="modalEnviarMensagem.modal('hide')" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="form-group py-6">
                            <label>Acessar Whatsapp do Lead</label>
                        </div>
                        <button class="btn btn-success link-whatsapp" data-textareaid="">Acessar Whatsapp</button>
                    </div>
                    <div class="card">
                        <div class="form-group py-6">
                            <label>Mensagem Padrão 1</label>
                            <textarea id="mensagemPadrao1" rows="11" disabled class="form-control">Olá [NomeLead]!

Tudo bem?

Sou <?php echo $primeiroNomeUsuario; ?>, estou aqui para te orientar como adquirir motos, automóveis, imóveis, construir e investir através do Consórcio.

Não perca tempo! Confira a minha página repleta de opções de crédito disponíveis para você: https://orbitadaterraconsorcio.com.br/public/index.php/id/<?php echo auth()->user()->Telefone; ?>.

Estou à disposição para tornar seus sonhos em realidade.

Aguardo seu contato!</textarea>
                        </div>
                        <button class="btn btn-success link-whatsapp" data-textareaid="mensagemPadrao1">Enviar
                            Mensagem Padrão 1</button>
                    </div>
                    <div class="card">
                        <div class="form-group py-6">
                            <label>Mensagem com Indicador</label>
                            <textarea id="mensagemComIndicador" rows="11" disabled class="form-control">Olá [NomeLead], Tudo bem?  

Sou <?php echo $primeiroNomeUsuario; ?>, estou entrando em contato por indicação do [NomeIndicador] para te apresentar como adquirir motos, automóveis, imóveis, construir e investir através do Consórcio.  

Confira a minha página repleta de opções de crédito disponíveis para você: https://orbitadaterraconsorcio.com.br/public/index.php/id/<?php echo auth()->user()->Telefone; ?>.

 Vamos tornar seus sonhos em realidade? 

 Aguardo seu contato!</textarea>
                        </div>
                        <button class="btn btn-success link-whatsapp" data-textareaid="mensagemComIndicador">Enviar
                            Mensagem com Indicador</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
    <script>
        const modalEditarLead = $('#editarLeadModal');
        const modalEnviarMensagem = $('#enviarMensagemModal');

        var filtroAtividadeSelecionado = '';
        var filtroIndicadorSelecionado = '';

        function atualizarOptionsFiltroIndicador(table, filtroIndicadorSelecionado, dadosInvisiveis) {
            $('#filtroIndicador').empty();
            $('#filtroIndicador').append('<option value="">Todos</option>');

            if (dadosInvisiveis) {
                var data = table.column(5).data();

                indicadores.each(function(value, index) {
                    var count = data.filter(function(item) {
                        return item === value;
                    }).count();
                    $('#filtroIndicador').append('<option value="' + value + '"' + (filtroIndicadorSelecionado ===
                        value ? ' selected' : '') + '>' + value + ' (' + count + ')' + '</option>');
                });
            } else {
                var dadosVisiveis = table.rows({
                    filter: 'applied'
                }).data().toArray();
                var indicadoresUnicos = dadosVisiveis.map(row => row[5]).filter((value, index, self) => self.indexOf(
                    value) === index);
                indicadoresUnicos.forEach(function(value) {
                    var count = dadosVisiveis.filter(function(item) {
                        return item[5] === value;
                    }).length;
                    $('#filtroIndicador').append('<option value="' + value + '"' + (filtroIndicadorSelecionado ===
                        value ? ' selected' : '') + '>' + value + ' (' + count + ') </option>');
                });
            }
        }

        function atualizarOptionsFiltroAtividade(table, filtroAtividadeSelecionado, dadosInvisiveis) {
            $('#filtroAtividade').empty();
            $('#filtroAtividade').append('<option value="">Todas</option>');

            if (dadosInvisiveis) {
                var data = table.column(3).data();

                table.column(3).data().unique().sort().each(function(value, index) {
                    var count = data.filter(function(item) {
                        return item === value;
                    }).count();
                    if (value == '') {
                        $('#filtroAtividade').append('<option value=" ">Nenhuma</option>');
                    }
                    if (value !== null && value.trim() !== '') {
                        $('#filtroAtividade').append('<option value="' + value + '"' + (
                                filtroAtividadeSelecionado === value ? ' selected' : '') + '>' + value + ' (' +
                            count + ') </option>');
                    }
                });
            } else {
                var dadosVisiveis = table.rows({
                    filter: 'applied'
                }).data().toArray();
                var atividadesUnicas = dadosVisiveis.map(row => row[3]).filter((value, index, self) => self.indexOf(
                    value) === index);
                atividadesUnicas.forEach(function(value) {
                    var count = dadosVisiveis.filter(function(item) {
                        return item[3] === value;
                    }).length;
                    if (value == '') {
                        $('#filtroAtividade').append('<option value=" ">Nenhuma</option>');
                    }
                    if (value !== null && value.trim() !== '') {
                        $('#filtroAtividade').append('<option value="' + value + '"' + (
                                filtroAtividadeSelecionado === value ? ' selected' : '') + '>' + value + ' (' +
                            count + ') </option>');
                    }
                });
            }
        }

        $(document).ready(function() {
            var table = $('#table').DataTable({
                order: [],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json"
                },
                "dom": '<"row align-items-center"<"col-md-6" l><"col-md-6" f>>' +
                    '<"table-responsive border-bottom my-3" rt><"row align-items-center"' +
                    '<"col-md-6" i><"col-md-6" p>><"clear">',
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],
                "scrollY": "60vh",
                "scrollX": true,
                "scrollCollapse": true,
                "autoWidth": true,
                "responsive": true
            });

            atualizarOptionsFiltroIndicador(table, '');
            atualizarOptionsFiltroAtividade(table, '');

            $('#filtroAtividade').on('change', function() {
                var filtro = $(this).val();
                filtroAtividadeSelecionado = filtro;
                if (filtro === " ") {
                    table.columns(3).search('^$', true, false).draw();
                } else {
                    table.column(3).search(filtro).draw();
                }

                if (filtro === '') {
                    var dadosInvisiveis = true;
                } else {
                    var dadosInvisiveis = false;
                }

                atualizarOptionsFiltroIndicador(table, filtroIndicadorSelecionado, dadosInvisiveis);
            });

            $('#filtroIndicador').on('change', function() {
                var filtro = $(this).val();
                filtroIndicadorSelecionado = filtro;
                if (filtro === " ") {
                    table.columns(5).search('^$', true, false).draw();
                } else {
                    table.column(5).search(filtro).draw();
                }
                if (filtro === '') {
                    var dadosInvisiveis = true;
                } else {
                    var dadosInvisiveis = false;
                }
                atualizarOptionsFiltroAtividade(table, filtroAtividadeSelecionado, dadosInvisiveis);
            });


            table.on('click', '.delete-lead', function(event) {
                var cadastroId = $(this).data('id');
                var vendedorId = <?php echo auth()->user()->IDCadastro; ?>;

                var observacoes = prompt('Digite as observações (opcional):');

                if (observacoes === null) {
                    return;
                }

                if (confirm('Tem certeza de que deseja excluir este lead?')) {
                    $.ajax({
                        url: '/public/index.php/api/deletarLead',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            vendedorId: vendedorId,
                            cadastroId: cadastroId,
                            observacoes: observacoes
                        },
                        success: function(response) {
                            if (response === 'success') {
                                var row = table.row($('button[data-id="' + cadastroId + '"]')
                                    .closest('tr'));
                                row.remove().draw();
                            } else {
                                alert("Erro ao deletar o lead.");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Erro na requisição AJAX:', textStatus, errorThrown);
                            alert('Erro na requisição AJAX.');
                        }
                    });
                }
            });

            $('#email-edit').on('focusout', function() {
                var email = $(this).val();
                validarEmail(email, this);
            });

            table.on('click', '.editar-lead', function() {
                var cadastroId = $(this).data('id');
                $.ajax({
                    url: '/api/cadastros/' + cadastroId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var telefoneString = data.Telefone.toString();
                        var telefoneFormatado = telefoneString.replace(/\D/g, '').match(
                            /(\d{0,2})(\d{0,5})(\d{0,4})/);
                        var telefoneMascarado = !telefoneFormatado[2] ? telefoneFormatado[1] :
                            '(' + telefoneFormatado[1] + ') ' + telefoneFormatado[2] + (
                                telefoneFormatado[3] ? '-' + telefoneFormatado[3] : '');

                        $("#nome-edit").val(data.Nome);
                        $("#telefone-edit").val(telefoneMascarado);
                        $("#email-edit").val(data.Email);
                        $("#cadastroId-edit").val(cadastroId);
                        $("#atividadeVendedor-edit").val(data.AtividadeVendedor);
                        $("#previsaoAtividadeVendedor-edit").val(data
                            .PrevisaoAtividadeVendedor);
                        $("#observacoes-edit").val(data.Observacoes);

                        $('#editarLeadModal').modal('show');

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Erro na requisição AJAX:', textStatus, errorThrown);
                        alert('Erro na requisição AJAX.');
                    }
                });
            });

            $('.btn-enviar-mensagem').click(function() {
                var nomeLead = $(this).data('nomelead');
                var telefoneLead = $(this).data('telefonelead');
                var nomeIndicador = $(this).data('nomeindicador');

                $('#nomeLead').val(nomeLead);
                $('#telefoneLead').val(telefoneLead);
                $('#nomeIndicador').val(nomeIndicador);

                $('#enviarMensagemModal').modal('show');
            });

            $('.link-whatsapp').click(function() {
                var idTextArea = $(this).data('textareaid');
                var telefoneLead = $('#telefoneLead').val();
                if (idTextArea !== null && idTextArea !== undefined && idTextArea !== '') {
                    var mensagem = $('#' + idTextArea).val();
                    var nomeLead = $('#nomeLead').val();
                    var nomeIndicador = $('#nomeIndicador').val();

                    mensagem = mensagem.replace('[NomeLead]', nomeLead);
                    mensagem = mensagem.replace('[NomeIndicador]', nomeIndicador);
                    mensagem = encodeURIComponent(mensagem);
                    var linkWhatsapp = 'https://wa.me/55' + telefoneLead + '?text=' + mensagem;
                    window.location.href = linkWhatsapp;
                } else {
                    var linkWhatsapp = 'https://wa.me/55' + telefoneLead;
                    window.location.href = linkWhatsapp;
                }

                return false;
            });

        });

        $("#formEditarLead").submit(function() {
            event.preventDefault();
            var formData = $(this).serialize();
            let idCadastro = $("#cadastroId-edit").val();
            $.ajax({
                url: '/api/cadastros/' + idCadastro,
                type: 'PUT',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    window.location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Erro na requisição AJAX:', textStatus, errorThrown);
                    alert('Erro na requisição AJAX.');
                }
            });
        });

        function abrirFecharFormNovoLead() {
            $('#abrirFormNovoLead').toggleClass('d-none');
            $('#fecharFormNovoLead').toggleClass('d-none');
            $('#formNovoLead').toggleClass('d-none');
        }

        $('#formCadastrarLead').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/api/cadastros',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function() {
                    alert("Cadastro realizado com sucesso!");
                    window.location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Erro na requisição AJAX:', textStatus, errorThrown);
                    alert('Erro na requisição AJAX.');
                }
            });
        });
    </script>
@endsection
