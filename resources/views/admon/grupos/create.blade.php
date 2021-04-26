<div id="block-create" style="display: none;">
    <div class="card shadow-lg">
        <div class="card-body">
            <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert'
                style="display: none">
                <strong id="error-save"></strong>
            </div>
            <form id="form-cat" novalidate="">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Nombre Seminario</label>
                        <input type="text" class="form-control" id="txNombre" placeholder="EJE.: Grupo Mayo 2021" required>
                    </div>
                </div>
            </form>
            <button type="submit" class="btn btn-success" id="saveCat" onclick="storeCat();"><i
                    class="fas fa-check-circle"></i>
                Guardar</button>
            <button class="btn btn-danger" id="cancel" onclick="cancel();"><i
                    class="fas fa-exclamation-triangle"></i>
                Cancelar</button>
        </div>
    </div>
</div>