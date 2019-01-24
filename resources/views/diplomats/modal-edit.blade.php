<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Diplomado</h5>
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
                                <label for="exampleInputEmail1">Nombre Diplomado</label>
                                <input type="text" class="form-control form-control-lg" id="name" placeholder="Introduce nombre de diplomado">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Clave Diplomado</label>
                                <input type="text" class="form-control form-control-lg" id="key" placeholder="Introduce clave de diplomado">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Costo (BASE)</label>
                                <input type="number" value="0" min="0" class="form-control form-control-lg" id="cost" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Costo Máximo (VENDEDORES)</label>
                                <input type="number" value="0" min="0" id="maximum_cost" class="form-control form-control-lg" readonly>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="updateDiplomat" class="btn btn-primary mt-4 pr-4 pl-4" name="saveDiplomat">Actualizar</a>
            </div>
        </div>
    </div>
</div>
