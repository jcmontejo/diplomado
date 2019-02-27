<div class="modal fade" id="modaladdStudents" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Alumnos a Campaña</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert'
                        style="display: none">
                        <strong id="error-save"></strong>
                    </div>
                    <form id="form">
                        <input type="hidden" name="idCampaingAdd" id="idCampaingAdd">
                        <div class="table-responsive">
                            <table class="table" id="addStudents">
                                <thead>
                                    <th>Nombre</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>CURP</th>
                                    <th>Teléfono</th>
                                    <th>Correo Electrónico</th>
                                    <th>Facebook</th>
                                    <th><input type="checkbox" id="checkAll" > Todos </th>
                                </thead>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <button type="button" name="bulk_add" id="bulk_add" class="btn btn-primary mt-4 pr-4 pl-4"><i class="fa fa-plus-square"></i> Agregar</button>
            </div>
        </div>
    </div>
</div>
