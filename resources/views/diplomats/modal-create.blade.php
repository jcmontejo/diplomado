<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualizar Diplomado</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <div id='message-error' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error"></strong>
                    </div>
                    <form id="form">
                        {{-- <input type="hidden" name="_token" value="{{csrf_token()}}" id="token"> --}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre Diplomado</label>
                            <input type="text" class="form-control" id="nameSave" placeholder="Introduce nombre de diplomado...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Clave Diplomado</label>
                            <input type="text" class="form-control" id="keySave" placeholder="Introduce clave de diplomado...">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Costo Diplomado</label>
                            <input type="number" class="form-control" id="costSave">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="saveDiplomat" class="btn btn-primary mt-4 pr-4 pl-4" name="saveDiplomat">Guardar</a>
            </div>
        </div>
    </div>
</div>
