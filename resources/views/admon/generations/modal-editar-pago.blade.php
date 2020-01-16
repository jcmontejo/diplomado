<!-- The Modal -->
<div class="modal" id="modalEditarPrimerPago">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Editar primer pago</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="primer_pago_debt_id">
                        <input type="hidden" id="primer_pago_total_debt">
                        <div class="form-row">
                        
                            <div class="form-group col-md-12 editarPago">
                                <label for="exampleInputPassword1">Monto de Pago</label>
                                <input type="number" min="1" name="montoPrimerPago" id="montoPrimerPago" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer actionsPago">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-power-off"></i> Cancelar</button>
                    <input type="submit" class="btn btn-success" id="procesarEditarPrimerPago" disabled="disabled" value="Actualizar">
                </div>
            </div>
        </div>
    </div>
    