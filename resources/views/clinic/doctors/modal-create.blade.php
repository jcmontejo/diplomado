<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Terapeuta</h5>
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
                                <label for="exampleInputEmail1">Nombre</label>
                                <input type="text" class="form-control form-control-lg" id="nameSave" placeholder="Introduce nombre de docente">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Apellidos</label>
                                <input type="text" class="form-control form-control-lg" id="lastnameSave" placeholder="Introduce apellidos">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Teléfono de Contacto</label>
                                <input type="text" class="form-control form-control-lg" id="phoneSave" placeholder="xxxxxxxxxx">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Correo Electrónico</label>
                                <input type="email" class="form-control form-control-lg" id="emailSave" placeholder="EJ. maria@gmail.com">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="saveDoctor" class="btn btn-info mt-4 pr-4 pl-4" name="saveDoctor">Guardar</a>
            </div>
        </div>
    </div>
</div>
