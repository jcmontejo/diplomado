<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Docente</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
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
                                <label for="exampleInputPassword1">Apellido Paterno</label>
                                <input type="text" class="form-control form-control-lg" id="lastnameSave" placeholder="Introduce apellido paterno">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Apellido Materno</label>
                                <input type="text" class="form-control form-control-lg" id="motherlastnameSave"
                                    placeholder="Introduce apellido materno">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">Fecha de Nacimiento</label>
                                <input type="date" class="form-control form-control-lg" id="birthdateSave" placeholder="Introduce fecha de nacimiento">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="exampleInputPassword1">Genero</label>
                                <select name="sexSave" id="sexSave" class="form-control form-control-lg">
                                    <option value="H">Hombre</option>
                                    <option value="M">Mujer</option>
                                </select>
                                {{-- <input type="text" class="form-control form-control-lg" id="sexSave" placeholder="H/M">
                                --}}
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputPassword1">Teléfono de Contacto</label>
                                <input type="text" class="form-control form-control-lg" id="phoneSave" placeholder="000000000">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Correo Electrónico</label>
                                <input type="email" class="form-control form-control-lg" id="emailSave" placeholder="EJ. maria@docente.com">
                            </div>
                            <div class="form-group col-md-8">
                                <label for="exampleInputPassword1">Dirección</label>
                                <input type="text" class="form-control form-control-lg" id="addressSave" placeholder="Introduce dirección del docente">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Fecha de Ingreso</label>
                                <input type="date" class="form-control form-control-lg" id="joiningdateSave"
                                    placeholder="">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="saveTeacher" class="btn btn-info mt-4 pr-4 pl-4" name="saveDiplomat">Guardar</a>
            </div>
        </div>
    </div>
</div>
