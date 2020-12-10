<div id="block-edit" style="display: none;">
    <div class="card shadow-lg">
        <div class="card-body">
            <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert'
                style="display: none">
                <strong id="error-save"></strong>
            </div>
            <form id="form-medicine" novalidate="">
               <input type="hidden" name="id_cat" id="id_cat">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">Nombre</label>
                        <input type="text" class="form-control" id="txtNameEdit" placeholder="EJE.: 0101" required>
                    </div>
                </div>
            </form>
            <button type="submit" class="btn btn-success" id="saveCat" onclick="updateCat();"><i
                    class="fas fa-check-circle"></i>
                Guardar</button>
            <button class="btn btn-danger" id="cancel" onclick="cancel();"><i
                    class="fas fa-exclamation-triangle"></i>
                Cancelar</button>
        </div>
    </div>
</div>