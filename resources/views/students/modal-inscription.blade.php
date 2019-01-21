<div class="modal fade" id="modalInscription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inscribir Alumno</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <div id='message-error' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error"></strong>
                    </div>
                    <form id="form">
                        <input type="hidden" name="id-student" id="id-student">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Nombre</label>
                                <input type="text" class="form-control form-control-lg" id="nameInscription" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Apellido Paterno</label>
                                <input type="text" class="form-control form-control-lg" id="lastnameInscription"
                                    readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Apellido Materno</label>
                                <input type="text" class="form-control form-control-lg" id="motherlastnameInscription"
                                    readonly>
                            </div>
                            <div class="form-group col-md-8">
                                <input type="hidden" id="id">
                                <label for="exampleInputEmail1">Selecciona Diplomado</label>
                                <select name="diplomat_id" id="diplomat_id" class="form-control form-control-lg">
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
                                <select name="generation_id" id="generation_id" class="form-control form-control-lg">
                                    <option value="">--- Selecciona Diplomado Antes---</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Descuento</label>
                                <select name="discount" id="discount" class="form-control form-control-lg">
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
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Número de Pagos</label>
                                <select name="number_payments" id="number_payments" class="form-control form-control-lg">
                                    <option>--Selecciona--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">¿De cuanto seran los pagos?</label>
                                <input type="text" name="amount_of_payments" id="amount_of_payments" class="form-control form-control-lg">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Monto Primer Pago</label>
                                <input type="number" name="first_payment" id="first_payment" class="form-control form-control-lg">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Periodicidad</label>
                                <select name="periodicity" id="periodicity" class="form-control form-control-lg">
                                    <option value="QUINCENAL">PAGOS QUINCENALES</option>
                                    <option value="MENSUAL">PAGOS MENSUALES</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Cuenta Receptora</label>
                                <select name="accountDestination" id="accountDestination" class="form-control form-control-lg">
                                    @forelse ($accounts as $account)
                                    <option value="{{$account->id}}">{{$account->account_name}}</option>
                                    @empty
                                    <option>NO HAY CUENTAS REGISTRADAS</option>
                                    @endforelse
                                </select>
                            </div>
                             <div class="form-group col-md-4">
                                <label for="">Tipo de Cuota</label>
                                <select name="account_type" id="account_type" class="form-control form-control-lg">
                                    @forelse ($account_types as $type)
                                    <option value="{{$type->id}}">{{$type->account_type}}</option>
                                    @empty
                                    <option>NO HAY TIPOS DE CUOTAS REGISTRADAS</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Método de Pago</label>
                                <select name="payment_method" id="payment_method" class="form-control form-control-lg">
                                    @forelse ($methods as $method)
                                    <option value="{{$method->id}}">{{$method->name}}</option>
                                    @empty
                                    <option>NO HAY CUENTAS REGISTRADAS</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Tipo de Inscripción</label>
                                <select name="type_of_inscription" id="type_of_inscription" class="form-control form-control-lg">
                                    <option value="NUEVO">NUEVO</option>
                                    <option value="RECURSADOR">RECURSADOR</option>
                                    <option value="EX-ALUMNO">EX-ALUMNO</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Comentarios</label>
                                <textarea name="comments" id="comments" cols="30" rows="5" class="form-control"></textarea>
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
