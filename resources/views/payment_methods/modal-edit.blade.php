<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Método de Pago</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <div id='message-error-edit' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error-edit"></strong>
                    </div>
                    <form id="form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="hidden" id="id">
                                <label for="exampleInputEmail1">Nombre de Método de Pago</label>
                                <input type="text" class="form-control form-control-lg" id="name" placeholder="Introduce nombre de la cuenta">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="updateMethod" class="btn btn-primary mt-4 pr-4 pl-4" name="saveDiplomat">Actualizar</a>
            </div>
        </div>
    </div>
</div>
