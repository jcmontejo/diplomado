<!-- The Modal -->
<div class="modal" id="modalConvenio">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Agregar Convenio de Pago</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form>
                    <input type="hidden" id="convenio_debt_id">
                    <input type="hidden" id="convenio_num_pay">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputPassword1">Fecha de Pago</label>
                            <input type="date" class="form-control" id="fechaConvenio" name="fechaConvenio">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="exampleInputPassword1">Monto de Pago</label>
                            <input type="number" min="1" name="montoConvenio" id="montoConvenio" class="form-control">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-power-off"></i> Cancelar</button>
                <button type="button" class="btn btn-success" id="procesarConvenio"><i class="fa fa-thumbs-up"></i> Procesar Convenio</button>
            </div>
        </div>
    </div>
</div>
