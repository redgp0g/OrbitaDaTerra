@extends('dashboard')
@section('title', 'Contas')
@section('pagina')
  <div class="col-16">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="datatable" data-toggle="data-table">
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
                    <button class="btn btn-info detalhes" data-id="{{ $conta->IDCadastro }}">Detalhes</button>
                    @if (!$conta->AdminConfirmado)
                      <button class="btn btn-success liberar" data-id="{{ $conta->IDUsuario }}">Liberar</button>
                    @elseif (!$conta->ContaSuspendida)
                      <button class="btn btn-danger suspender" data-id="{{ $conta->IDUsuario }}">Suspender</button>
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

  <div class="modal" id="detalhesConta" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Dados Conta</h5>
          <button class="close" data-dismiss="modal" type="button" aria-label="Close" onclick="modal.modal('hide')">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <a class="text-success" id="linkPaginaVendedor" target="_blank">Link Pagina do Vendedor</a>
          </div>
          <div class="form-group">
            <label for="nome-details">Nome Completo:</label>
            <input class="form-control" id="nome-details" name="nome" type="text" disabled>
          </div>
          <div class="form-group">
            <label for="telefone-details">Telefone:</label>
            <input class="form-control celular" id="telefone-details" name="telefone" type="text" disabled>
          </div>
          <div class="form-group">
            <label for="cpf-details">CPF:</label>
            <input class="form-control cpf" id="cpf-details" name="cpf" type="text" disabled>
          </div>
          <div class="form-group">
            <label for="email-details">Email:</label>
            <input class="form-control" id="email-details" name="email" type="email" disabled>
          </div>
          <div class="form-group">
            <label for="cep-details">CEP:</label>
            <input class="form-control cep" id="cep-details" name="cep" type="text" disabled>
          </div>
          <div class="form-group">
            <label for="endereco-details">Endereço:</label>
            <input class="form-control" id="endereco-details" name="endereco" type="text" disabled>
          </div>
          <div class="form-group">
            <label for="estado-details">Bairro:</label>
            <input class="form-control" id="bairro-details" name="bairro" type="text" disabled>
          </div>
          <div class="form-group">
            <label for="estado-details">Cidade:</label>
            <input class="form-control" id="cidade-details" name="cidade" type="text" disabled>
          </div>
          <div class="form-group">
            <label for="estado-details">Estado:</label>
            <input class="form-control" id="estado-details" name="estado" type="text" disabled>
          </div>
          <div class="form-group">
            <label for="tipocadastro-details">Tipo de Cadastro:</label>
            <input class="form-control" id="tipocadastro-details" name="tipocadastro" type="text" disabled>
          </div>
          <div class="form-group">
            <label for="datacadastro-details">Data de Cadastro:</label>
            <input class="form-control" id="datacadastro-details" name="datacadastro" type="datetime-local" disabled>
          </div>
          <!-- Campo ocultado -->
          <div class="form-group d-none">
            <label for="observacoes-details">Observações</label>
            <textarea class="form-control" id="observacoes-details" name="observacoes" disabled></textarea>
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
              $("#telefone-details").val(data.Telefone);
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
              $("#linkPaginaVendedor").attr("href", "/" + idUsuario);
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
