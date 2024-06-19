@extends('dashboard')
@section('pagina')
    <div class="col-16">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="">
                    <div class="row">
                        <div class="form-group col-lg-2">
                            <label class="form-label" for="IDEmpresaAdministradora">Administradora</label>
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
                            <label class="form-label" for="IDEmpresaAutorizada">Autorizada</label>
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
                            <label class="form-label" for="IDCadastroVendedor">Vendedor</label>
                            <select class="form-control" name="IDCadastroVendedor" id="IDCadastroVendedor" required>
                                <option value="" selected disabled>Selecione o Vendedor</option>
                                @foreach ($cadastros as $cadastro)
                                    <option value="{{ $cadastro->IDCadastro }}">{{ $cadastro->Nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label class="form-label" for="Status">Status</label>
                            <select class="form-control" name="Status" id="Status" required>
                                <option value="" selected disabled>Selecione o Status</option>
                                <option value="Cadastrada">Cadastrada</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label class="form-label" for="IDTipoCarta">Tipo de Carta</label>
                            <select class="form-control " id="IDTipoCarta" name="IDTipoCarta" required>
                                <option value="">Selecione o Tipo de Carta</option>
                                @foreach ($tiposCartas as $tipoCarta)
                                    <option value="{{ $tipoCarta->IDTipoCarta }}">{{ $tipoCarta->Descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label class="form-label" for="ValorCredito">Valor do Crédito</label>
                            <input type="text" id="ValorCredito" name="ValorCredito" class="form-control"
                                placeholder="Valor do Crédito" required />
                        </div>
                        <div class="form-group col-lg-3">
                            <label class="form-label" for="ValorPago">Valor Pago</label>
                            <input type="text" id="ValorPago" name="ValorPago" class="form-control"
                                placeholder="Valor Pago" required />

                        </div>
                        <div class="form-group col-lg-3">
                            <label class="form-label" for="ValorVenda">Valor de Venda</label>
                            <input type="text" id="ValorVenda" name="ValorVenda" class="form-control"
                                placeholder="Valor de Venda" required />
                        </div>
                        <div class="form-group col-lg-3">
                            <label class="form-label" for="SaldoDevedor">Saldo Devedor</label>
                            <input type="text" name="SaldoDevedor" id="SaldoDevedor" class="form-control"
                                placeholder="Saldo Devedor" required />
                        </div>
                        <div class="form-group col-lg-3">
                            <label class="form-label" for="ParcelasPagas">Parcelas Pagas</label>
                            <input type="number" id="ParcelasPagas" name="ParcelasPagas" step="1" min="1"
                                max="600" class="form-control" placeholder="Parcelas Pagas" required>
                        </div>
                        <div class="form-group col-lg-3">
                            <label class="form-label" for="ParcelasPagar">Parcelas a Pagar</label>
                            <input type="number" id="ParcelasPagar" name="ParcelasPagar" step="1" min="1"
                                max="600" class="form-control" placeholder="Parcelas a Pagar">
                        </div>
                        <div class="form-group col-lg-3">
                            <label class="form-label" for="ValorParcela">Valor Parcela</label>
                            <input type="text" id="ValorParcela" name="ValorParcela" class="form-control"
                                placeholder="Valor Parcela" required />

                        </div>
                        <div class="form-group col-lg-3">
                            <label class="form-label" for="DiaVencimento">Dia do Vencimento</label>
                            <select id="DiaVencimento" name="DiaVencimento" class="form-control" required>
                                <option value="" selected disabled>Selecione o dia</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                                <select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label class="form-label" for="ValorGarantia">Valor de Garantia</label>
                            <input type="text" id="ValorGarantia" name="ValorGarantia" class="form-control"
                                placeholder="Valor de Garantia" required />
                        </div>
                        <div class="form-group col-lg-3">
                            <label class="form-label" for="Grupo">Grupo</label>
                            <input type="text" id="Grupo" name="Grupo" class="form-control"
                                placeholder="Grupo" required>
                        </div>
                        <div class="form-group col-lg-3">
                            <label class="form-label" for="Cota">Cota</label>
                            <input type="text" id="Cota" name="Cota" class="form-control" placeholder="Cota"
                                required>
                        </div>
                        <div class="form-group col-lg-3">
                            <label class="form-label" for="taxaTransferencia">Taxa de Transferência</label>
                            <input type="text" id="taxaTransferencia" name="taxaTransferencia" class="form-control"
                                placeholder="Taxa de Transferência" required>
                        </div>
                        <div class="form-group col-lg-3">
                            <label class="form-label" for="taxaTransferencia">Contemplada?</label>
                            <div class="row">
                                <div>
                                    <label for="taxaTransferenciaSim">Sim</label>
                                    <input type="radio" id="taxaTransferenciaSim" name="taxaTransferencia" value="1">
                                </div>
                                <div>
                                    <label for="taxaTransferenciaNão">Não</label>
                                    <input type="radio" id="taxaTransferenciaNão" name="taxaTransferencia" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <button type="submit" class="btn btn-success">Cadastrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
