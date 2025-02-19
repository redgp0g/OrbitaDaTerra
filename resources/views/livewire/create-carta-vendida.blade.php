<div class="container-xxl d-flex justify-content-center align-items-center" style="min-height: 95vh">
  <script src="{{ asset('node_modules/intl-tel-input/build/js/intlTelInputWithUtils.min.js') }}"></script>

  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">
      <div class="card">
        <div class="card-body">
          <form wire:submit.prevent="submit">
            @csrf
            <div class="row">
              <p class="text-danger">Campos com * são obrigatórios</p>

              <div class="form-group col-lg-2">
                <label class="form-label" for="IDEmpresaAdministradora">Administradora <span class="text-danger">*</span></label>
                <select class="form-control" id="IDEmpresaAdministradora" wire:model="IDEmpresaAdministradora" required>
                  <option value="" selected>Selecione a Administradora</option>
                  <option value="">Administradora Não Cadastrada</option>
                  @foreach ($administradoras as $administradora)
                    <option value="{{ $administradora->IDEmpresa }}">
                      {{ $administradora->NomeFantasia }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group col-lg-3 d-flex flex-column">
                <label class="form-label" for="Celular">Celular <span class="text-danger">*</span></label>
                <input class="form-control celular" id="Celular" type="tel" x-ref="input" x-init="iti = intlTelInput($refs.input, {
                    nationalMode: true,
                    initialCountry: 'br',
                    utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@23.3.0/build/js/utils.js'
                });
                $refs.input.addEventListener('change', function() {
                    const formattedNumber = iti.getNumber();
                    @this.set('Celular', formattedNumber);
                });" placeholder="Digite seu telefone"
                  wire:model.lazy="Celular" required />
                @if ($IDCadastroConsorciado)
                  <div class="text-success">Usuário encontrado!</div>
                @endif
              </div>

              @if (!$IDCadastroConsorciado)
                <div class="form-group col-lg-2">
                  <label class="form-label" for="Nome">Nome <span class="text-danger">*</span></label>
                  <div class="position-relative">
                    <input class="form-control" id="Nome" name="Nome" type="text" wire:model="Nome" placeholder="Nome" wire:loading.attr="disabled"
                      wire:loading.remove wire:target="Celular" required />
                    <div class="spinner-border spinner-border-sm position-absolute top-50 end-0 translate-middle-y" role="status" aria-hidden="true" wire:loading
                      wire:target="Celular">
                    </div>
                  </div>
                </div>
              @endif

              <input name="IDCadastroConsorciado" type="hidden" wire:model="IDCadastroConsorciado">

              <div class="form-group col-lg-3">
                <label class="form-label" for="IDTipoCarta">Tipo de Carta <span class="text-danger">*</span></label>
                <select class="form-control" id="IDTipoCarta" wire:model="IDTipoCarta" required>
                  <option value="">Selecione o Tipo de Carta</option>
                  @foreach ($tiposCartas as $tipoCarta)
                    <option value="{{ $tipoCarta->IDTipoCarta }}">{{ $tipoCarta->Descricao }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="form-group col-lg-2">
                <label class="form-label" for="ValorCredito">Valor do Crédito <span class="text-danger">*</span></label>
                <input class="form-control" id="ValorCredito" name="ValorCredito" data-type="currency" type="text" wire:model="ValorCredito" placeholder="R$"
                  required />
              </div>

              <div class="form-group col-lg-2">
                <label class="form-label" for="ValorPago">Valor Pago</label>
                <input class="form-control" id="ValorPago" name="ValorPago" data-type="currency" type="text" wire:model="ValorPago" placeholder="R$" />
              </div>

              <div class="form-group col-lg-4">
                <label class="form-label" for="ValorVenda">Valor de Venda Desejada <span class="text-danger">*</span></label>
                <input class="form-control" id="ValorVenda" name="ValorVenda" data-type="currency" type="text" wire:model="ValorVenda" placeholder="R$" required />
              </div>

              <div class="form-group col-lg-2">
                <label class="form-label" for="SaldoDevedor">Saldo Devedor</label>
                <input class="form-control" id="SaldoDevedor" name="SaldoDevedor" data-type="currency" type="text" wire:model="SaldoDevedor" placeholder="R$" />
              </div>

              <div class="form-group col-lg-2">
                <label class="form-label" for="ParcelasPagas">Parcelas Pagas</label>
                <input class="form-control" id="ParcelasPagas" name="ParcelasPagas" type="number" wire:model="ParcelasPagas" step="1" min="1"
                  max="600" />
              </div>

              <div class="form-group col-lg-2">
                <label class="form-label" for="ParcelasPagar">Parcelas a Pagar</label>
                <input class="form-control" id="ParcelasPagar" name="ParcelasPagar" type="number" wire:model="ParcelasPagar" step="1" min="1"
                  max="600" />
              </div>

              <div class="form-group col-lg-2">
                <label class="form-label" for="ValorParcela">Valor da Parcela <span class="text-danger">*</span></label>
                <input class="form-control" id="ValorParcela" name="ValorParcela" data-type="currency" type="text" wire:model="ValorParcela" placeholder="R$"
                  required />
              </div>

              <div class="form-group col-lg-2">
                <label class="form-label" for="DiaVencimento">Dia do Vencimento <span class="text-danger">*</span></label>
                <select class="form-control" id="DiaVencimento" name="DiaVencimento" wire:model="DiaVencimento" required>
                  <option value="" selected disabled>Selecione o dia</option>
                  @for ($i = 1; $i <= 31; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
              </div>

              <div class="form-group col-lg-2">
                <label class="form-label" for="ValorGarantia">Valor de Garantia</label>
                <input class="form-control" id="ValorGarantia" name="ValorGarantia" data-type="currency" type="text" wire:model="ValorGarantia"
                  placeholder="R$" />
              </div>

              <div class="form-group col-lg-2">
                <label class="form-label" for="Grupo">Grupo</label>
                <input class="form-control" id="Grupo" name="Grupo" type="text" wire:model="Grupo" placeholder="Grupo" />
              </div>

              <div class="form-group col-lg-2">
                <label class="form-label" for="Cota">Cota</label>
                <input class="form-control" id="Cota" name="Cota" type="text" wire:model="Cota" placeholder="Cota" required />
              </div>

              <div class="form-group col-lg-3">
                <label class="form-label" for="TaxaTransferencia">Valor de Transferência</label>
                <input class="form-control" id="TaxaTransferencia" name="TaxaTransferencia" data-type="currency" type="text" wire:model="TaxaTransferencia"
                  placeholder="R$"/>
              </div>

              <div class="form-group col-lg-2">
                <label class="form-label" for="Contemplada">Contemplada? <span class="text-danger">*</span></label>
                <div class="row">
                  <div>
                    <label for="contempladaSim">Sim</label>
                    <input id="contempladaSim" name="Contemplada" type="radio" value="1" wire:model="Contemplada">
                  </div>
                  <div>
                    <label for="contempladaNao">Não</label>
                    <input id="contempladaNao" name="Contemplada" type="radio" value="0" wire:model="Contemplada">
                  </div>
                </div>
              </div>

              <div class="form-group col-lg-12">
                <label class="form-label" for="ComissaoOrbita">Observacões</label>
                <textarea class="form-control" id="ComissaoOrbita" name="ComissaoOrbita" wire:model="ComissaoOrbita" rows="4"></textarea>
              </div>

              <div class="form-group col-lg-12">
                <button class="btn btn-success" type="submit">Cadastrar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
