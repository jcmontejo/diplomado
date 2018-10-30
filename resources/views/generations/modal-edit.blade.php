<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Generación</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <form id="form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Nombre Diplomado</label>
                                <input type="hidden" id="id">
                                <select class="form-control form-control-lg" name="namediplomat" id="namediplomat">
                                    @forelse ($diplomats as $diplomat)
                                    <option value="{{$diplomat->id}}">{{$diplomat->name}}</option>
                                    @empty
                                    <option value="0">No hay diplomados registrados.</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Número de Generación</label>
                                <input type="number" class="form-control form-control-lg" id="numbergeneration">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Número de Pagos</label>
                                <input type="number" class="form-control form-control-lg" id="numberpayments">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Notas</label>
                                <input type="text" class="form-control form-control-lg" id="note" placeholder="Introduce observaciones">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Estatus</label>
                                <select class="form-control form-control-lg" name="statusSave" id="status">
                                    <option value="1">ACTIVO</option>
                                    <option value="0">INACTIVO</option>
                                </select>
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
