<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Gasto</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <div id='message-error-edit' class="alert alert-danger alert-dismissible fade show" role='alert'
                        style="display: none">
                        <strong id="error-edit"></strong>
                    </div>
                    <form id="form" enctype="multipart/form-data">
                        <input type="hidden" id="id">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Concepto de Gasto</label>
                                <select class="form-control form-control-lg" name="concept" id="concept">
                                    <option>Artículos de Limpieza</option>
                                    <option>Audio/Visual Marketing</option>
                                    <option>Cafetería</option>
                                    <option>Combustible</option>
                                    <option>Computadora y Accesorios (Compra de)</option>
                                    <option>Energía Eléctrica (Luz)</option>
                                    <option>Fotocopias</option>
                                    <option>Honorario de Terceros</option>
                                    <option>Impresoras (Compra de)</option>
                                    <option>Letreros y Anuncios Oficinas</option>
                                    <option>Mantenimiento Vehículos</option>
                                    <option>Mantenimiento/Adecuaciones Oficinas</option>
                                    <option>Mobiliario y Equipo Oficinas</option>
                                    <option>Papelería y Artículos de Oficina</option>
                                    <option>Pasajes</option>
                                    <option>Recargar Celular</option>
                                    <option>Renta de Inmuebles</option>
                                    <option>Renta Internet y Telefonía Fija</option>
                                    <option>Servicio Agua Oficinas</option>
                                    <option>Software (Compra de)</option>
                                    <option>Toner o Cartuchos de Impresora</option>
                                    <option>Viáticos</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Monto</label>
                                <input type="number" step="0.01" class="form-control form-control-lg" id="amount"
                                    placeholder="Introduce monto del gasto">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Descripción</label>
                                <textarea class="form-control" name="description" id="description" cols="30"
                                    rows="3"></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Comprobante de Gasto</label>
                                <input type="file" name="voucher" id="voucher" class="form-control form-control-lg">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Usuario</label>
                                <select name="user" id="user" class="form-control form-control-lg">
                                    <option value="">---Selecciona una usuario---</option>
                                    @forelse ($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @empty
                                        <option value="">No hay usuarios registradas.</option>
                                    @endforelse
                                </select>
                            </div>
                             <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Seleccionar Cuenta</label>
                                <select name="account" id="account" class="form-control form-control-lg">
                                    <option value="">---Selecciona una cuenta---</option>
                                    @forelse ($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->account_name}}</option>
                                    @empty
                                        <option value="">No hay cuentas registradas.</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="updateExpense" class="btn btn-primary mt-4 pr-4 pl-4" name="updateExpense">Guardar</a>
            </div>
        </div>
    </div>
</div>
