<div class="modal fade" id="modalTraffic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modificar % de semaforo</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert'
                        style="display: none">
                        <strong id="error-save"></strong>
                    </div>
                    <form id="formStudent" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="hidden" id="studentID">
                                <label for="exampleInputPassword1">SEMAFORO</label>
                                <select name="" id="trafficEdit" class="form-control form-control-lg">
                                  <option value="10">10%</option>
                                  <option value="20">20%</option>
                                  <option value="30">30%</option>
                                  <option value="40">40%</option>
                                  <option value="50">50%</option>
                                  <option value="60">60%</option>
                                  <option value="70">70%</option>
                                  <option value="80">80%</option>
                                  <option value="90">90%</option>
                                  <option value="100">100%</option>
                                  <option value="110">110%</option>
                                </select>
                            </div>
                            <hr>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="updateTraffic" class="btn btn-primary mt-4 pr-4 pl-4" name="updateTraffic">Guardar</a>
            </div>
        </div>
    </div>
</div>
