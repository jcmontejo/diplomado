<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Tipo de Cuota</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error-save"></strong>
                    </div>
                    <form id="form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Tipo de Cuota</label>
                                <input type="text" class="form-control form-control-lg" id="accounttypeSave" placeholder="Introduce tipo de cuota">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Código de Cuota</label>
                                <input type="text" class="form-control form-control-lg" id="accountcodeSave" placeholder="Introduce código de cuota">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Notas</label>
                                <input type="text" class="form-control form-control-lg" id="noteSave" placeholder="Escribe algunas notas">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="saveAccountType" class="btn btn-primary mt-4 pr-4 pl-4" name="saveAccountType">Guardar</a>
            </div>
        </div>
    </div>
</div>
