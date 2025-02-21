@extends('master')
@section('title', 'Cartas À Venda')
@section('conteudo')
    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    @php
        try {
            $response = Http::get('https://fragaebitelloconsorcios.com.br/api/json/contemplados');
            $cartasAPI = $response->json();
        } catch (\Exception $e) {
            $cartasAPI = [];
        }
    @endphp

    @include('components.navbarHome', ['cadastroId' => $cadastro->IDCadastro])

    <div class="d-flex justify-content-center align-items-center" style="min-height: 85vh;">
        <div style="width: 90vw">
            <div class="d-sm-flex align-items-sm-center py-3">
                <div class="d-sm-flex my-3">
                    <label>Categoria:</label>
                    <select class="form-select form-select-sm ms-1 w-auto" id="filtroCategoria"></select>
                </div>
                <div class="d-sm-flex my-3 ms-2">
                    <label>Disponível:</label>
                    <select class="form-select form-select-sm ms-1 w-auto" id="filtroDisponibilidade"></select>
                </div>
                <div class="d-sm-flex my-3 ms-2">
                    <label>Administradora:</label>
                    <select class="form-select form-select-sm ms-1 w-auto" id="filtroAdministradora"></select>
                </div>
                <div class="d-sm-flex my-3 ms-2">
                    <label>Contemplada?</label>
                    <select class="form-select form-select-sm ms-1 w-auto" id="filtroContemplada">
                        <option value="">Todas</option>
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                    </select>
                </div>

                <div class="h-50 d-sm-flex ps-5">
                    <button class="btn btn-info" id="limparFiltros">Limpar Filtros</button>
                </div>
            </div>
            <table class="table-striped table" id="table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Categoria</th>
                        <th>Crédito</th>
                        <th>Entrada</th>
                        <th>Meses</th>
                        <th>Parcela</th>
                        <th>Administradora</th>
                        <th>Disponibilidade</th>
                        <th>Contemplada?</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartasVendidas as $carta)
                        <tr>
                            <td>{{ $carta->IDCartaVendida }}</td>
                            <td>{{ $carta->tipoCarta->Descricao }}</td>
                            <td>R$ {{ number_format($carta->ValorCredito, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($carta->ValorGarantia, 2, ',', '.') }}</td>
                            <td>{{ $carta->ParcelasPagar }}</td>
                            <td>R$ {{ number_format($carta->ValorParcela, 2, ',', '.') }}</td>
                            <td>{{ $carta->empresaAdministradora->NomeFantasia }}</td>
                            <td>
                                @if ($carta->Status == 'Reservar')
                                    Disponível
                                @else
                                    Reservado
                                @endif
                            </td>
                            <td>
                                @if ($carta->Contemplada)
                                    Sim
                                @else
                                    Não
                                @endif
                            </td>
                            <td>
                                @if ($carta->Status == 'Reservar')
                                    <button class="btn btn-success reservar" data-carta-id="{{ $carta['id'] }}"
                                        data-carta-categoria="{{ $carta->tipoCarta->descricao }}"
                                        data-carta-valor="{{ $carta->ValorCredito }}"
                                        onclick="reservarCarta(this)">Reservar</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @if ($cartasAPI != [])
                        @foreach ($cartasAPI as $carta)
                            <tr>
                                <td>{{ htmlspecialchars($carta['id']) }}</td>
                                <td>{{ htmlspecialchars($carta['categoria']) }}</td>
                                <td>R$ {{ number_format($carta['valor_credito'], 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($carta['entrada'], 2, ',', '.') }}</td>
                                <td>{{ htmlspecialchars($carta['parcelas']) }}</td>
                                <td>R$ {{ number_format($carta['valor_parcela'], 2, ',', '.') }}</td>
                                <td>{{ htmlspecialchars($carta['administradora']) }}</td>
                                <td>
                                    @if ($carta['reserva'] == 'Reservar')
                                        Disponível
                                    @else
                                        Reservado
                                    @endif
                                </td>
                                <td>Sim</td>
                                <td>
                                    @if ($carta['reserva'] == 'Reservar')
                                        <button class="btn btn-success reservar" data-carta-id="{{ $carta['id'] }}"
                                            data-carta-categoria="{{ $carta['categoria'] }}"
                                            data-carta-valor="{{ $carta['valor_credito'] }}"
                                            onclick="reservarCarta(this)">Reservar</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @include('components.floatMenu', ['cadastro' => $cadastro, 'vendedor' => $vendedor])

    <script>
        const tiposCarta = document.querySelectorAll('.dropdown-menu li');
        const nav = document.getElementById('navbarSupportedContent');

        let filtroAdministradoraSelecionada = '';
        let filtroCategoriaSelecionada = '';
        let filtroDisponibilidadeSelecionada = '';

        function atualizarOptionsfiltro(table, filtro, posicaoColuna, filtroSelecionado) {
            filtro.empty();
            filtro.append('<option value="">Todas</option>');

            let dados = table.column(posicaoColuna, {
                filter: 'applied'
            }).data();

            let dadosUnicos = dados.unique().toArray();

            dadosUnicos.forEach(function(value) {
                let count = dados.filter(function(item) {
                    return item === value;
                }).count();

                if (value !== null && value !== '') {
                    filtro.append('<option value="' + value + '"' + (filtroSelecionado === value ? ' selected' :
                        '') + '>' + value + ' (' + count + ') </option>');
                }
            });
        }

        function reservarCarta(button) {
            let numeroVendedor = {{ $vendedor->Telefone }};
            let mensagemPadrao = "Olá, eu gostaria de reservar uma carta à venda! Código: " + button.dataset.cartaId +
                ", valor de crédito: " + button.dataset.cartaValor + ", carta de " + button.dataset.cartaCategoria;

            mensagemPadrao = encodeURIComponent(mensagemPadrao);

            window.location.href = 'https://api.whatsapp.com/send?phone=' + numeroVendedor + '&text=' + mensagemPadrao;
        }

        $(document).ready(function() {
            const table = $('#table').DataTable({
                order: [],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json"
                },
                "dom": '<"row align-items-center"<"col-md-6" l><"col-md-6" f>>' +
                    '<"table-responsive border-bottom my-3" rt><"row align-items-center"' +
                    '<"col-md-6" i><"col-md-6" p>><"clear">',
                "scrollY": "60vh",
                "scrollX": true,
                "scrollCollapse": true,
                "autoWidth": true,
                "responsive": true,
            });
            $('#table').css('width', '100%');
            $('.dataTables_scrollHeadInner').css('width', '100%');
            atualizarFiltros();

            $('#filtroCategoria').on('change', function() {
                let filtro = $(this).val();
                filtroCategoriaSelecionada = filtro;
                table.column(1).search(filtro).draw();

                atualizarFiltros();
            });

            $('#filtroAdministradora').on('change', function() {
                let filtro = $(this).val();
                filtroAdministradoraSelecionada = filtro;
                table.column(6).search(filtro).draw();

                atualizarFiltros();
            });

            $('#filtroDisponibilidade').on('change', function() {
                let filtro = $(this).val();
                filtroDisponibilidadeSelecionada = filtro;
                table.column(7).search(filtro).draw();

                atualizarFiltros();
            });

            $('#filtroContemplada').on('change', function() {
                let filtro = $(this).val();
                table.column(8).search(filtro).draw();
                atualizarFiltros();
            });

            function atualizarFiltros() {
                atualizarOptionsfiltro(table, $('#filtroCategoria'), 1, filtroCategoriaSelecionada);
                atualizarOptionsfiltro(table, $('#filtroAdministradora'), 6, filtroAdministradoraSelecionada);
                atualizarOptionsfiltro(table, $('#filtroDisponibilidade'), 7, filtroDisponibilidadeSelecionada);
            }

            $('#limparFiltros').on('click', function() {
                table.column(1).search('').draw();
                table.column(6).search('').draw();
                table.column(7).search('').draw();
                table.column(8).search('').draw();
                filtroDisponibilidadeSelecionada = '';
                filtroAdministradoraSelecionada = '';
                filtroCategoriaSelecionada = '';
                atualizarFiltros();
            });

        });
    </script>
@endsection
