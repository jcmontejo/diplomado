<div class="modal fade" id="modalDown" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Formulario de Baja de Estudiante</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error-save"></strong>
                    </div>
                    <form id="form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="hidden" name="inscriptionDown" id="inscriptionDown">
                                <label for="exampleInputEmail1">Nombre Alumno</label>
                                <input type="text" class="form-control form-control-lg" id="studentDown" placeholder="Introduce nombre de diplomado">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="hidden" name="lowID" id="lowID">
                                <label for="exampleInputEmail1">¿Porque?</label>
                                <select name="reasonDown" id="reasonDown" class="form-control form-control-lg">
                                    <option value="BAJA"> BAJA DEFINITIVA</option>
                                    <option value="TEMPORAL">BAJA TEMPORAL</option>
                                    <option value="CAMBIO">CAMBIO DIPLOMADO</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Comentarios adicionales</label>
                                <textarea name="commentsDown" id="commentsDown" cols="30" rows="10" class="form-control form-control-lg"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="downStudent" class="btn btn-primary mt-4 pr-4 pl-4" name="downStudent">Procesar Baja</a>
            </div>
        </div>
    </div>
</div>
