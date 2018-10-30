<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Cuenta de Usuario</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error-save"></strong>
                    </div>
                    <form id="form-create">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Nombre de Usuario</label>
                                <input type="text" class="form-control form-control-lg" id="nameSave" placeholder="Introduce nombre de usuario">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Correo Electrónico de Acceso</label>
                                <input type="email" class="form-control form-control-lg" id="emailSave" placeholder="EJ. juan.mendez@gmail.com">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Contraseña de Acceso</label>
                                <input type="password" class="form-control form-control-lg" id="passwordSave" placeholder="****************">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="saveEmploye" class="btn btn-primary mt-4 pr-4 pl-4" name="saveDiplomat">Guardar</a>
            </div>
        </div>
    </div>
</div>
