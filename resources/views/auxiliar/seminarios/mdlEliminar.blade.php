<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar estudiante del grupo</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div id='message-error-edit' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error-edit"></strong>
                    </div>
                    <form id="form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="hidden" id="id-eliminar">
                                <label for="exampleInputEmail1">Digita tu Clave Maestra</label>
                                <input type="password" class="form-control form-control-lg" id="psdMasterEliminar" placeholder="****************">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="eliminarEstudiante" class="btn btn-danger mt-4 pr-4 pl-4" name="eliminarEstudiante">Eliminar estudiante</a>
            </div>
        </div>
    </div>
</div>
