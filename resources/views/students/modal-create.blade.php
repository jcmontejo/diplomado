<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Alumno</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error-save"></strong>
                    </div>
                    <form id="form">
                        {{-- <input type="hidden" name="_token" value="{{csrf_token()}}" id="token"> --}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre</label>
                            <input type="text" class="form-control" id="nameSave" placeholder="Introduce nombre de alumno...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Apellido Paterno</label>
                            <input type="text" class="form-control" id="lastnameSave" placeholder="Introduce apellido paterno...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Apellido Materno</label>
                            <input type="text" class="form-control" id="motherlastnameSave" placeholder="Introduce apellido materno...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="birthdateSave" placeholder="Introduce fecha de nacimiento...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Genero (H/M)</label>
                            <input type="text" class="form-control" id="sexSave" placeholder="H/M">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Teléfono de Contacto</label>
                            <input type="text" class="form-control" id="phoneSave" placeholder="Introduce teléfono de contacto...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Dirección</label>
                            <input type="text" class="form-control" id="addressSave" placeholder="Introduce teléfono de contacto...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Correo Electrónico</label>
                            <input type="email" class="form-control" id="emailSave" placeholder="EJ. maria@alumno.com">
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
