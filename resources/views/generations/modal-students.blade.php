<div class="modal fade" id="modalStudents" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alumnos</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 col-ml-12">
                    <div class="table-responsive">
                        <table class="table" id="students">
                            <thead>
                                <th>Nombre Alumno</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Total Adeudo</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="reloadStudents()" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
