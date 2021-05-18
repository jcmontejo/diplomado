<!-- The Modal -->
<div class="modal" id="modalConvenio">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" style="color: #fff;">Agregar Convenio de Pago</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-row">
                    <input type="hidden" id="id_convenio" name="id_convenio">
                    <div class="form-group col-md-5 field">
                        <label for="exampleInputPassword1">Fecha de Pago</label>
                        <input type="date" class="form-control" id="fechaConvenio" name="fechaConvenio">
                    </div>
                    <div class="form-group col-md-7 field">
                        <label for="exampleInputPassword1">Monto de Pago</label>
                        <input type="number" min="1" name="montoConvenio" id="montoConvenio" class="form-control">
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer actions">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-power-off"></i>
                    Cancelar</button>
                <input type="submit" class="btn btn-success" id="procesarConvenio" onclick="procesarConvenio();"
                    value="Procesar Convenio">
            </div>
        </div>
    </div>
</div>
