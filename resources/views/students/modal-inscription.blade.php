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
