<div class="modal fade" id="modalInscription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inscribir Alumno...s.</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div id='message-error' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error"></strong>
                    </div>
                    <form id="form">
                        <input type="hidden" name="id-student-alt" id="id-student-alt">
                        <div class="form-row">
                            {{-- <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">PRECIO VENTA</label>
                                <input style="font-size:20px;" type="number" value="0" min="0" max="12" id="price_sale" class="form-control number">
                            </div> --}}
                            <div class="form-group col-md-8">
                                <input type="hidden" id="id">
                                <label for="exampleInputEmail1">Selecciona Diplomado</label>
                                <select name="diplomat_id-alt" id="diplomat_id-alt" class="form-control form-control-lg">
                                    <option value="">--- Selecciona Diplomado ---</option>
                                    @forelse ($diplomats as $diplomat)
                                    <option value="{{$diplomat->id}}">{{$diplomat->name}}</option>
                                    @empty
                                    <option value="0">No hay diplomados registrados.</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Selecciona Generación</label>
                                <select name="generation_id-alt" id="generation_id-alt" class="form-control form-control-lg">
                                    <option value="">--- Selecciona Diplomado Antes---</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Descuento</label>
                                <input type="number" value="0" min="1" step="1" id="discount-alt" name="discount-alt" class="form-control form-control-lg">
                                {{-- <select name="discount" id="discount" class="form-control form-control-lg">
                                    <option value="0">--Selecciona--</option>
                                    <option value="0">0</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="300">300</option>
                                    <option value="400">400</option>
                                    <option value="500">500</option>
                                    <option value="600">600</option>
                                    <option value="700">700</option>
                                    <option value="800">800</option>
                                    <option value="900">900</option>
                                    <option value="1000">1000</option>
                                </select> --}}
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Número de Pagos</label>
                                <input type="number" value="1" min="1" max="10" step="1" id="number_payments-alt" name="number_payments-alt" class="form-control form-control-lg">
                                {{-- <select name="number_payments" id="number_payments" class="form-control form-control-lg">
                                    <option>--Selecciona--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select> --}}
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">¿De cuanto seran los pagos?</label>
                                <input type="text" name="amount_of_payments-alt" id="amount_of_payments-alt" class="form-control form-control-lg">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Monto Primer Pago</label>
                                <input type="number" value="0" min="0" name="first_payment-alt" id="first_payment-alt" class="form-control form-control-lg">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Periodicidad</label>
                                <select name="periodicity-alt" id="periodicity-alt" class="form-control form-control-lg">
                                    <option value="QUINCENAL">PAGOS QUINCENALES</option>
                                    <option value="MENSUAL">PAGOS MENSUALES</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Cuenta Receptora</label>
                                <select name="accountDestination-alt" id="accountDestination-alt" class="form-control form-control-lg">
                                    @forelse ($accounts as $account)
                                    <option value="{{$account->id}}">{{$account->account_name}}</option>
                                    @empty
                                    <option>NO HAY CUENTAS REGISTRADAS</option>
                                    @endforelse
                                </select>
                            </div>
                             <div class="form-group col-md-4">
                                <label for="">Tipo de Cuota</label>
                                <select name="account_type-alt" id="account_type-alt" class="form-control form-control-lg">
                                    @forelse ($account_types as $type)
                                    <option value="{{$type->id}}">{{$type->account_type}}</option>
                                    @empty
                                    <option>NO HAY TIPOS DE CUOTAS REGISTRADAS</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Método de Pago</label>
                                <select name="payment_method-alt" id="payment_method-alt" class="form-control form-control-lg">
                                    @forelse ($methods as $method)
                                    <option value="{{$method->id}}">{{$method->name}}</option>
                                    @empty
                                    <option>NO HAY CUENTAS REGISTRADAS</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Tipo de Inscripción</label>
                                <select name="type_of_inscription-alt" id="type_of_inscription-alt" class="form-control form-control-lg">
                                    <option value="NUEVO">NUEVO</option>
                                    <option value="RECURSADOR">RECURSADOR</option>
                                    <option value="EX-ALUMNO">EX-ALUMNO</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Comentarios</label>
                                <textarea name="comments-alt" id="comments-alt" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="processInscription" class="btn btn-primary mt-4 pr-4 pl-4" name="processInscription">Inscribir</a>
            </div>
        </div>
    </div>
</div>
