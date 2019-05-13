<!-- The Modal -->
<div class="modal" id="modalPay">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Procesar Pago</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            @php
            $types = App\AccountType::all();
            $paymentMethods = App\PaymentMethod::all();
            $accounts = App\Account::all();
            @endphp
            <!-- Modal body -->
            <div class="modal-body">
                <form>
                    <input type="hidden" id="debt_id">
                    <input type="hidden" id="num_pay">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputPassword1">Fecha de Pago</label>
                            <input type="date" class="form-control" id="date_payment">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="exampleInputPassword1">Observaciones</label>
                            <select name="observation" id="observation" class="form-control form-control-lg">
                                <option value="PAGO PARCIAL DE DIPLOMADO">PAGO PARCIAL DE DIPLOMADO</option>
                                <option value="PAGO TOTAL DE DIPLOMADO">PAGO TOTAL DE DIPLOMADO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Método de Pago</label>
                            <select name="paymentMethod" id="payment_method" class="form-control">
                                @forelse ($paymentMethods as $paymentMethod)
                                <option value="{{$paymentMethod->id}}">{{$paymentMethod->name}}</option>
                                @empty
                                <option value="0">No existen metodos de pago registrados.</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Cuenta Destino</label>
                            <select name="account" id="destination_account" class="form-control">
                                @forelse ($accounts as $account)
                                <option value="{{$account->id}}">{{$account->account_name}}</option>
                                @empty
                                <option value="0">No existen cuentas registradas.</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <table class="table">
                                        <thead style="background:#dce9f9;">
                                            <th>Tipo de Cuota</th>
                                            <th style="text-align:left">Monto $</th>
                                        </thead>
                                        <tbody id="invoice">
                                            <tr>
                                                <td width="40%">
                                                    <select name='account_type' id="account_type"
                                                        class='form-control form-control-lg'>
                                                        @forelse ($types as $type)
                                                        <option value="{{$type->id}}">{{$type->account_type}}</option>
                                                        @empty
                                                        <option>No hay tipos de cuotas registradas.</option>
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="amount form-control form-control-lg"
                                                        name="amount" id="amount" value="0" required>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-power-off"></i> Cancelar</button>
                <button type="button" class="btn btn-success" id="processPay"><i class="fa fa-thumbs-up"></i> Procesar Pago</button>
            </div>
        </div>
    </div>
</div>
