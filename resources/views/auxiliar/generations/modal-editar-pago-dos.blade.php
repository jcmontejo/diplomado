<!-- The Modal -->
<div class="modal" id="modalEditarPago">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title inner">Editar pago</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form>
                    <input type="hidden" id="editar_pago_debt_id">
                    <input type="hidden" id="editar_pago_total_debt">
                    <input type="hidden" id="editar_num_pago">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Digita tu Clave Maestra</label>
                            <input type="password" class="form-control form-control-lg" id="psdMasterEditPay"
                                placeholder="****************">
                        </div>

                        <div class="form-group col-md-12 editarPagoDos">
                            <label for="exampleInputPassword1">Monto de Pago</label>
                            <input type="number" min="1" name="montoNuevoPago" id="montoNuevoPago"
                                class="form-control form-control-lg">
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer actionsPagoDos">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-power-off"></i>
                    Cancelar</button>
                <input type="submit" class="btn btn-success" id="procesarEditarPago" value="Actualizar">
            </div>
        </div>
    </div>
</div>
