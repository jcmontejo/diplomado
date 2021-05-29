<!-- Modal -->
<div class="modal fade" id="mdlDetallePago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-center" id="exampleModalLabel">DETALLE DE PAGO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <style>
                    .demo {
                        width: 100%;
                        height: 100%;
                        border: 1px solid #C0C0C0;
                        border-collapse: collapse;
                        padding: 5px;
                    }

                    .demo th {
                        border: 1px solid #C0C0C0;
                        padding: 5px;
                        background: #2F789D;
                    }

                    .demo td {
                        border: 1px solid #C0C0C0;
                        padding: 5px;
                    }

                </style>
                <table class="demo">
                    <thead>
                        <tr>
                            <th>CUENTA DESTINO</th>
                            <th>FECHA DE PAGO</th>
                            <th>MÉTODO DE PAGO</th>
                            <th>MONTO RECIBIDO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span id="cuentaDestino"></span></td>
                            <td><span id="fechaPago"></span></td>
                            <td><span id="metodoPago"></span></td>
                            <td><span id="montoRecibido"></span></td>
                            <td><button class="btn btn-primary" onclick="editarPago();"><i
                                        class="fas fa-edit"></i></button></td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <div id="block-editar_pago" style="display: none;">
                    <div class="mb-2 bg-primary text-white text-center">EDITAR PAGO</div>
                    <form>
                        <input type="hidden" id="ID_PAGO_EDITAR">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Digita tu Clave Maestra</label>
                            <input type="password" class="form-control form-control-lg" id="psdMasterEditarPago" placeholder="****************">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">CUENTA DESTINO</label>
                            <select class="form-control" id="cuentaDestinoEditar">
                                @forelse ($cuentas as $cuenta)
                                    <option value="{{ $cuenta->id }}">
                                        {{ $cuenta->account_name }}</option>
                                @empty
                                    <option value="0">NO hay registros.</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect2">FECHA DE PAGO</label>
                            <input type="date" class="form-control" id="fechaPagoEditar">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">MÉTODO DE PAGO</label>
                            <select class="form-control" id="metodoPagoEditar">
                                @forelse ($metodos as $metodo)
                                    <option value="{{ $metodo->id }}">{{ $metodo->name }}
                                    </option>
                                @empty
                                    <option value="0">NO hay registros.</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">MONTO RECIBIDO</label>
                            <input type="number" min="1" step="any" class="form-control" id="montoRecibidoEditar">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success btn-block" onclick="actualizarPago();"><i class="fas fa-check-square"></i>
                                ACTUALIZAR</button>
                                <button type="button" class="btn btn-secondary btn-block" onclick="cancelarEdicion();"><i class="fas fa-window-close"></i>
                                    CANCELAR</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
