<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Campaña</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert'
                        style="display: none">
                        <strong id="error-save"></strong>
                    </div>
                    <form id="form">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Asunto</label>
                                <input type="text" class="form-control form-control-lg" id="subjectSave" placeholder="Introduce asunto de campaña">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Nombre de Campaña</label>
                                <input type="text" class="form-control form-control-lg" id="nameSave" placeholder="Introduce nombre de campaña">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Url</label>
                                <input type="text" class="form-control form-control-lg" id="html_urlSave"
                                    placeholder="www.google.com.mx">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Fecha Programada de Envío</label>
                                <input type="date" class="form-control form-control-lg" id="send_dateSave" placeholder="AAAA-MM-DD">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Tipo de Campaña</label>
                                <select name="typeSave" id="typeSave" class="form-control form-control-lg">
                                    <option value="SMS">SMS</option>
                                    <option value="EMAIL">EMAIL</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Mensaje a Enviar</label>
                                <textarea name="messageSave" id="messageSave" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="saveCampaing" class="btn btn-info mt-4 pr-4 pl-4" name="saveCampaing">Guardar</a>
            </div>
        </div>
    </div>
</div>
