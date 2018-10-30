<div class="modal fade" id="modalStudents" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Matricular Alumnos</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 col-ml-12">
                    <form id="form">
                        <input type="text" id="id_generation">
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Selecciona Alumnos</label>
                                <select id="tag_list" name="tag_list[]" class="form-control form-control-lg" multiple></select>
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
