<div class="modal fade" id="modalInscriptionSeminario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Inscribir Alumno a Seminario</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div id='message-error' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error"></strong>
                    </div>
                    <form id="form">
                        <input type="hidden" name="id-student-seminario" id="id-student-seminario">
                        <div id="data-seminarios" style="display: block;">
                            <div class="mb-2 bg-dark text-white text-center">DATOS DEL SEMINARIO</div>
                            <div class="form-row col-md-12">
                                <div class="form-group col-md-8">
                                    <input type="hidden" id="id">
                                    <label for="exampleInputEmail1">Selecciona Seminario</label>
                                    <select name="seminario_id_n" id="seminario_id_n" class="form-control form-control-lg">
                                        <option value="">--- Selecciona Seminario ---</option>
                                        @forelse ($seminarios as $seminario)
                                        <option value="{{$seminario->id}}">{{$seminario->nombre}} [${{$seminario->precio_venta}}]</option>
                                        @empty
                                        <option value="0">No hay seminarios registrados.</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleInputPassword1">Selecciona Grupo</label>
                                    <select name="grupo_id_n" id="grupo_id_n" class="form-control form-control-lg">
                                        <option value="">--- Selecciona Grupo ---</option>
                                        @forelse ($grupos as $grupo)
                                        <option value="{{$grupo->id}}">{{$grupo->nombre}}</option>
                                        @empty
                                        <option value="0">No hay grupos registrados.</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Descuento</label>
                                    <input type="number" value="0" min="1" step="1" id="descuento_n" name="descuento_n"
                                        class="form-control form-control-lg">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Número de Pagos</label>
                                    <input type="number" value="1" min="1" max="10" step="1" id="numero_de_pagos_n"
                                        name="numero_de_pagos_n" class="form-control form-control-lg">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">¿De cuanto seran los pagos?</label>
                                    <input type="number" min="1" step="any" value="0" name="monto_de_pagos_n" id="monto_de_pagos_n"
                                        class="form-control form-control-lg">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Monto Primer Pago</label>
                                    <input type="number" value="0" min="0" name="primer_pago_n" id="primer_pago_n"
                                        class="form-control form-control-lg">
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="">Cuenta Receptora</label>
                                    <select name="cuenta_destino_n" id="cuenta_destino_n"
                                        class="form-control form-control-lg">
                                        @forelse ($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->account_name}}</option>
                                        @empty
                                        <option>NO HAY CUENTAS REGISTRADAS</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Tipo de Cuota</label>
                                    <select name="tipo_cuota_n" id="tipo_cuota_n" class="form-control form-control-lg">
                                        @forelse ($account_types as $type)
                                        <option value="{{$type->id}}">{{$type->account_type}}</option>
                                        @empty
                                        <option>NO HAY TIPOS DE CUOTAS REGISTRADAS</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Método de Pago</label>
                                    <select name="metodo_de_pago_n" id="metodo_de_pago_n" class="form-control form-control-lg">
                                        @forelse ($methods as $method)
                                        <option value="{{$method->id}}">{{$method->name}}</option>
                                        @empty
                                        <option>NO HAY MÉTODOS REGISTRADAS</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <a href="#" id="processInscriptionSeminario" class="btn btn-success btn-block text-uppercase" name="processInscriptionSeminario"><i class="fas fa-check"></i> Inscribir a Seminario</a>
            </div>
        </div>
    </div>
</div>
