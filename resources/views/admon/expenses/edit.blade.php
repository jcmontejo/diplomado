<div id="block-edit" style="display: none;">
    <div class="card shadow-lg">
        <div class="card-body">
            <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert'
                style="display: none">
                <strong id="error-save"></strong>
            </div>
            <form id="form-cat-edit" novalidate="">
                <input type="hidden" id="id_cat">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Fecha *</label>
                        <input type="date" class="form-control" id="txtDateEdit" value="{{\Carbon\Carbon::now()->toDateString()}}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Concepto *</label>
                        <input type="text" class="form-control" id="txtConceptEdit" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Importe *</label>
                        <input type="number" step="1" min="1" class="form-control" id="txtAmountEdit" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Fuente *</label>
                        <select class="form-control" name="txtAccountEdit" id="txtAccountEdit">
                            @foreach ($accounts as $account)
                            <option value="{{$account->id}}">{{$account->account_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Clasificación *</label>
                        <select class="form-control" name="txtReferenceEdit" id="txtReferenceEdit">
                            @foreach ($cat_references as $cat_reference)
                            <option value="{{$cat_reference->id}}">{{$cat_reference->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Referencia *</label>
                        <select class="form-control" name="txtClasificationEdit" id="txtClasificationEdit">
                            @foreach ($cat_clasifications as $cat_clasification)
                            <option value="{{$cat_clasification->id}}">{{$cat_clasification->name}}</option>
                            @endforeach
                        </select>
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