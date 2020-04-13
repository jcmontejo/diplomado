<div class="modal fade" id="modalEditInscription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Datos de la Inscripción</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div id='message-error-edit' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error-edit"></strong>
                    </div>
                    <form id="form">
                        <div class="form-row">
                            <input type="hidden" id="ID-INSCRIPTION">
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Digita tu Clave Maestra</label>
                                <input type="password" class="form-control form-control-lg" id="psdMasterEditIns" placeholder="****************">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Costo de Diplomado</label>
                                <input type="number" class="form-control" id="final_costIns" min="1">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Primer Pago de Diplomado</label>
                                <input type="number" class="form-control" id="first_paymentIns" min="1">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Número de Pagos</label>
                                <input type="number" class="form-control" id="number_of_paymenstIns">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Monto de los Pagos</label>
                                <input type="number" class="form-control" id="amount_of_paymenstIns" min="1">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="updateIns" class="btn btn-primary mt-4 pr-4 pl-4" name="updateIns">Actualizar</a>
            </div>
        </div>
    </div>
</div>
