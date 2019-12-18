<div class="modal fade" id="modalDocuments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Documentos del Alumno</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <div id='message-error' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error"></strong>
                    </div>
                    <form id="form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="hidden" id="file-id">
                                <label for="exampleInputEmail1">Comprobante de Domicilio</label>
                                <br>
                                <a href="" download id="file-address"></a>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Comprobante de último Grado de Estudios</label>
                                <br>
                                <a href="" download id="file-study"></a>
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
