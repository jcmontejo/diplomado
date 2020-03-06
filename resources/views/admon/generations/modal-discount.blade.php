<div class="modal fade" id="modalDiscount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-tag"></i> Aplicar Descuento Extraordinario</h5>
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
                                <input type="hidden" name="inscriptionDiscount" id="inscriptionDiscount">
                                <label for="exampleInputEmail1">Monto del descuento a aplicar</label>
                                <input type="number" min="1" class="form-control form-control-lg" id="amountDiscount">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="ApplyDiscount" class="btn btn-success mt-4 pr-4 pl-4" name="ApplyDiscount">Procesar Descuento</a>
            </div>
        </div>
    </div>
</div>
