@extends('dashboard')
@section('pagina')
    <div class="col-16">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ url('/dashboard/storeCartaVendida') }}">
                    @csrf
                    <div class="row">
                        <p class="text-danger">Campos com * são obrigatórios</p>
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="IDEmpresaAdministradora">Administradora <span class="text-danger">*</span></label>
                            <select class="form-control" name="IDEmpresaAdministradora" id="IDEmpresaAdministradora"
                                required>
                                <option value="" selected disabled>Selecione a Administradora</option>
                                @foreach ($administradoras as $administradora)
                                    <option value="{{ $administradora->IDEmpresa }}">{{ $administradora->NomeFantasia }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="IDEmpresaAutorizada">Autorizada <span class="text-danger">*</span></label>
                            <select class="form-control" name="IDEmpresaAutorizada" id="IDEmpresaAutorizada" required>
                                <option value="" selected disabled>Selecione a Autorizada</option>
                                @foreach ($autorizadas as $autorizada)
                                    <option value="{{ $autorizada->IDEmpresa }}">{{ $autorizada->NomeFantasia }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label class="form-label" for="IDCadastroConsorciado">Consorciado</label>
                            <select class="form-control" name="IDCadastroConsorciado" id="IDCadastroConsorciado" required>
                                <option value="" selected disabled>Selecione o Consorciado</option>
                                @foreach ($cadastros as $cadastro)
                                    <option value="{{ $cadastro->IDCadastro }}">{{ $cadastro->Nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label class="form-label" for="IDTipoCarta">Tipo de Carta <span class="text-danger">*</span></label>
                            <select class="form-control " id="IDTipoCarta" name="IDTipoCarta" required>
                                <option value="">Selecione o Tipo de Carta</option>
                                @foreach ($tiposCartas as $tipoCarta)
                                    <option value="{{ $tipoCarta->IDTipoCarta }}">{{ $tipoCarta->Descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="ValorCredito">Valor do Crédito <span class="text-danger">*</span></label>
                            <input type="text" id="ValorCredito" name="ValorCredito" class="form-control" data-type="currency" placeholder="R$1.000,00" required/>
                        </div>
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="ValorPago">Valor Pago <span class="text-danger">*</span></label>
                            <input type="text" id="ValorPago" name="ValorPago" class="form-control"
                            data-type="currency" placeholder="R$1.000,00" required />

                        </div>
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="ValorVenda">Valor de Venda <span class="text-danger">*</span></label>
                            <input type="text" id="ValorVenda" name="ValorVenda" class="form-control"
                            data-type="currency" placeholder="R$1.000,00" required />
                        </div>
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="SaldoDevedor">Saldo Devedor <span class="text-danger">*</span></label>
                            <input type="text" name="SaldoDevedor" id="SaldoDevedor" class="form-control"
                            data-type="currency" placeholder="R$1.000,00" required />
                        </div>
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="ParcelasPagas">Parcelas Pagas <span class="text-danger">*</span></label>
                            <input type="number" id="ParcelasPagas" name="ParcelasPagas" step="1" min="1"
                                max="600" class="form-control" placeholder="Parcelas Pagas" required>
                        </div>
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="ParcelasPagar">Parcelas a Pagar <span class="text-danger">*</span></label>
                            <input type="number" id="ParcelasPagar" name="ParcelasPagar" step="1" min="1"
                                max="600" class="form-control" placeholder="Parcelas a Pagar">
                        </div>
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="ValorParcela">Valor Parcela <span class="text-danger">*</span></label>
                            <input type="text" id="ValorParcela" name="ValorParcela" class="form-control"
                            data-type="currency" placeholder="R$1.000,00" required />

                        </div>
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="DiaVencimento">Dia do Vencimento <span class="text-danger">*</span></label>
                            <select id="DiaVencimento" name="DiaVencimento" class="form-control" required>
                                <option value="" selected disabled>Selecione o dia</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                                <select>
                        </div>
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="ValorGarantia">Valor de Garantia</label>
                            <input type="text" id="ValorGarantia" name="ValorGarantia" class="form-control"
                            data-type="currency" placeholder="R$1.000,00" />
                        </div>
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="Grupo">Grupo <span class="text-danger">*</span></label>
                            <input type="text" id="Grupo" name="Grupo" class="form-control"
                                placeholder="Grupo" required>
                        </div>
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="Cota">Cota <span class="text-danger">*</span></label>
                            <input type="text" id="Cota" name="Cota" class="form-control" placeholder="Cota"
                                required>
                        </div>
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="TaxaTransferencia">Taxa de Transferência <span class="text-danger">*</span></label>
                            <input type="text" id="TaxaTransferencia" name="TaxaTransferencia" class="form-control"
                            data-type="currency" placeholder="R$1.000,00" required>
                        </div>
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="Contemplada">Contemplada? <span class="text-danger">*</span></label>
                            <div class="row">
                                <div>
                                    <label for="taxaTransferenciaSim">Sim</label>
                                    <input type="radio" id="contempladaSim" name="Contemplada" value="1">
                                </div>
                                <div>
                                    <label for="taxaTransferenciaNão">Não</label>
                                    <input type="radio" id="contempladaNão" name="Contemplada" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <input type="hidden" name="Status" value="Cadastrada"/>
                            <button type="submit" class="btn btn-success">Cadastrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
