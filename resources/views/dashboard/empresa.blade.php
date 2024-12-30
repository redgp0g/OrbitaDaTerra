@extends('dashboard')
@section('title', 'Empresas')
@section('pagina')
  <div class="col-16">
    <div class="card">
      <div class="card-body">
        <div class="d-lg-flex col">
          <div class="my-3 d-sm-flex">
            <label class="me-1">Tipo:</label>
            <select class="form-select form-select-sm w-auto" id="filtroTipo"></select>
          </div>
        </div>
        <table class="table table-striped" id="table">
          <thead>
            <tr>
              <th>Nome Fantasia</th>
              <th>Razão Social</th>
              <th>Telefone</th>
              <th>Nome Representante</th>
              <th>CEP</th>
              <th>Tipo</th>
              <th>Data de Cadastro</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($empresas as $empresa)
              <tr>
                <td>{{ $empresa->NomeFantasia }}</td>
                <td>{{ $empresa->RazaoSocial }}</td>
                <td>{{ $empresa->Telefone }}</td>
                <td>{{ $empresa->NomeRepresentante }}</td>
                <td>{{ $empresa->CEP }}</td>
                <td>{{ $empresa->TipoEmpresa }}</td>
                <td>{{ $empresa->DataCadastro }}</td>
                <td>
                  <button class="btn btn-danger delete" data-id="{{ $empresa->IDEmpresa }}">Deletar</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </main>
  <script>
    var filtroTipo = '';

    function atualizarOptionsfiltro(table, filtro, posicaoColuna, filtroSelecionado) {
      filtro.empty();
      filtro.append('<option value="">Todas</option>');

      var dados = table.column(posicaoColuna, {
        filter: 'applied'
      }).data();

      var dadosUnicos = dados.unique().toArray();

      dadosUnicos.forEach(function(value) {
        var count = dados.filter(function(item) {
          return item === value;
        }).count();

        if (value !== null && value !== '') {
          filtro.append('<option value="' + value + '"' + (filtroSelecionado === value ? ' selected' :
            '') + '>' + value + ' (' + count + ') </option>');
        }
      });
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

      atualizarOptionsfiltro(table, $('#filtroTipo'), 5, filtroTipo);

      table.on('click', '.delete', function(event) {
        var empresaId = $(this).data('id');

        if (confirm('Tem certeza de que deseja excluir esta empresa?')) {
          $.ajax({
            url: '/api/empresas/' + empresaId,
            type: 'DELETE',
            dataType: 'json',
            success: function(response) {
              var row = table.row($('button[data-id="' + empresaId + '"]')
                .closest('tr'));
              row.remove().draw();
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.error('Erro na requisição AJAX:', textStatus, errorThrown);
                console.error('Response details:', jqXHR.responseText);
              alert('Erro na requisição AJAX.');
            }
          });
        }
      });

      $('#filtroTipo').on('change', function() {
        var filtro = $(this).val();
        filtroTipo = filtro;
        table.column(5).search(filtro).draw();

        atualizarOptionsFiltroDataTable(table, $('#filtroTipo'), 5, filtroTipo);
      });
    });
  </script>
@endsection
