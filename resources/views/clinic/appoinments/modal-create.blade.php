<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Cita</h5>
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
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Fecha</label>
                                <input type="date" value="{{\Carbon\Carbon::now()->toDateString()}}"
                                    class="form-control form-control-lg" id="dateSave"
                                    placeholder="Introduce nombre de consultorio">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Hora Inicio</label>
                                <input type="time" class="form-control form-control-lg" id="startSave">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Hora Fin</label>
                                <input type="time" class="form-control form-control-lg" id="endSave">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Paciente</label>
                                <input type="text" class="form-control form-control-lg" id="patientSave">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Terapeuta</label>
                                <select class="form-control form-control-lg" name="" id="doctorSave">
                                    @forelse ($doctors as $doctor)
                                    <option value="{{$doctor->id}}">{{$doctor->name}} {{$doctor->lastname}}</option>
                                    @empty
                                    <option>No hay registros.</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Consultorio</label>
                                <select class="form-control form-control-lg" name="" id="roomSave">
                                    @forelse ($rooms as $room)
                                    <option value="{{$room->id}}">{{$room->name}}</option>
                                    @empty
                                    <option>No hay registros.</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Observación</label>
                                <textarea class="form-control form-control-lg" name="" id="observationSave" cols="30"
                                    rows="3"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="saveAppoinment" class="btn btn-info mt-4 pr-4 pl-4" name="saveAppoinment">Guardar</a>
            </div>
        </div>s
    </div>
</div>
