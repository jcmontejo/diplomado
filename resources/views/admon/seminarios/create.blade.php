<div id="block-create" style="display: none;">
    <div class="card shadow-lg">
        <div class="card-body">
            <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert'
                style="display: none">
                <strong id="error-save"></strong>
            </div>
            <form id="form-cat" novalidate="">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1">Digita tu Clave Maestra</label>
                        <input type="password" class="form-control form-control-lg" id="psdMaster" placeholder="****************">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Nombre Seminario</label>
                        <input type="text" class="form-control" id="txNombre" placeholder="EJE.: Seminario ABC" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Clave de Seminario</label>
                        <input type="text" class="form-control" id="txClave" placeholder="EJE.: S-20201-03" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Precio Seminario</label>
                        <input type="number" min="1" step="any" class="form-control" id="txPrecioVenta" required>
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