<div id="block-create" style="display: none;">
    <div class="card shadow-lg">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Diplomado</th>
                        <th>Generación</th>
                        <th>Docente</th>
                        <th>Total de Inscritos</th>
                        <th>Bajas</th>
                        <th>Total a Pagar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <span id="s_diplomat"></span>
                        </td>
                        <td>
                            <span id="s_generation"></span>
                        </td>
                        <td>
                            <span id="s_docent"></span>
                        </td>
                        <td>
                            <span id="s_total_ins"></span>
                        </td>
                        <td>
                            <span id="s_down"></span>
                        </td>
                        <td>
                            <span id="s_total_pay"></span>
                            <input type="hidden" id="i_total_pay">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div id="block-scheme-create" style="display: none;">
        <div class="card shadow-lg">
            <div class="card-body">
                <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert'
                    style="display: none">
                    <strong id="error-save"></strong>
                </div>
                <input type="hidden" id="id_cat">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Tipo de Pago</label>
                        <select name="type_scheme" id="type_scheme" class="form-control">
                            <option value="1">Por alumno</option>
                            <option value="2">Por semana</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Costo por alumno</label>
                        <input type="number" step="1" min="1" class="form-control" id="cost_student"
                            required="required">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Costo por semana</label>
                        <input type="number" step="1" min="1" class="form-control" id="cost_week" required="required">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Número de semanas</label>
                        <input type="number" step="1" min="1" class="form-control" id="weeks" required="required">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Número de pagos</label>
                        <input type="number" step="1" min="1" class="form-control" id="number_payments"
                            required="required">
                    </div>
                </div>
                <button type="button" class="btn btn-success" id="saveCat" onclick="storeScheme();">
                    <i class="fas fa-check-circle"></i>
                    Guardar</button>
            </div>
        </div>
    </div>
    <div id="block-apply-create" style="display: none;">
        <div class="card shadow-lg">
            <div class="card-body">
                <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert'
                    style="display: none">
                    <strong id="error-save"></strong>
                </div>
                <form id="form-cat-scheme" novalidate="">
                    <div class="form-row">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tipo de pago</th>
                                    <th>Pago por alumno</th>
                                    <th>Pago por semana</th>
                                    <th>Número de semanas</th>
                                    <th>Total a pagar</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <span id="t_scheme"></span>
                                        <input type="hidden" id="ID_scheme">
                                    </td>
                                    <td>
                                        <span id="t_cost_student"></span>
                                    </td>
                                    <td>
                                        <span id="t_cost_week"></span>
                                    </td>
                                    <td>
                                        <span id="t_weeks"></span>
                                    </td>
                                    <td>
                                        <span id="t_total_pay"></span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" onclick="getSchemeTwo();"><i
                                                class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <!-- DataTales Example -->
                            <div id="block-table-pays" style="display: none;">
                                <div class="card shadow-lg">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="cat_apply" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Nº Pago</th>
                                                        <th>Fecha de pago</th>
                                                        <th>Pago esperado</th>
                                                        <th>Monto pagado</th>
                                                        <th>Monto restante</th>
                                                        <th>Estatus</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="7" style="text-align:left">Total:</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div id="block-paid_out" style="display: none;">
                                <div class="card shadow-lg">
                                    <div class="card-body">
                                        <div id='message-error-save'
                                            class="alert alert-danger alert-dismissible fade show" role='alert'
                                            style="display: none">
                                            <strong id="error-save"></strong>
                                        </div>
                                        <div class="form-row">
                                            <input type="hidden" id="ID_paid_out">
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail4">Fecha de pago</label>
                                                <input type="date" class="form-control" id="date_pay">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail4">Monto de pago</label>
                                                <input type="number" min="1" step="1" class="form-control"
                                                    id="amount_pay">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success btn-block" id="saveApply"><i
                                                class="fas fa-check-circle"></i>
                                            Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="block-edit-scheme" style="display: none;">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Tipo de Pago</label>
                        <input type="hidden" id="ID_scheme_to_edit">
                        <select name="type_scheme" id="type_scheme_e" class="form-control">
                            <option value="1">Por alumno</option>
                            <option value="2">Por semana</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Costo por alumno</label>
                        <input type="number" step="1" min="1" class="form-control" id="cost_student_e"
                            required="required">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Costo por semana</label>
                        <input type="number" step="1" min="1" class="form-control" id="cost_week_e" required="required">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Número de semanas</label>
                        <input type="number" step="1" min="1" class="form-control" id="weeks_e" required="required">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Número de pagos</label>
                        <input type="number" step="1" min="1" class="form-control" id="number_payments_e"
                            required="required">
                    </div>
                </div>
                <button type="button" class="btn btn-success" id="updateScheme" onclick="updateScheme();">
                    <i class="fas fa-check-circle"></i>
                    Actualizar</button>
                    <button class="btn btn-danger" id="cancelSchemeEdit" onclick="cancelSchemeEdit();"><i
                        class="fas fa-exclamation-triangle"></i>
                    Cancelar</button>
            </div>
        </div>
    </div>
    <a class="float" onclick="cancel();" data-bs-toggle="tooltip" data-bs-placement="top" title="Cerrar Generación"><i
            class="fas fa-times-circle my-float"></i></a>
</div>
