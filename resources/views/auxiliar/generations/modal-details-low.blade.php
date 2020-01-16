<div class="modal fade" id="modalDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de Baja</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <form id="form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="text-center">
                                    <img src="{{asset('/images/user.png')}}" class="img-thumbnail" alt="">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Motivo</label>
                                <input type="text" class="form-control form-control-sm" id="reason">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Fecha/Hora de Baja</label>
                                <input type="text" class="form-control form-control-sm" id="created_at">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Comentarios Adicionales</label>
                                <div class="text-center"></div>
                                <textarea name="comments" id="comments" cols="30" rows="10" class="form-control form-control-lg"></textarea>
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
