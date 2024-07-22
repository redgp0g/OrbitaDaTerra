@extends('dashboard')
@section('title', 'Dashboard')
@section('pagina')
    @php
        $primeiroNomeUsuario = explode(' ', auth()->user()->Nome)[0];
    @endphp
    <div class="col-16">
        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex col">
                    <div class="my-3 d-sm-flex">
                        <label class="me-1">Vendedor:</label>
                        <select id="filtroVendedor" class="form-select form-select-sm w-auto"></select>
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
                            <th>Indicador</th>
                            <th>Vendedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $lead)
                            @php
                                $telefone = preg_replace('/\D/', '', $lead->Telefone);
                                $primeiroNomeLead = explode(' ', $lead->Nome)[0];
                                $primeiroNomeIndicador = explode(' ', $lead->NomeIndicador)[0];
                            @endphp
                            <tr>
                                <td>{{ $lead->Nome }}</td>
                                <td>{{ $telefone }}</td>
                                <td>{{ $lead->Origem }}</td>
                                <td>{{ $lead->AtividadeVendedor }}</td>
                                <td>{{ $lead->PrevisaoAtividadeVendedor }}</td>
                                <td>{{ $lead->NomeIndicador }}</td>
                                <td>{{ $lead->NomeVendedor }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        var filtroAtividadeSelecionado = '';
        var filtroVendedorSelecionado = '';

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

        function atualizarOptionsFiltroVendedor(table, filtroVendedorSelecionado, dadosInvisiveis) {
            $('#filtroVendedor').empty();
            $('#filtroVendedor').append('<option value="">Todas</option>');

            if (dadosInvisiveis) {
                var data = table.column(6).data();

                table.column(6).data().unique().sort().each(function(value, index) {
                    var count = data.filter(function(item) {
                        return item === value;
                    }).count();
                    if (value == '') {
                        $('#filtroVendedor').append('<option value=" ">Nenhum</option>');
                    }
                    if (value !== null && value.trim() !== '') {
                        $('#filtroVendedor').append('<option value="' + value + '"' + (
                                filtroVendedorSelecionado === value ? ' selected' : '') + '>' + value + ' (' +
                            count + ') </option>');
                    }
                });
            } else {
                var dadosVisiveis = table.rows({
                    filter: 'applied'
                }).data().toArray();
                var vendedoresUnicos = dadosVisiveis.map(row => row[6]).filter((value, index, self) => self.indexOf(
                    value) === index);
                    vendedoresUnicos.forEach(function(value) {
                    var count = dadosVisiveis.filter(function(item) {
                        return item[6] === value;
                    }).length;
                    if (value == '') {
                        $('#filtroVendedor').append('<option value=" ">Nenhum</option>');
                    }
                    if (value !== null && value.trim() !== '') {
                        $('#filtroVendedor').append('<option value="' + value + '"' + (
                                filtroVendedorSelecionado === value ? ' selected' : '') + '>' + value + ' (' +
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

            atualizarOptionsFiltroAtividade(table, '');
            atualizarOptionsFiltroVendedor(table, '');

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

                atualizarOptionsFiltroVendedor(table, filtroVendedorSelecionado, dadosInvisiveis);
            });

            $('#filtroVendedor').on('change', function() {
                var filtro = $(this).val();
                filtroVendedorSelecionado = filtro;
                if (filtro === " ") {
                    table.columns(6).search('^$', true, false).draw();
                } else {
                    table.column(6).search(filtro).draw();
                }
                if (filtro === '') {
                    var dadosInvisiveis = true;
                } else {
                    var dadosInvisiveis = false;
                }
                atualizarOptionsFiltroAtividade(table, filtroAtividadeSelecionado, dadosInvisiveis);
            });
        });
    </script>
@endsection
