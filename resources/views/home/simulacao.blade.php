@extends('master')
@section('title', 'Simulação')
@section('conteudo')

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic py-5">
      <div class="authentication-inner">
        <div class="card">
          <div class="card-body">
            <div class="app-brand justify-content-center d-flex">
              <img src="{{ asset('/images/logo.png') }}" height="100px">
            </div>
            <div>
              <h4 class="mb-2">Dados</h4>
              <p class="text-primary mb-4">Informe seus dados para prosseguir</p>
              <div id="simulacao-dados-lead">
                <div class="card-body">
                  <form id="formSimulacaoDados">
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label class="form-label" for="simulacao-nome">Nome:</label>
                        <input class="form-control" id="simulacao-nome" name="Nome" type="text" required placeholder="Nome">
                      </div>
                      <div class="d-flex flex-column form-group col-md-6">
                        <label class="form-label" for="simulacao-celular">Celular:</label>
                        <input class="form-control celular" id="simulacao-celular" name="" type="text" required>
                      </div>
                      <input name="Origem" type="hidden" value="Lead fez a Simulação">
                      <input name="TipoCadastro" type="hidden" value="Lead">
                      <input name="IDCadastroVendedor" type="hidden" value="{{ $vendedor->IDCadastro }}">
                      <input name="IDCadastroIndicador" type="hidden" value="{{ $cadastro->IDCadastro }}">
                      <button class="btn btn-primary" type="submit">Próximo</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="d-none vw-auto" id="simulacao-dados">
                <h5 class="mb-3">Simulação</h5>
                <form id="formSimulacao" method="POST">
                  <div class="form-group col-sm-6">
                    <label class="form-label" for="IDTipoCarta">Consórcio:</label>
                    <select class="selectpicker form-control" id="IDTipoCarta" name="IDTipoCarta" data-style="py-0" required>
                      <option value="" selected disabled>Selecione o Consórcio</option>
                      @foreach ($tiposCarta as $tipo)
                        <option value="{{ $tipo->IDTipoCarta }}">{{ $tipo->Descricao }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="d-none row" id="simulacao2">
                    <div class="form-group col-md-6">
                      <label class="form-label" for="Credito">Valor do Crédito:</label>
                      <select class="form-control select2" id="Credito" name="Credito" multiple required>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label class="form-label" for="Prazo">Prazo:</label>
                      <select class="selectpicker form-control" id="Prazo" name="Prazo" required>
                        <option value="" selected disabled>Selecione o Prazo</option>
                      </select>
                    </div>
                    <input id="IDCadastro" name="IDCadastro" type="hidden">
                  </div>
                  <button class="btn btn-primary" type="submit">Gerar Simulação</button>
                </form>
              </div>
              <div class="mt-4 d-none" id="simulacao">
                <table class="table table-striped" id="tableSimulacao">
                  <thead>
                    <tr>
                      <th>Crédito</th>
                      <th>Parcela Integral</th>
                      <th>Parcela Flex</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
                <div class="justify-content-center d-flex">www.orbitadaterraconsorcio.com.br</div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script type="module">
    import intlTelInput from 'https://cdn.jsdelivr.net/npm/intl-tel-input@23.3.0/+esm'
    const input = document.querySelector(".celular");
    const iti = intlTelInput(input, {
      initialCountry: "br",
      strictMode: true,
      separateDialCode: true,
      utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.3.0/build/js/utils.js",
    });

    const hiddenInput = document.createElement("input");
    hiddenInput.type = "hidden";
    hiddenInput.name = "Telefone";
    input.parentNode.appendChild(hiddenInput);

    var table = $('#tableSimulacao').DataTable({
      "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json"
      },
      "dom": '<"row align-items-center"<"col-md-6" l><"col-md-6" f>><"table-responsive border-bottom my-3" rt><"row align-items-center" <"col-md-6"><"col-md-6" p>><"clear">',
      "responsive": true,
      "order": [],
      "paging": false,
      "searching": false
    });


    $('#formSimulacaoDados').submit(function(event) {
      event.preventDefault();
      let celular = iti.getNumber();
      if (celular.startsWith('+55') && celular.length < 14) {
        alert('Celular Incorreto!');
        return;
      }
      hiddenInput.value = celular;
      let formData = $(this).serialize();

      $.ajax({
        url: '/api/cadastros',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
          $('#IDCadastro').val(response.IDCadastro);
          $('#simulacao-dados-lead').hide();
          $('#simulacao-dados').removeClass('d-none');
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Erro na requisição AJAX:', textStatus, errorThrown);
          console.error('Response details:', jqXHR.responseText);
          alert('Erro na requisição AJAX.');
        }
      });
    });


    $('#IDTipoCarta').change(async function() {
      let tipoCartaId = $(this).val();

      try {
        var creditos = await $.ajax({
          url: '/api/creditos/tipocarta/' + tipoCartaId,
          type: 'GET',
          contentType: 'json',
        });

        var prazos = await $.ajax({
          url: '/api/prazos/tipocarta/' + tipoCartaId,
          type: 'GET',
          contentType: 'json',
        });

        $('#Credito').empty();
        $.each(creditos, function(index, obj) {
          var valorFormatado = obj.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
          });
          $('#Credito').append('<option value="' + obj + '">' +
            valorFormatado + '</option>');
        });
        $('.select2').select2({
          placeholder: "Selecione os Créditos",
          width: '100%',
          closeOnSelect: false,
          maximumSelectionLength: 7,
          language: {
            maximumSelected: function() {
              return "O máximo de Créditos é 7";
            },
            noResults: function() {
              return "Nenhum resultado encontrado";
            }
          }
        });


        $('#Prazo').empty();
        $('#Prazo').append('<option value="" selected disabled>Selecione o Prazo</option>');
        $.each(prazos, function(index, obj) {
          $('#Prazo').append('<option value="' + obj + '">' + obj +
            ' meses</option>');
        });

        $('#simulacao2').removeClass('d-none');
      } catch (error) {
        console.error(error);
        alert('Houve um erro com esse tipo de carta, por favor tente outro!');
      }
    });

    $('#formSimulacao').submit(function(event) {
      event.preventDefault();
      let form = new FormData();
      $('#simulacao').addClass('d-none');

      var creditos = [];

      $('#Credito').select2('data').forEach(element => {
        creditos.push(element.id);
      });

      form.append('IDTipoCarta', $('#IDTipoCarta').val());
      form.append('Prazo', $('#Prazo').val());
      form.append('IDCadastro', $('#IDCadastro').val());
      form.append('ValorCredito', JSON.stringify(creditos));

      $.ajax({
        url: '/api/cartas/simulacao',
        type: 'POST',
        data: form,
        processData: false,
        contentType: false,
        success: function(data) {
          preencherTabela(data);
        },
        error: function(xhr, status, error) {
          alert('Houve um erro ao gerar a simulação!');
        }
      });
    });

    function preencherTabela(data) {
      $('#tableSimulacao tbody').empty();

      if (data.length === 0) {
        alert('Nenhuma carta encontrada, por favor, tente gerar com outras informações!')
        return;
      }

      data.forEach(function(item) {
        var valorCredito = item.ValorCredito.toLocaleString('pt-BR', {
          style: 'currency',
          currency: 'BRL'
        });

        var parcelaIntegral = parseFloat(item.ParcelaIntegral.replace('.', ',')).toLocaleString('pt-BR', {
          style: 'currency',
          currency: 'BRL'
        });

        if (item.ParcelaFlex == item.ParcelaIntegral) {
          var parcelaFlex = "";
        } else {
          var parcelaFlex = parseFloat(item.ParcelaFlex.replace('.', ',')).toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
          });
        }

        var row = $('<tr>').append(
          $('<td>').text(valorCredito),
          $('<td>').text(parcelaIntegral),
          $('<td>').text(parcelaFlex),
          $('<td>').append(
            $('<button>')
            .addClass('btn btn-info btn-quero-esse')
            .data('carta-valor', item.ValorCredito)
            .data('carta-integral', item.ParcelaIntegral)
            .data('carta-flex', item.ParcelaFlex)
            .data('carta-tipo', item.tipo_carta.Descricao)
            .data('carta-prazo', item.Prazo)
            .text('Quero esse!')
            .click(function() {
              var numeroVendedor = {{ $vendedor->Telefone }};
              var mensagemPadrao =
                "Olá, eu gostaria de reservar uma carta de " + $(this).data('carta-tipo') +
                "! Valor de crédito: " +
                $(this).data('carta-valor') +
                ", Parcela Flex: " + $(this).data('carta-flex') +
                ", Parcela Integral: " + $(this).data('carta-integral') +
                ", Prazo: " + $(this).data('carta-prazo') + " meses";

              mensagemPadrao = encodeURIComponent(mensagemPadrao);

              var linkWhatsApp = 'https://api.whatsapp.com/send?phone=' + numeroVendedor +
                '&text=' + mensagemPadrao;

              window.location.href = linkWhatsApp;
            })
          )
        );

        $('#tableSimulacao tbody').append(row);
      });
      $('#simulacao').removeClass('d-none');
    }
  </script>
@endsection
