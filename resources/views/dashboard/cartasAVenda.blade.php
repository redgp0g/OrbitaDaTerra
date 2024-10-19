@extends('dashboard')
@section('title', 'Cartas A Venda')
@section('pagina')
  <div class="col-16">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="datatable" data-toggle="data-table">
            <thead>
              <tr>
                <th>Tipo de Carta</th>
                <th>Status</th>
                <th>Consorciado</th>
                <th>Telefone Consorciado</th>
                <th>Autorizada</th>
                <th>Valor do Crédito</th>
                <th>Valor Pago</th>
                <th>Valor de Venda</th>
                <th>Saldo Devedor</th>
                <th>Parcelas Pagas</th>
                <th>Parcelas a Pagar</th>
                <th>Valor da Parcela</th>
                <th>Vencimento</th>
                <th>Valor de Garantia</th>
                <th>Grupo</th>
                <th>Cota</th>
                <th>Observações</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($cartasAVenda as $cartaAVenda)
                @php
                  switch ($cartaAVenda->Status) {
                      case 'Em Aprovação':
                          $cor = 'text-warning';
                          break;
                      case 'Bloqueada':
                          $cor = 'text-danger';
                          break;
                      case 'Aprovada':
                          $cor = 'text-success';
                          break;
                      default:
                          break;
                  }
                @endphp
                <tr>
                  <td>{{ $cartaAVenda->TipoCarta->Descricao }}</td>
                  <td class="{{ $cor }}" data-column="status">{{ $cartaAVenda->Status }}</td>
                  <td>{{ $cartaAVenda->cadastroConsorciado->Nome }}</td>
                  <td>{{ $cartaAVenda->cadastroConsorciado->Telefone }}</td>
                  <td>{{ $cartaAVenda->empresaAutorizada->RazaoSocial }}</td>
                  <td>{{ $cartaAVenda->ValorCredito }}</td>
                  <td>{{ $cartaAVenda->ValorPago }}</td>
                  <td>{{ $cartaAVenda->ValorVenda }}</td>
                  <td>{{ $cartaAVenda->SaldoDevedor }}</td>
                  <td>{{ $cartaAVenda->ParcelasPagas }}</td>
                  <td>{{ $cartaAVenda->ParcelasPagar }}</td>
                  <td>{{ $cartaAVenda->ValorParcela }}</td>
                  <td>{{ $cartaAVenda->DiaVencimento }}</td>
                  <td>{{ $cartaAVenda->ValorGarantia }}</td>
                  <td>{{ $cartaAVenda->Grupo }}</td>
                  <td>{{ $cartaAVenda->Cota }}</td>
                  <td>{{ $cartaAVenda->Observacoes }}</td>
                  <td>
                    @if ($cartaAVenda->Status == 'Em Aprovação')
                      <button class="btn btn-success aprovar" data-id="{{ $cartaAVenda->IDCartaVendida }}">Aprovar</button>
                      <button class="btn btn-danger bloquear" data-id="{{ $cartaAVenda->IDCartaVendida }}">Bloquear</button>
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

  <script>
    $(document).ready(function() {

      var table = $('#datatable').DataTable({
        "language": {
          "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json"
        },
        "dom": '<"row align-items-center"<"col-md-6" l><"col-md-6" f>><"table-responsive border-bottom my-3" rt><"row align-items-center" <"col-md-6" i><"col-md-6" p>><"clear">',
        "responsive": true,
        "order": []
      });

      table.on('click', '.aprovar', function() {
        var button = $(this);
        var id = $(this).data('id');        
        if (confirm('Tem certeza de que deseja aprovar essa carta?')) {
          $.ajax({
            url: '/api/cartaAVenda/aprovar/' + id,
            type: 'PUT',
            dataType: 'json',
            success: function() {
              alert('Aprovada!');
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.error('Erro na requisição AJAX:', textStatus, errorThrown);
              alert('Erro na requisição AJAX.');
            }
          });
        }
      });


      table.on('click', '.bloquear', function() {
        var button = $(this);
        var id = $(this).data('id');
        if (confirm('Tem certeza de que deseja bloquear essa carta?')) {
          $.ajax({
            url: '/api/cartaAVenda/bloquear/' + id,
            type: 'PUT',
            dataType: 'json',
            success: function(data) {
              alert('Bloqueada!');
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
