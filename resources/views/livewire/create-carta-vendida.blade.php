<div class="container-xxl d-flex justify-content-center align-items-center" style="height: 95vh">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        @csrf
                        <div class="row">
                            <p class="text-danger">Campos com * são obrigatórios</p>

                            <!-- Administradora -->
                            <div class="form-group col-lg-2">
                                <label class="form-label" for="IDEmpresaAdministradora">Administradora <span
                                        class="text-danger">*</span></label>
                                <select wire:model="IDEmpresaAdministradora" class="form-control"
                                    id="IDEmpresaAdministradora" required>
                                    <option value="" selected>Selecione a Administradora</option>
                                    <option value="">Administradora Não Cadastrada</option>
                                    @foreach ($administradoras as $administradora)
                                        <option value="{{ $administradora->IDEmpresa }}">
                                            {{ $administradora->NomeFantasia }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-lg-3">
                                <label class="form-label" for="Celular">Celular <span
                                        class="text-danger">*</span></label>
                                <input x-ref="input" x-init="iti = intlTelInput($refs.input, {
                                    nationalMode: true,
                                    initialCountry: 'br',
                                    utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@23.3.0/build/js/utils.js'
                                });
                                $refs.input.addEventListener('change', function() {
                                    const formattedNumber = iti.getNumber();
                                    @this.set('Celular', formattedNumber);
                                });" type="tel" id="Celular"
                                    class="form-control celular" placeholder="Digite seu telefone"
                                    wire:model.lazy="Celular" required />
                                @if ($IDCadastroConsorciado)
                                    <div class="text-success">Usuário encontrado!</div>
                                @endif
                            </div>

                            @if (!$IDCadastroConsorciado)
                                <div class="form-group col-lg-2">
                                    <label class="form-label" for="Nome">Nome <span
                                            class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input type="text" id="Nome" name="Nome" class="form-control"
                                            wire:model="Nome" placeholder="Nome" wire:loading.attr="disabled"
                                            wire:loading.remove wire:target="Celular" required />
                                        <div wire:loading wire:target="Celular"
                                            class="spinner-border spinner-border-sm position-absolute top-50 end-0 translate-middle-y"
                                            role="status" aria-hidden="true"></div>
                                    </div>
                                </div>
                            @endif

                            <!-- Campo hidden para o ID do Cadastro -->
                            <input type="hidden" name="IDCadastroConsorciado" wire:model="IDCadastroConsorciado">

                            <div class="form-group col-lg-3">
                                <label class="form-label" for="IDTipoCarta">Tipo de Carta <span
                                        class="text-danger">*</span></label>
                                <select wire:model="IDTipoCarta" class="form-control" id="IDTipoCarta" required>
                                    <option value="">Selecione o Tipo de Carta</option>
                                    @foreach ($tiposCartas as $tipoCarta)
                                        <option value="{{ $tipoCarta->IDTipoCarta }}">{{ $tipoCarta->Descricao }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-2">
                                <label class="form-label" for="ValorCredito">Valor do Crédito <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="ValorCredito" name="ValorCredito" class="form-control"
                                    data-type="currency" wire:model="ValorCredito" placeholder="R$" required />
                            </div>

                            <div class="form-group col-lg-2">
                                <label class="form-label" for="ValorPago">Valor Pago</label>
                                <input type="text" id="ValorPago" name="ValorPago" class="form-control"
                                    data-type="currency" wire:model="ValorPago" placeholder="R$" />
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="form-label" for="ValorVenda">Valor de Venda Desejada <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="ValorVenda" name="ValorVenda" data-type="currency"
                                    class="form-control" wire:model="ValorVenda" placeholder="R$" required />
                            </div>

                            <div class="form-group col-lg-2">
                                <label class="form-label" for="SaldoDevedor">Saldo Devedor</label>
                                <input type="text" id="SaldoDevedor" name="SaldoDevedor" class="form-control"
                                    data-type="currency" wire:model="SaldoDevedor" placeholder="R$" />
                            </div>

                            <div class="form-group col-lg-2">
                                <label class="form-label" for="ParcelasPagas">Parcelas Pagas <span
                                        class="text-danger">*</span></label>
                                <input type="number" id="ParcelasPagas" name="ParcelasPagas" class="form-control"
                                    wire:model="ParcelasPagas" step="1" min="1" max="600"
                                    required />
                            </div>

                            <div class="form-group col-lg-2">
                                <label class="form-label" for="ParcelasPagar">Parcelas a Pagar <span
                                        class="text-danger">*</span></label>
                                <input type="number" id="ParcelasPagar" name="ParcelasPagar" class="form-control"
                                    wire:model="ParcelasPagar" step="1" min="1" max="600" />
                            </div>

                            <div class="form-group col-lg-2">
                                <label class="form-label" for="ValorParcela">Valor da Parcela <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="ValorParcela" name="ValorParcela" class="form-control"
                                    data-type="currency" wire:model="ValorParcela" placeholder="R$" required />
                            </div>

                            <div class="form-group col-lg-2">
                                <label class="form-label" for="DiaVencimento">Dia do Vencimento <span
                                        class="text-danger">*</span></label>
                                <select id="DiaVencimento" name="DiaVencimento" class="form-control"
                                    wire:model="DiaVencimento" required>
                                    <option value="" selected disabled>Selecione o dia</option>
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group col-lg-2">
                                <label class="form-label" for="ValorGarantia">Valor de Garantia</label>
                                <input type="text" id="ValorGarantia" name="ValorGarantia" class="form-control"
                                    data-type="currency" wire:model="ValorGarantia" placeholder="R$" />
                            </div>

                            <div class="form-group col-lg-2">
                                <label class="form-label" for="Grupo">Grupo <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="Grupo" name="Grupo" class="form-control"
                                    wire:model="Grupo" placeholder="Grupo" required />
                            </div>

                            <div class="form-group col-lg-2">
                                <label class="form-label" for="Cota">Cota <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="Cota" name="Cota" class="form-control"
                                    wire:model="Cota" placeholder="Cota" required />
                            </div>

                            <div class="form-group col-lg-3">
                                <label class="form-label" for="TaxaTransferencia">Valor de Transferência <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="TaxaTransferencia" name="TaxaTransferencia"
                                    data-type="currency" class="form-control" wire:model="TaxaTransferencia"
                                    placeholder="R$" required />
                            </div>

                            <div class="form-group col-lg-2">
                                <label class="form-label" for="Contemplada">Contemplada? <span
                                        class="text-danger">*</span></label>
                                <div class="row">
                                    <div>
                                        <label for="contempladaSim">Sim</label>
                                        <input type="radio" id="contempladaSim" name="Contemplada" value="1"
                                            wire:model="Contemplada">
                                    </div>
                                    <div>
                                        <label for="contempladaNao">Não</label>
                                        <input type="radio" id="contempladaNao" name="Contemplada" value="0"
                                            wire:model="Contemplada">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-lg-12">
                                <label class="form-label" for="ComissaoOrbita">Observacões</label>
                                <textarea id="ComissaoOrbita" name="ComissaoOrbita" class="form-control" wire:model="ComissaoOrbita"
                                    rows="4"></textarea>
                            </div>

                            <div class="form-group col-lg-12">
                                <button type="submit" class="btn btn-success">Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
