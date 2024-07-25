@extends('dashboard')
@section('title', 'Contas')
@section('pagina')
    <div class="col-16">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Login</th>
                                <th>Email Confirmado</th>
                                <th>Telefone</th>
                                <th>Tipo Cadastro</th>
                                <th>Data Cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contas as $conta)
                                <tr>
                                    <td class="{{ $conta->ContaSuspendida ? 'text-danger' : '' }}">{{ $conta->cadastro->Nome }}</td>
                                    <td>{{ $conta->Login }}</td>
                                    @if ($conta->EmailConfirmado)
                                        <td>Confirmado</td>
                                    @else
                                        <td>Não Confirmado</td>
                                    @endif
                                    <td>{{ $conta->cadastro->Telefone }}</td>
                                    <td>{{ $conta->cadastro->TipoCadastro }}</td>
                                    <td>{{ $conta->DataCadastro }}</td>
                                    <td>
                                        <button class="btn btn-info detalhes"
                                            data-id="{{ $conta->IDCadastro }}">Detalhes</button>
                                        @if (!$conta->AdminConfirmado)
                                            <button class="btn btn-success liberar"
                                                data-id="{{ $conta->IDUsuario }}">Liberar</button>
                                        @elseif (!$conta->ContaSuspendida)
                                            <button class="btn btn-danger suspender"
                                                data-id="{{ $conta->IDUsuario }}">Suspender</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="detalhesConta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dados Conta</h5>
                    <button type="button" class="close" data-dismiss="modal" onclick="modal.modal('hide')"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nome-details">Nome Completo:</label>
                        <input type="text" class="form-control" name="nome" id="nome-details" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="telefone-details">Telefone:</label>
                        <input type="text" class="form-control celular" name="telefone" id="telefone-details" required
                            disabled pattern="\(\d{2}\) \d{5}-\d{4}">
                    </div>
                    <div class="form-group">
                        <label for="cpf-details">CPF:</label>
                        <input type="text" class="form-control cpf" name="cpf" id="cpf-details" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="email-details">Email:</label>
                        <input type="email" class="form-control" name="email" id="email-details" disabled>
                    </div>
                    <div class="form-group">
                        <label for="cep-details">CEP:</label>
                        <input type="text" class="form-control cep" name="cep" id="cep-details" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="endereco-details">Endereço:</label>
                        <input type="text" class="form-control" name="endereco" id="endereco-details" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="estado-details">Bairro:</label>
                        <input type="text" class="form-control" name="bairro" id="bairro-details" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="estado-details">Cidade:</label>
                        <input type="text" class="form-control" name="cidade" id="cidade-details" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="estado-details">Estado:</label>
                        <input type="text" class="form-control" name="estado" id="estado-details" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="tipocadastro-details">Tipo de Cadastro:</label>
                        <input type="text" class="form-control" name="tipocadastro" id="tipocadastro-details" disabled
                            required>
                    </div>
                    <div class="form-group">
                        <label for="datacadastro-details">Data de Cadastro:</label>
                        <input type="datetime-local" class="form-control" name="datacadastro" id="datacadastro-details"
                            disabled required>
                    </div>
                    <div class="form-group">
                        <label for="arquivo-details">Arquivo:</label>
                        <iframe style="width:100%; height:500px;" name="arquivo" id="arquivo-details"></iframe>
                    </div>

                    <!-- Campo ocultado -->
                    <div class="form-group d-none">
                        <label for="observacoes-details">Observações</label>
                        <textarea class="form-control" name="observacoes" id="observacoes-details" disabled></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        const modal = $('#detalhesConta');
        $(document).ready(function() {

            var table = $('#datatable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json"
                },
                "dom": '<"row align-items-center"<"col-md-6" l><"col-md-6" f>><"table-responsive border-bottom my-3" rt><"row align-items-center" <"col-md-6" i><"col-md-6" p>><"clear">',
                "responsive": true,
                "order": []
            });

            table.on('click', '.detalhes', function() {
                var idUsuario = $(this).data('id');
                $.ajax({
                    url: '/api/cadastros/' + idUsuario,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            $("#nome-details").val(data.Nome);
                            var telefoneString = data.Telefone.toString();
                            var telefoneFormatado = telefoneString.replace(/\D/g, '').match(
                                /(\d{0,2})(\d{0,5})(\d{0,4})/);
                            var telefoneMascarado = !telefoneFormatado[2] ? telefoneFormatado[
                                    1] : '(' + telefoneFormatado[1] + ') ' + telefoneFormatado[
                                    2] +
                                (telefoneFormatado[3] ? '-' + telefoneFormatado[3] : '');
                            $("#telefone-details").val(telefoneMascarado);
                            $("#cpf-details").val(data.CPF);
                            $("#email-details").val(data.Email);
                            $("#cep-details").val(data.CEP);
                            $("#endereco-details").val(data.Endereco);
                            $("#bairro-details").val(data.Bairro);
                            $("#cidade-details").val(data.Cidade);
                            $("#estado-details").val(data.Estado);
                            $("#tipocadastro-details").val(data.TipoCadastro);
                            $("#datacadastro-details").val(data.DataCadastro);
                            $("#observacoes-details").val(data.Observacoes);
                            $("#arquivo-details").attr("src", data.Curriculo);
                            $('#detalhesConta').modal('show');
                        } else {
                            alert('Lead não encontrado ou erro ao buscar os dados.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Erro na requisição AJAX:', textStatus, errorThrown);
                        alert('Erro na requisição AJAX.');
                    }
                });
            });

            table.on('click', '.liberar', function() {
                var button = $(this);
                var idUsuario = $(this).data('id');
                if (confirm('Tem certeza de que deseja liberar essa conta?')) {
                    $.ajax({
                        url: '/api/usuario/liberar/' + idUsuario,
                        type: 'PUT',
                        dataType: 'json',
                        success: function() {
                            alert('Aprovado!');
                            var row = table.row($('button[data-id="' + idUsuario + '"]')
                                .closest('tr'));
                            row.remove().draw();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Erro na requisição AJAX:', textStatus, errorThrown);
                            alert('Erro na requisição AJAX.');
                        }
                    });
                }
            });


            table.on('click', '.suspender', function() {
                var button = $(this);
                var idUsuario = $(this).data('id');
                if (confirm('Tem certeza de que deseja suspender essa conta?')) {
                    $.ajax({
                        url: '/api/usuario/suspender/' + idUsuario,
                        type: 'PUT',
                        dataType: 'json',
                        success: function(data) {
                            alert('Suspendido!');
                            var row = table.row($('button[data-id="' + idUsuario + '"]')
                                .closest('tr'));
                            row.remove().draw();

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Erro na requisição AJAX:', textStatus, errorThrown);
                            alert('Erro na requisição AJAX.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
