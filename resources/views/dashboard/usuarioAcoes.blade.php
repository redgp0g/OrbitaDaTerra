@extends('dashboard')
@section('title', 'Dashboard')
@section('pagina')

  <div class="col-16">
    <div class="card">
      <div class="card-body">
        <div class="d-sm-flex my-3">
          <label>Filtrar Usuário por:</label>
          <select class="form-select form-select-sm w-auto" id="filtroUsuario">
            <option value="">Todos</option>
          </select>
        </div>
        <div class="table-responsive">
          <table class="table-striped table" id="table">
            <thead>
              <tr>
                <th>Nome do Usuário</th>
                <th>Descrição</th>
                <th>Data e Hora</th>
                <th>Navegador</th>
                <th>Endereço de Ip</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($usuarioAcoes as $usuarioAcao)
                <tr>
                  <td>{{ $usuarioAcao->usuario->Cadastro->Nome }}</td>
                  <td>{{ $usuarioAcao->Descricao }}</td>
                  <td>{{ $usuarioAcao->DataHora }}</td>
                  <td>{{ $usuarioAcao->Navegador }}</td>
                  <td>{{ $usuarioAcao->EnderecoIp }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      const table = $('#table').DataTable({
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
        "autoWidth": false,
        "responsive": false
      });

      table.column(0).data().unique().sort().each(function(value) {
        if (value !== null && value.trim() !== '') {
          $('#filtroUsuario').append('<option value="' + value + '" >' + value + '</option>');
        }
      });

      $('#filtroUsuario').on('change', function() {
        let filtro = $(this).val();
        table.column(0).search(filtro).draw();
      });
    });
  </script>
@endsection
