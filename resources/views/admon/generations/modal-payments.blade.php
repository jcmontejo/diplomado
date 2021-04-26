<!-- Modal -->
<div class="modal fade" id="modalListPayments" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    style="overflow:hidden;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalListPaymentsLabel">Lista de pagos del alumno <span
                        id="STUDENT_NAME"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="ID_INSCRIPTION" name="ID_INSCRIPTION">
                <div class="row">
                    <div class="col-md-6">
                        <div id="list-payments">
                            <a href="#" class="btn btn-rounded btn-secondary mb-3 float-right" id="createDiplomat"><i
                                    class="fas fa-plus"></i> Agregar Pago</a>
                            <div class="table-responsive">
                                <table class="table display" id="PAYMENTS">
                                    <thead>
                                        <th>Descripción</th>
                                        <th>Estatus</th>
                                        <th></th>
                                        <th></th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="APPLY_PAYMENT" style="display: none;">
                            @php
                                $types = App\AccountType::all();
                                $paymentMethods = App\PaymentMethod::all();
                                $accounts = App\Account::all();
                            @endphp
                            <div class="container">
                                <button type="button" class="btn btn-danger" onclick="closeFormPayment();"><i class="fas fa-times-circle"></i></button> Pago número <span id="number"></span>
                                <input type="hidden" id="ID_PAYMENT">
                                <input type="hidden" id="ID_INS">
                                <h3>Deuda total: <span id="total_debt"></span></h3>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Fecha</label>
                                    <input type="date" class="form-control" id="date_payment_alt"
                                        value="{{ \Carbon\Carbon::now()->toDateString() }}">
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput2">Método de pago</label>
                                    <select name="paymentMethod" id="payment_method" class="form-control">
                                        @forelse ($paymentMethods as $paymentMethod)
                                            <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                        @empty
                                            <option value="0">No existen metodos de pago registrados.</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Cuenta destino</label>
                                    <select name="account" id="destination_account" class="form-control">
                                        @forelse ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                                        @empty
                                            <option value="0">No existen bancos registrados.</option>
                                        @endforelse
                                    </select>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput">Tipo de cuota</label>
                                        <select name="account" id="account_type" class="form-control">
                                            @forelse ($types as $type)
                                                @if ($type->id === 2)
                                                    <option value="{{ $type->id }}">{{ $type->account_type }}</option>
                                                @endif
                                            @empty
                                                <option>No hay tipos de cuotas registradas.</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="formGroupExampleInput">Ingrese monto *</label>
                                        <input type="number" min="1" step="any" class="form-control" id="amount_alt">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success btn-block btn-lg" onclick="storePayment();"><i class="fas fa-check"></i>
                                            Aplicar Pago</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="APPLY_AGREEMENT" style="display: none;">
                          <form>
                            <button type="button" class="btn btn-danger" onclick="closeFormAgreement();"><i class="fas fa-times-circle"></i></button> Pago número <span id="number"></span>
                            <h3>Deuda total: <span id="total_debt"></span></h3>
                            <input type="hidden" id="convenio_debt_id">
                            <input type="hidden" id="convenio_num_pay">
                            <input type="hidden" id="convenio_total_debt">
                            <div class="form-group">
                              <label for="exampleInputPassword1">Fecha de Pago</label>
                              <input type="date" class="form-control" id="fechaConvenio" name="fechaConvenio">
                          </div>
                          <div class="form-group">
                              <label for="exampleInputPassword1">Monto de Pago</label>
                              <input type="number" min="1" name="montoConvenio" id="montoConvenio" class="form-control">
                          </div>
                            <div class="form-group">
                              <button type="button" class="btn btn-success btn-block btn-lg" onclick="storePayment();"><i class="fas fa-check"></i>
                                  Aplicar Convenio</button>
                          </div>
                        </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-block btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
