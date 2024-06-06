<!-- resources/views/components/FaleComOVendedor.blade.php -->
<dialog id="dialogFaleVendedor" class="rounded rounded-4 border border-0 p-5" style="z-index: 100;">
    <button style="right: 10px; top:10px" class="position-absolute" id="fecharDialog" onclick="dialogFaleVendedor.close()"><i class="fa fa-times"></i></button>
    <h2 class="mb-2">Preencha para conversar com um Vendedor</h2>
    <h4 class="text-center text-danger fs-6">Os campos com * são obrigatórios</h4>
    <form id="enviarDados" method="post" action="{{ url('/enviardados') }}">
        <div class="mb-3">
            <label for="Nome" class="form-label">Nome <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="Nome" name="Nome" placeholder="Nome" autofocus required />
        </div>
        <div class="mb-3">
            <label for="celular" class="form-label">Celular <span class="text-danger">*</span></label>
            <input type="text" class="form-control celular" id="celular" name="Telefone" placeholder="Digite seu celular com DDD" maxlength="16" required pattern="\(\d{2}\) \d{5}-\d{4}" />
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control email" name="Email" placeholder="Digite seu e-mail" />
        </div>
        <input type="hidden" name="numerovendedor" id="numerovendedor" value="{{ $cadastro->Telefone }}">
        <button type="submit" id="btnCadastro" class="btn btn-primary d-grid w-100">Continuar</button>
    </form>
</dialog>

<button class="float fs-1" target="_blank" id="btnmodal" onclick="document.getElementById('dialogFaleVendedor').showModal()"><i class="fa fa-whatsapp px-2"></i></button>
