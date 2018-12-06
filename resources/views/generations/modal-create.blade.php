<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Generación</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error-save"></strong>
                    </div>
                    <form id="form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Nombre Diplomado</label>
                                <select class="form-control form-control-lg" id="namediplomatSave">
                                    @forelse ($diplomats as $diplomat)
                                    <option value="{{$diplomat->id}}">{{$diplomat->name}}</option>
                                    @empty
                                    <option value="0">No hay diplomados registrados.</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Nombre Docente</label>
                                <select class="form-control form-control-lg" id="docentSave">
                                    @forelse ($docents as $docent)
                                    <option value="{{$docent->id}}">{{$docent->name}} {{$docent->last_name}} {{$docent->mother_last_name}}</option>
                                    @empty
                                    <option value="0">No hay docentes registrados.</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Número de Generación</label>
                                <input type="number" class="form-control form-control-lg" id="numbergenerationSave">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Fecha de Inicio</label>
                                <input type="date" class="form-control form-control-lg" id="startdateSave">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Número de Pagos</label>
                                <input type="number" class="form-control form-control-lg" id="numberpaymentsSave">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Notas</label>
                                <input type="text" class="form-control form-control-lg" id="noteSave" placeholder="Introduce observaciones">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Estatus</label>
                                <select class="form-control form-control-lg" name="statusSave" id="statusSave">
                                    <option value="1">ACTIVO</option>
                                    <option value="0">INACTIVO</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="saveGeneration" class="btn btn-primary mt-4 pr-4 pl-4" name="saveDiplomat">Guardar</a>
            </div>
        </div>
    </div>
</div>
