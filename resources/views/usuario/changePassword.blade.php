<div class="container-xxl d-flex justify-content-center align-items-center" style="height: 95vh">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <div class="card">
                <div class="card-body">
                    <div class="app-brand justify-content-center d-flex mb-3">
                        <img src="{{ asset('/images/logo.png') }}" height="110px">
                    </div>

                    <h4 class="mb-2">Redefinição De Senha 🔒</h4>

                    <form method="POST" action="{{ url('usuario/changePassword') }}">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="senha">Digite a Senha</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control form-control-lg" id="senha"
                                    name="senha" placeholder="Digite a nova senha" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="senhaConfirmacao">Senha de Confirmação</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control form-control-lg" id="senhaConfirmacao"
                                    name="senhaConfirmacao" placeholder="Repita a nova senha" required />
                                <input type="hidden" id="email" name="email" value="<?php echo $email; ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary d-grid w-100">Alterar Senha</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const senhaInput = document.getElementById('senha');
        const senhaConfirmacaoInput = document.getElementById('senhaConfirmacao');

        function validarSenhas() {
            const senhaValue = senhaInput.value;
            const senhaConfirmacaoValue = senhaConfirmacaoInput.value;

            if (senhaConfirmacaoValue !== '' && senhaValue !== senhaConfirmacaoValue) {
                senhaConfirmacaoInput.style.border = '2px solid red';
                senhaInput.style.border = '2px solid red';

                document.querySelector('form').addEventListener('submit', function(event) {
                    event.preventDefault();
                });
            } else if (senhaValue !== '' && senhaConfirmacaoValue !== '' && (senhaValue ==
                    senhaConfirmacaoValue)) {
                senhaConfirmacaoInput.style.border = '2px solid green';
                senhaInput.style.border = '2px solid green';
            } else {
                senhaConfirmacaoInput.style.border = '';
                senhaInput.style.border = '';
            }
        }

        senhaInput.addEventListener('focusout', validarSenhas);

        senhaConfirmacaoInput.addEventListener('focusout', validarSenhas);
    });
</script>
