<div class="float d-flex align-items-end flex-column-reverse position-fixed bottom-0 end-0 m-5" style="z-index: 1100;">
  <input class="mt-3" type="checkbox" checked />
  <div class="buttonFloatMenu fs-1 d-flex justify-content-center align-items-center mt-3"><i class="fa fa-angle-up"></i>
  </div>
  <div class="floatMenu align-items-end flex-column gap-3">
    <button class="fs-1 rounded-circle rounded text-white" id="btnmodal" style="background-color: #25d366"
      onclick="document.getElementById('dialogFaleVendedor').showModal()"><i class="fa fa-whatsapp px-2"></i>
    </button>
    <button class="fs-5 rounded-pill rounded p-1 text-white" style="background-color: #1e9ef3"
      onclick="window.location.href = '/simulacao/{{ $cadastro->IDCadastro }}'">Simular Agora
    </button>
    <button class="fs-5 bg-success rounded-pill rounded p-1 px-2 text-white"
      onclick="window.location.href = '/carta-a-venda/8'">Venda sua Carta
    </button>
  </div>
</div>

<dialog class="rounded-4 rounded border p-5" id="dialogFaleVendedor" style="z-index: 100;">
  <span class="modal-close" onclick="dialogFaleVendedor.close()" x-on:click="showModal = false">&times;</span>
  <h2 class="mb-2">Preencha para conversar com um Vendedor</h2>
  <h4 class="text-danger fs-6 text-center">Os campos com * são obrigatórios</h4>
  <form id="enviarDados" method="POST">
    <div class="mb-3">
      <label class="form-label" for="Nome">Nome <span class="text-danger">*</span></label>
      <input class="form-control" id="Nome" name="Nome" type="text" placeholder="Nome" autofocus required />
    </div>
    <div class="d-flex flex-column mb-3">
      <label class="form-label" for="celular">Celular <span class="text-danger">*</span></label>
      <input class="form-control celular" id="celular" type="text" required />
    </div>
    <div class="mb-3">
      <label class="form-label" for="Email">E-mail</label>
      <input class="form-control email" id="Email" name="Email" type="email" placeholder="Digite seu e-mail" />
    </div>
    @if ($cadastro->TipoCadastro == 'Vendedor')
      <input name="IDCadastroVendedor" type="hidden" value="{{ $cadastro->IDCadastro }}">
    @else
      <input name="IDCadastroVendedor" type="hidden" value="{{ $cadastro->IDCadastroVendedorIndicado }}">
    @endif
    <input name="IDCadastroIndicador" type="hidden" value="{{ $cadastro->IDCadastro }}">
    <input name="TipoCadastro" type="hidden" value="Lead">
    <input name="Origem" type="hidden" value="Lead enviou os dados">
    <button class="btn btn-primary d-grid w-100" id="btnCadastro" type="submit">Continuar</button>
  </form>
</dialog>

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

  $("#enviarDados").submit(function(event) {
    event.preventDefault();
    let celular = iti.getNumber();
    if (celular.startsWith('+55') && celular.length < 14) {
      alert('Celular Incorreto!');
      return;
    }
    hiddenInput.value = celular;
    let formData = $(this).serialize();
    let telefoneVendedor = {{ $cadastro->Telefone }};
    $.ajax({
      url: '/api/cadastros',
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function(response) {
        window.location.href = 'https://wa.me/' + telefoneVendedor;
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('Erro na requisição AJAX:', textStatus, errorThrown);
        console.error('Response details:', jqXHR.responseText);
        alert('Erro na requisição AJAX.');
      }
    });
  });
</script>
