<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Alumno</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert'
                        style="display: none">
                        <strong id="error-save"></strong>
                    </div>
                    <form id="formStudent" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">CURP</label>
                                <input type="text" onkeyup="checkCurp(this)" class="form-control form-control-lg"
                                    id="curpSave" placeholder="Introduce CURP del alumno">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Nombre</label>
                                <input type="text" class="form-control form-control-lg" id="nameSave"
                                    placeholder="Introduce nombre del alumno">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Apellido Paterno</label>
                                <input type="text" class="form-control form-control-lg" id="lastnameSave"
                                    placeholder="Introduce apellido paterno">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Apellido Materno</label>
                                <input type="text" class="form-control form-control-lg" id="motherlastnameSave"
                                    placeholder="Introduce apellido materno">
                            </div>
                            <div class="form-group col-md-8">
                                <label for="exampleInputPassword1">Facebook</label>
                                <input type="text" class="form-control form-control-lg" id="facebookSave"
                                    placeholder="Introduce Facebook">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Fecha de Nacimiento</label>
                                <input type="date" class="form-control form-control-lg" id="birthdateSave"
                                    placeholder="Introduce fecha de nacimiento">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Genero</label>
                                <select name="sexSave" id="sexSave" class="form-control form-control-lg">
                                    <option value="H">Hombre</option>
                                    <option value="M">Mujer</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Teléfono de Contacto</label>
                                <input type="text" class="form-control form-control-lg" id="phoneSave"
                                    placeholder="Introduce teléfono de contacto">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Dirección</label>
                                <input type="text" class="form-control form-control-lg" id="addressSave"
                                    placeholder="Introduce dirección de alumno">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Estado</label>
                                <select name="stateSave" id="stateSave" class="form-control form-control-lg">

                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Ciudad</label>
                                <select name="citySave" id="citySave" class="form-control form-control-lg">

                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Correo Electrónico</label>
                                <input type="email" class="form-control form-control-lg" id="emailSave"
                                    placeholder="EJ. maria@alumno.com">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Profesión</label>
                                <select name="professionSave" id="professionSave" class="form-control form-control-lg">
                                    <option value="null">--Selecciona una profesión--</option>
                                    <option>Lic. en psicología </option>
                                    <option>Estudiante de psicología </option>
                                    <option>Terapeuta (cualquier corriente de formación)</option>
                                    <option>Lic. en pedagogía</option>
                                    <option>Lic. educación preescolar</option>
                                    <option>Maestro/a o docente</option>
                                    <option>Lic. en administración educativa</option>
                                    <option>Terapeuta ocupacional</option>
                                    <option>Terapeuta físico</option>
                                    <option>Educación especial</option>
                                    <option>Médico en Rehabilitación</option>
                                    <option>Lic en desarrollo Humano</option>
                                    <option>Lic en trabajo social</option>
                                    <option>Lic. en educación física</option>
                                    <option>Abogado</option>
                                    <option>Sociólogo</option>
                                    <option>Maestra sombra</option>
                                    <option>Equinoterapeuta</option>
                                    <option>Psicoanalista</option>
                                    <option>Médico pediatra</option>
                                    <option>Médico Familiar</option>
                                    <option>Psiquiatra</option>
                                    <option>Paidopsiquiatra</option>
                                    <option>Neurólogo</option>
                                    <option>Neurólogo infantil</option>
                                    <option>Enfermera con especialidad psiquiátrica</option>
                                    <option>Trabajador social con especialidad psiquiátrica</option>
                                    <option>Médico general</option>
                                    <option>Enfermera general</option>
                                    <option>Otro</option>
                                </select>
                            </div>
                            <div style="display:none;">
                                <input type="hidden" name="id-student" id="id-student">
                                <div class="form-row">
                                    {{-- <div class="form-group col-md-12">
                                            <label for="exampleInputEmail1">PRECIO VENTA</label>
                                            <input style="font-size:20px;" type="number" value="0" min="0" max="12" id="price_sale" class="form-control number">
                                        </div> --}}
                                    <div class="form-group col-md-8">
                                        <input type="hidden" id="id">
                                        <label for="exampleInputEmail1">Selecciona Diplomado</label>
                                        <select name="diplomat_id" id="diplomat_id"
                                            class="form-control form-control-lg">
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
                                        <select name="generation_id" id="generation_id"
                                            class="form-control form-control-lg">
                                            <option value="">--- Selecciona Diplomado Antes---</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Descuento</label>
                                        <input type="number" value="0" min="1" step="1" id="discount" name="discount"
                                            class="form-control form-control-lg">
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
                                        <input type="number" value="1" min="1" max="10" step="1" id="number_payments"
                                            name="number_payments" class="form-control form-control-lg">
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
                                        <input type="text" name="amount_of_payments" id="amount_of_payments"
                                            class="form-control form-control-lg">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Monto Primer Pago</label>
                                        <input type="number" value="0" min="0" name="first_payment" id="first_payment"
                                            class="form-control form-control-lg">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Periodicidad</label>
                                        <select name="periodicity" id="periodicity"
                                            class="form-control form-control-lg">
                                            <option value="QUINCENAL">PAGOS QUINCENALES</option>
                                            <option value="MENSUAL">PAGOS MENSUALES</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Cuenta Receptora</label>
                                        <select name="accountDestination" id="accountDestination"
                                            class="form-control form-control-lg">
                                            @forelse ($accounts as $account)
                                            <option value="{{$account->id}}">{{$account->account_name}}</option>
                                            @empty
                                            <option>NO HAY CUENTAS REGISTRADAS</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Tipo de Cuota</label>
                                        <select name="account_type" id="account_type"
                                            class="form-control form-control-lg">
                                            @forelse ($account_types as $type)
                                            <option value="{{$type->id}}">{{$type->account_type}}</option>
                                            @empty
                                            <option>NO HAY TIPOS DE CUOTAS REGISTRADAS</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Método de Pago</label>
                                        <select name="payment_method" id="payment_method"
                                            class="form-control form-control-lg">
                                            @forelse ($methods as $method)
                                            <option value="{{$method->id}}">{{$method->name}}</option>
                                            @empty
                                            <option>NO HAY CUENTAS REGISTRADAS</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">Tipo de Inscripción</label>
                                        <select name="type_of_inscription" id="type_of_inscription"
                                            class="form-control form-control-lg">
                                            <option value="NUEVO">NUEVO</option>
                                            <option value="RECURSADOR">RECURSADOR</option>
                                            <option value="EX-ALUMNO">EX-ALUMNO</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">Comentarios</label>
                                        <textarea name="comments" id="comments" cols="30" rows="5"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="saveStudent" class="btn btn-primary mt-4 pr-4 pl-4" name="saveDiplomat">Guardar</a>
            </div>
        </div>
    </div>
</div>
