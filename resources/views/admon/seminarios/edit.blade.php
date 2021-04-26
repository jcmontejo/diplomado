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
                    <label for="exampleInputEmail1">Digita tu Clave Maestra</label>
                    <input type="password" class="form-control form-control-lg" id="psdMasterEdit" placeholder="****************">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail4">Nombre Seminario</label>
                    <input type="text" class="form-control" id="txNombreEdit" placeholder="EJE.: Seminario ABC" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail4">Clave de Seminario</label>
                    <input type="text" class="form-control" id="txClaveEdit" placeholder="EJE.: S-20201-03" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail4">Precio Seminario</label>
                    <input type="number" min="1" step="any" class="form-control" id="txPrecioVentaEdit" required>
                </div>
            </div>
            </form>
            <button type="submit" class="btn btn-success" id="updateCat" onclick="updateCat();"><i
                    class="fas fa-check-circle"></i>
                Guardar</button>
            <button class="btn btn-danger" id="cancel" onclick="cancel();"><i
                    class="fas fa-exclamation-triangle"></i>
                Cancelar</button>
        </div>
    </div>
</div>