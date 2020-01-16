<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Diplomado</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error-save"></strong>
                    </div>
                    <form id="form">
                        <div class="form-row">
                            <div class="form-group col-md-12 field">
                                <label for="exampleInputEmail1">Digita clave maestra</label>
                                <input type="password" class="form-control form-control-lg" onblur="checkPassword();" id="password" placeholder="************">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Nombre Diplomado</label>
                                <input type="text" class="form-control form-control-lg" id="nameSave" placeholder="Introduce nombre de diplomado">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Clave Diplomado</label>
                                <input type="text" class="form-control form-control-lg" id="keySave" placeholder="Introduce clave de diplomado">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Costo (BASE)</label>
                                <input type="number" value="0" min="0" class="form-control form-control-lg" id="costSave">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Costo Máximo (VENDEDORES)</label>
                                <input type="number" value="0" min="0" class="form-control form-control-lg" id="maximum_costSave">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer actions">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <input type="submit" class="btn btn-success  mt-4 pr-4 pl-4" id="saveDiplomat" disabled="disabled" value="Guardar">
            </div>
        </div>
    </div>
</div>
