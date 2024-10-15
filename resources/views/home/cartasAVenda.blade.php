@extends('master')
@section('title', 'Cartas À Venda')
@section('conteudo')
    @php $cartas = json_decode(file_get_contents('https://fragaebitelloconsorcios.com.br/api/json/contemplados'), true); @endphp

    @include('components.navbarHome', [
        'items' => [
            ['label' => 'Cartas Novas', 'url' => url('/' . $cadastro->IDCadastro), 'auth' => 'all'],
            ['label' => 'Dashboard', 'url' => url('/dashboard'), 'auth' => 'auth'],
            ['label' => 'Acessar Conta', 'url' => url('/usuario'), 'auth' => 'guest'],
            ['label' => 'Cadastrar-se', 'url' => url('/usuario' . $cadastro->IDCadastro), 'auth' => 'guest'],
        ],
    ])

    <div class="section 3" style="min-height: 85vh;">
        <div class="container">
            <div class="d-sm-flex py-3 align-items-sm-center">
                <div class="my-3 d-sm-flex">
                    <label>Categoria:</label>
                    <select id="filtroCategoria" class="ms-1 form-select form-select-sm w-auto"></select>
                </div>
                <div class="my-3 ms-2 d-sm-flex">
                    <label>Disponível:</label>
                    <select id="filtroDisponibilidade" class="ms-1 form-select form-select-sm w-auto"></select>
                </div>
                <div class="my-3 ms-2 d-sm-flex">
                    <label>Administradora:</label>
                    <select id="filtroAdministradora" class="ms-1 form-select form-select-sm w-auto"></select>
                </div>
                <div class="ps-5 h-50 d-sm-flex">
                    <button class="btn btn-info" id="limparFiltros">Limpar Filtros</button>
                </div>
            </div>
            <table id="table" class="table table-striped">
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
                    @foreach ($cartas as $carta)
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
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex align-items-end flex-column position-fixed bottom-0 end-0 m-5 gap-3" style="z-index: 1100;">
        @include('components.faleComOVendedor', ['cadastro' => $cadastro])
        {{-- <livewire:simulacao :cadastro="$cadastro" :vendedor="$vendedor" /> --}}
        <button class="fs-5 p-1 text-white rounded rounded-pill" style="background-color: #1e9ef3" onclick="window.location.href = '/simulacao/{{ $cadastro->IDCadastro }}'">Simular Agora</button>
        <button class="fs-5 bg-success text-white rounded rounded-pill p-1 px-2" onclick="window.location.href = '/carta-a-venda/8'">Venda sua Carta</button>
    </div>

    <script>
        const tiposCarta = document.querySelectorAll('.dropdown-menu li');
        const nav = document.getElementById('navbarSupportedContent');

        var filtroAdministradoraSelecionada = '';
        var filtroCategoriaSelecionada = '';
        var filtroDisponibilidadeSelecionada = '';

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

        function reservarCarta(button) {
            var numeroVendedor = {{ $vendedor->Telefone }}
            var mensagemPadrao = "Olá, eu gostaria de reservar uma carta à venda! Código: " + button.dataset.cartaId +
                ", valor de crédito: " + button.dataset.cartaValor + ", carta de " + button.dataset.cartaCategoria;

            mensagemPadrao = encodeURIComponent(mensagemPadrao);

            var linkWhatsApp = 'https://api.whatsapp.com/send?phone=' + numeroVendedor + '&text=' + mensagemPadrao;

            window.location.href = linkWhatsApp;
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
                "scrollY": "60vh",
                "scrollX": true,
                "scrollCollapse": true,
                "autoWidth": true,
                "responsive": true,
            });

            atualizarFiltros();

            $('#filtroCategoria').on('change', function() {
                var filtro = $(this).val();
                filtroCategoriaSelecionada = filtro;
                table.column(1).search(filtro).draw();

                atualizarFiltros();
            });

            $('#filtroAdministradora').on('change', function() {
                var filtro = $(this).val();
                filtroAdministradoraSelecionada = filtro;
                table.column(6).search(filtro).draw();

                atualizarFiltros();
            });

            $('#filtroDisponibilidade').on('change', function() {
                var filtro = $(this).val();
                filtroDisponibilidadeSelecionada = filtro;
                table.column(7).search(filtro).draw();

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
                filtroDisponibilidadeSelecionada = '';
                filtroAdministradoraSelecionada = '';
                filtroCategoriaSelecionada = '';
                atualizarFiltros();
            });

        });
    </script>
@endsection
