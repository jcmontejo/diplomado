<div class="modal fade" id="modalShow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <form id="form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="text-center">
                                    <img src="{{asset('/images/user.png')}}" class="img-thumbnail" alt="">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Nombre de Estudiante</label>
                                <input type="text" class="form-control form-control-sm" id="fullname">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Fecha y Hora de Inscripción</label>
                                <input type="text" class="form-control form-control-sm" id="date">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Descuento Aplicado</label>
                                <input type="number" class="form-control form-control-sm" id="discount">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Costo Final Diplomado</label>
                                <input type="number" class="form-control form-control-sm" id="total">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Primer Pago</label>
                                <div class="text-center"></div>
                                <input type="number" class="form-control form-control-sm" id="first_payment">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Deuda Actual</label>
                                <div class="text-center"></div>
                                <input type="number" class="form-control form-control-sm" id="debt">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
