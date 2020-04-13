<div class="modal fade" id="modalSale" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title justify-content-center">Procesar Inscripción..</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div id='message-error-save-N' class="alert alert-danger alert-dismissible fade show" role='alert'
                        style="display: none">
                        <strong id="error-save-N"></strong>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-12 col-lg-12">
                            <form class="card card-sm">
                                <div class="card-body row no-gutters align-items-center">
                                    <div class="col">
                                        <input class="form-control form-control-lg form-control-borderless" type="text"
                                            id="search" placeholder="Buscar alumno por CURP">
                                    </div>
                                    <!--end of col-->
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-lg btn-primary" id="searchStudent"><i
                                                class="fas fa-search-plus"></i> Buscar</button>
                                    </div>
                                    <!--end of col-->
                                </div>
                        </div>
                        <!--end of col-->
                    </div>
                    </form>
                    <hr>
                    <div class="mb-2 bg-dark text-white text-center">DATOS DEL ALUMNO</div>
                    <form id="formRate">
                        <div class="form-row col-md-12">
                            <div id='message-error-save' class="alert alert-danger alert-dismissible fade show"
                                role='alert' style="display: none">
                                <strong id="error-save"></strong>
                            </div>
                            <input type="hidden" name="idStudent" id="idStudent">
                            <input type="hidden" name="bandera" id="bandera">
                            <div class="form-group col-md-6">
                                <label for="name">CURP</label>
                                <input type="text" id="curpStudent" class="form-control form-control-lg"
                                    placeholder="Introduce CURP de alumno">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Nombre</label>
                                <input type="text" class="form-control form-control-lg" id="nameStudent"
                                    placeholder="Introduce nombre del alumno">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Apellido Paterno</label>
                                <input type="text" class="form-control form-control-lg" id="lastnameStudent"
                                    placeholder="Introduce apellido paterno">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Apellido Materno</label>
                                <input type="text" class="form-control form-control-lg" id="motherlastnameStudent"
                                    placeholder="Introduce apellido materno">
                            </div>
                            <div class="form-group col-md-8">
                                <label for="exampleInputPassword1">Facebook</label>
                                <input type="text" class="form-control form-control-lg" id="facebookStudent"
                                    placeholder="Introduce Facebook">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Fecha de Nacimiento</label>
                                <input type="date" class="form-control form-control-lg" id="birthdateStudent"
                                    placeholder="Introduce fecha de nacimiento">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Genero</label>
                                <select name="sexSave" id="sexStudent" class="form-control form-control-lg">
                                    <option value="H">Hombre</option>
                                    <option value="M">Mujer</option>
                                </select>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="exampleInputPassword1">Teléfono de Contacto</label>
                                <input type="text" class="form-control form-control-lg" id="phoneStudent"
                                    placeholder="Introduce teléfono de contacto">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Dirección</label>
                                <input type="text" class="form-control form-control-lg" id="addressStudent"
                                    placeholder="Introduce dirección de alumno">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Estado</label>
                                <input type="text" id="stateStudent" class="form-control form-control-lg">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Ciudad</label>
                                <input type="text" id="cityStudent" class="form-control form-control-lg">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Correo Electrónico</label>
                                <input type="email" class="form-control form-control-lg" id="emailStudent"
                                    placeholder="EJ. maria@alumno.com">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Profesión</label>
                                <select name="professionSave" id="professionStudent"
                                    class="form-control form-control-lg">
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
                        </div>
                    </form>
                    <hr>
                    <div id="data-diplomat">
                        <div class="mb-2 bg-dark text-white text-center">DATOS DEL DIPLOMADO</div>
                        <div class="form-row col-md-12">
                            <div class="form-group col-md-8">
                                <input type="hidden" id="id">
                                <label for="exampleInputEmail1">Selecciona Diplomado</label>
                                <select name="diplomat_id_N" id="diplomat_id_N" class="form-control form-control-lg">
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
                                <select name="generation_id_N" id="generation_id_N" class="form-control form-control-lg">
                                    <option value="">--- Selecciona Diplomado Antes---</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Descuento</label>
                                <input type="number" value="0" min="1" step="1" id="discount_N" name="discount_N"
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
                                <input type="number" value="1" min="1" max="10" step="1" id="number_payments_N"
                                    name="number_payments_N" class="form-control form-control-lg">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">¿De cuanto seran los pagos?</label>
                                <input type="text" name="amount_of_payments_N" id="amount_of_payments_N"
                                    class="form-control form-control-lg">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Monto Primer Pago</label>
                                <input type="number" value="0" min="0" name="first_payment_N" id="first_payment_N"
                                    class="form-control form-control-lg">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Periodicidad</label>
                                <select name="periodicity_N" id="periodicity_N" class="form-control form-control-lg">
                                    <option value="QUINCENAL">PAGOS QUINCENALES</option>
                                    <option value="MENSUAL">PAGOS MENSUALES</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Cuenta Receptora</label>
                                <select name="accountDestination_N" id="accountDestination_N"
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
                                <select name="account_type_N" id="account_type_N" class="form-control form-control-lg">
                                    @forelse ($account_types as $type)
                                    <option value="{{$type->id}}">{{$type->account_type}}</option>
                                    @empty
                                    <option>NO HAY TIPOS DE CUOTAS REGISTRADAS</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Método de Pago</label>
                                <select name="payment_method_N" id="payment_method_N" class="form-control form-control-lg">
                                    @forelse ($methods as $method)
                                    <option value="{{$method->id}}">{{$method->name}}</option>
                                    @empty
                                    <option>NO HAY CUENTAS REGISTRADAS</option>
                                    @endforelse
                                </select>
                            </div>
                            {{--  <div class="form-group col-md-12">
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
                            </div>  --}}
                        </div>
                    </div>
                    <div id="data-diplomat-old" style="display:none;">
                        <div class="mb-2 bg-dark text-white text-center">ESTE ALUMNO YA ESTUVO EN DIPLOMADOS ANTES</div>
                        <div class="form-group col-md-12">
                            <input type="hidden" id="id">
                            <label for="exampleInputEmail1">Listado de diplomados en los que causo BAJA, selecciona uno para matricular de nuevo</label>
                            <select name="old_data_id" id="old_data_id" class="form-control form-control-lg">
                                <option value="">----</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputPassword1">Selecciona la nueva generación a la que se integra</label>
                            <select name="generation_id_old" id="generation_id_old" class="form-control form-control-lg">
                                <option value="">--- Selecciona una de las BAJAS antes ---</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger mt-4 pr-4 pl-4" data-dismiss="modal"><i
                        class="fas fa-power-off"></i> Cerrar</button>
                <a href="#" id="saveSale" class="btn btn-success mt-4 pr-4 pl-4" name="saveSale"><i
                        class="fas fa-check"></i> Procesar</a>
            </div>
        </div>
    </div>
</div>
