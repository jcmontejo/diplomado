<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Generación</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <form id="form">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Fecha de Inicio</label>
                                <input type="hidden" id="idEdit">
                                <input type="date" name="dateEdit" id="dateEdit" class="form-control form-control-lg">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Número de Generación</label>
                                <input type="number" class="form-control form-control-lg" id="number_generationEdit">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Importe a pagar por comisión (BASE)</label>
                                <input type="number" class="form-control form-control-lg" id="commisionEdit">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">% a pagar por FULL PRICE</label>
                                <input type="number" class="form-control form-control-lg" id="full_priceEdit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="updateGeneration" class="btn btn-primary mt-4 pr-4 pl-4" name="saveDiplomat">Actualizar</a>
            </div>
        </div>
    </div>
</div>
