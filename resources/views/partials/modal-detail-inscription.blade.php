<div class="modal fade" id="modalInscriptionRecent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles De Inscripción</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <div id='message-error' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error"></strong>
                    </div>
                    <form id="form">
                        <input type="hidden" id="idInscription">
                        <div id="invoice">

                            <div class="toolbar hidden-print">
                                {{-- <div class="text-right">
                                    <button class="btn btn-success" id="readMark"><i class="fa fa-check"></i> Marcar como procesada</button>
                                    <button class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Enviar recibo por Email</button>
                                </div> --}}
                                <hr>
                            </div>
                            <div class="invoice overflow-auto">
                                <div style="min-width: 600px">
                                    <main>
                                        <div class="row contacts">
                                            <div class="col invoice-to">
                                                <div class="text-gray-light">INSCRIPCIÓN DE:</div>
                                                <h2 class="to" id="student"></h2>
                                                <div class="address" id="curp"></div>
                                                <div class="email" id="email"></div>
                                            </div>
                                        </div>
                                       <div class="table-responsive">
                                            <table border="0" cellspacing="0" cellpadding="0">
                                            <thead>
                                                <tr>
                                                    <th class="text-right">DIPLOMADO</th>
                                                    <th class="text-right">DESCUENTO APLICADO</th>
                                                    <th class="text-right">COSTO FINAL</th>
                                                    <th class="text-right">IMPORTE DE INSCRIPCIÓN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="no" id="diplomat"></td>
                                                    <td class="unit" id="discount"></td>
                                                    <td class="unit" id="final_cost"></td>
                                                    <td class="total" id="payment"></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                       </div>
                                       <br>
                                       <br>
                                       <br>
                                       <br>
                                       <br>
                                        <div class="notices">
                                            <div>NOTA:</div>
                                            <div class="notice">Al terminar de validar la nueva inscripción y haber enviado el comprobante del pago vía email, favor de marcar como <strong>procesada la inscripción</strong>.</div>
                                        </div>
                                    </main>
                                </div>
                                <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal" onclick="clearData()">Cerrar</button>
            </div>
        </div>
    </div>
</div>
