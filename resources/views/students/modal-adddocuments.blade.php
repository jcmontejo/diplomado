<div class="modal fade" id="modalAddDocuments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Subir Documentación <i class="fa fa-spinner fa-spin"></i></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <div id='message-error-document' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error-document"></strong>
                    </div>
                    <form id="formDocument" name="documents" enctype="multipart/form-data">
                        <div class="form-row">
                            <input type="hidden" id="id">
                             <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Alumno</label>
                                <input type="text" id="name-student" class="form-control form-control-lg bg-info" readonly>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Comprobante de Domicilio</label>
                                <input type="file" name="addressDoc" id="document-address" class="form-control form-control-lg" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Comprobante de último Grado de Estudios</label>
                                <input type="file" name="studyDoc" id="document-study" class="form-control form-control-lg" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="updateDocuments" class="btn btn-primary mt-4 pr-4 pl-4" name="updateDocuments">Guardar</button>
            </div>
        </div>
    </div>
</div>
