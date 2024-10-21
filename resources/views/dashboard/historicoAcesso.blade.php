@extends('master')
@section('title', 'Dashboard')
@section('conteudo')
  <div id="loading">
    <div class="loader simple-loader">
      <div class="loader-body">
      </div>
    </div>
  </div>

  @include('partials.asideDashboard')
  <main class="main-content">
    <div class="position-relative iq-banner">
      @include('partials.navbarDashboard')
      <div class="iq-navbar-header" style="height: 115px;">
        <div class="container-fluid iq-container">
          <div class="row">
            <div class="col-md-12">
              <div class="flex-wrap d-flex justify-content-between align-items-center">
                Histórico de Acesso
              </div>
            </div>
          </div>
        </div>
        <div class="iq-header-img">
          <img class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX" src="{{ asset('/images/dashboard/top-header.png') }}" alt="header">
        </div>
      </div>
    </div>
    <div class="conatiner-fluid content-inner mt-n5 py-3">
      <div class="row">
        <div class="col-16">
          <div class="card">
            <div class="card-body">
              <div class="my-3 d-sm-flex">
                <label>Filtrar Usuário por:</label>
                <select class="form-select form-select-sm w-auto" id="filtroUsuario">
                  <option value="">Todos</option>
                </select>
              </div>
              <div class="table-responsive">
                <table class="table table-striped" id="table">
                  <thead>
                    <tr>
                      <th>Nome Usuário</th>
                      <th>Data de Acesso</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($acessos as $acesso)
                      <tr>
                        <td>{{ $acesso->usuario->cadastro->Nome }}</td>
                        <td>{{ $acesso->DataEntrada }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script>
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

      table.column(0).data().unique().sort().each(function(value, index) {
        if (value !== null && value.trim() !== '') {
          $('#filtroUsuario').append('<option value="' + value + '" >' + value + '</option>');
        }
      });

      $('#filtroUsuario').on('change', function() {
        var filtro = $(this).val();
        table.column(0).search(filtro).draw();
      });
    });
  </script>
@endsection
