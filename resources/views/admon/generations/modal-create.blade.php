<div class="modal hide fade" id="modalCreate" aria-hidden="true" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Generación</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert'
                        style="display: none">
                        <strong id="error-save"></strong>
                    </div>
                    <form id="form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Digita tu Clave Maestra</label>
                                <input type="password" class="form-control form-control-lg" id="psdMaster"
                                    placeholder="****************">
                            </div>
                            <div class="form-group col-12">
                                <label for="exampleInputEmail1">Nombre Diplomado</label>
                                <select class="form-control form-control-lg js-example-basic-single"
                                    id="namediplomatSave">
                                    @forelse ($diplomats as $diplomat)
                                        <option value="{{ $diplomat->id }}">{{ $diplomat->name }}</option>
                                    @empty
                                        <option value="0">No hay diplomados registrados.</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <label for="exampleInputEmail1">Nombre Docente</label>
                                <select class="form-control form-control-lg" id="docentSave">
                                    @forelse ($docents as $docent)
                                        <option value="{{ $docent->id }}">{{ $docent->name }}
                                            {{ $docent->last_name }}
                                            {{ $docent->mother_last_name }}</option>
                                    @empty
                                        <option value="0">No hay docentes registrados.</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="exampleInputPassword1">Número de Generación</label>
                                <input type="number" class="form-control form-control-lg" id="numbergenerationSave">
                            </div>
                            <div class="form-group col-6">
                                <label for="exampleInputPassword1">Fecha de Inicio</label>
                                <input type="date" class="form-control form-control-lg" id="startdateSave">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">COSTO</label>
                                <input type="number" class="form-control form-control-lg" id="costSave">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">COSTO MÁXIMO</label>
                                <input type="number" class="form-control form-control-lg" id="maximum_costSave">
                            </div>
                        </div>
                        <div class="form-row col-12">
                            <div class="col-12 bg-secondary text-white text-center">DATOS PAGOS A VENDEDORES</div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="exampleInputPassword1">Importe a pagar por comisión (BASE)</label>
                                <input type="number" class="form-control form-control-lg" id="commisionSave">
                            </div>
                            <div class="form-group col-6">
                                <label for="exampleInputPassword1">% a pagar por FULL PRICE</label>
                                <input type="number" class="form-control form-control-lg" id="full_priceSave">
                            </div>
                        </div>
                        <div class="form-row col-12">
                            <div class="col-12 bg-secondary text-white text-center">DATOS PAGOS A DOCENTES</div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="exampleInputPassword1">Esquema de pago</label>
                                <select class="form-control form-control-lg" name="esquema_pago_docente"
                                    id="esquema_pago_docente">
                                    <option value="0">-- Selecciona opción ---</option>
                                    <option value="1">Por estudiante</option>
                                    <option value="2">Por semana</option>
                                </select>
                            </div>
                            <div class="form-group col-12 mostrar-estudiante" style="display: none">
                                <label for="exampleInputPassword1">¿Cuanto se pagara por estudiante?</label>
                                <input type="number" min="1" step="any" class="form-control form-control-lg" name="pago_por_estudiante" id="pago_por_estudiante">
                            </div>
                            <div class="form-group col-6 mostrar-semana" style="display: none">
                                <label for="exampleInputPassword1">¿Cuanto se pagara por semana?</label>
                                <input type="number" min="1" step="any" class="form-control form-control-lg" name="pago_por_semana" id="pago_por_semana">
                            </div>
                            <div class="form-group col-6 mostrar-semana" style="display: none">
                                <label for="exampleInputPassword1">¿Cuanto semanas seran?</label>
                                <input type="number" min="1" step="any" class="form-control form-control-lg" name="total_semanas" id="total_semanas">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer actions">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <input type="submit" class="btn btn-success  mt-4 pr-4 pl-4" id="saveGeneration" value="Guardar">
            </div>
        </div>
    </div>
</div>
