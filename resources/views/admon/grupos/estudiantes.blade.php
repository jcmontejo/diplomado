@extends('layouts.adminLTEAdmon')
@section('title')
@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div id="block-table" style="display: block;">
            <div class="card shadow-lg">
                <div class="card-header bg-header-card">
                    {{ $grupo->nombre }}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="cats" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Seminario</th>
                                    <th>Grupo</th>
                                    <th>Matricula estudiante</th>
                                    <th>Estudiante</th>
                                    <th>Costo seminario</th>
                                    <th>Descuento</th>
                                    <th>Primer pago</th>
                                    <th>Falta por pagar</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($estudiantes as $estudiante)
                                    <tr @if ($estudiante->deuda <= 0)
                                        class="bg-success-custom"
                                    @endif>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary"
                                                    value="{{ $estudiante->ID }}"
                                                    onClick="datosPagosSeminario({{ $estudiante->ID }});"
                                                    data-toggle="tooltip" data-placement="top" title="Pagos"><i
                                                        class="fa fa-cash-register"></i>
                                                </button>
                                                <button type="button" value="{{ $estudiante->ID }}"
                                                    OnClick="eliminarEstudiante(this);" class="btn btn-danger"
                                                    data-toggle="tooltip" data-placement="top" title="Eliminar"><i
                                                        class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>{{ $estudiante->seminario }}</td>
                                        <td>{{ $estudiante->grupo }}</td>
                                        <td>{{ $estudiante->matricula }}</td>
                                        <td>{{ $estudiante->estudiante }}</td>
                                        <td>{{ $estudiante->costo_final }}</td>
                                        <td>{{ $estudiante->descuento }}</td>
                                        <td>{{ $estudiante->primer_pago }}</td>
                                        <td>{{ $estudiante->deuda }}</td>
                                        <td>
                                            @if ($estudiante->deuda <= 0)
                                                PAGADO
                                            @else
                                                PENDIENTE
                                            @endif
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="block-payments" style="display: none;">
            <div class="card shadow-lg">
                <div class="card-header py-3 bg-primary">
                    <button type="button" onclick="reset();" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span id="titulo-pago"></span>
                </div>
                <div class="card-body">
                    <div id="block-nuevo-pago" style="display: block;">
                        <button class="btn btn-rounded btn-info mb-3 float-left" id="btnNuevoPago" onclick="nuevoPago();"><i
                                class="fas fa-plus"></i>
                            Agregar Pago</button>
                    </div>
                    <input type="hidden" name="id_inscripcion" id="id_inscripcion">
                    <div class="col d-flex justify-content-center">
                        <style type="text/css">
                            .tg {
                                border-collapse: collapse;
                                border-spacing: 0;
                            }

                            .tg td {
                                border-color: black;
                                border-style: solid;
                                border-width: 1px;
                                font-family: Arial, sans-serif;
                                font-size: 16px;
                                overflow: hidden;
                                padding: 10px 5px;
                                word-break: normal;
                            }

                            .tg th {
                                border-color: black;
                                border-style: solid;
                                border-width: 1px;
                                font-family: Arial, sans-serif;
                                font-size: 14px;
                                font-weight: normal;
                                overflow: hidden;
                                padding: 10px 5px;
                                word-break: normal;
                            }

                            .tg .tg-0lax {
                                text-align: left;
                                vertical-align: top
                            }

                        </style>
                        <table class="tg">
                            <thead>
                                <tr>
                                    <th class="tg-0lax" colspan="3"><span id="seminario"></span></th>
                                    <th class="tg-0lax" colspan="2"><span id="fecha"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="tg-0lax"><strong>Costo seminario: </strong> <span id="costo"></span></td>
                                    <td class="tg-0lax"><strong>Vendido en: </strong><span id="vendido"></span></td>
                                    <td class="tg-0lax"><strong>Total pagado: </strong> <span id="pagado"></span></td>
                                    <td class="tg-0lax"><strong>Por pagar: </strong><span id="debe"></span></td>
                                    <td class="tg-0lax"><strong>Vendedor: </strong><span id="vendedor"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div id="lista-pagos">
                        <style>
                            .submit-btn {
                                color: #ffffff;
                                background: #EA1C74;
                                Padding: 6px 12px;
                                font: 16px;
                            }

                        </style>
                        <div class="row">
                            <div class="col-md-6">
                                <div id="pendientes">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="pagar" style="display: none;">
                                    <input type="hidden" id="ID_PAGAR">
                                    <div class="pr-lg-0 pr-xl-3">
                                        <div class="row no-gutters p-2 border border-bottom-0">
                                            <div class="form-group w-100 mb-0">
                                                <label class="w-100 font-weight-bold size-14">Digita monto a
                                                    pagar</label>
                                                <div class="input-group mb-2">
                                                    <input id="montoUNo" onkeyup="aplicarMonto();" type="number" min="1"
                                                        step="any" class="form-control d-inline" value="">

                                                    <!--<div class="input-group-append dropleft">
                                                                        <button id="agregarMontoUno" class="btn btn-outline-primary" type="button"
                                                                            onclick="aplicarMonto();">Aplicar</button>
                                                                    </div>-->
                                                </div>
                                            </div>
                                            <div class="form-group w-100 mb-0">
                                                <label class="w-100 font-weight-bold size-14">Selecciona fecha de
                                                    pago</label>
                                                <div class="input-group mb-2">
                                                    <input type="date" class="form-control" name="fecha_pago"
                                                        id="fecha_pago"
                                                        value="{{ \Carbon\Carbon::now()->toDateString() }}">
                                                </div>
                                            </div>
                                            <div class="form-group w-100 mb-0">
                                                <label class="w-100 font-weight-bold size-14">Selecciona método de
                                                    pago</label>
                                                <div class="input-group mb-2">
                                                    <select name="metodo_pago" id="metodo_pago" class="form-control">
                                                        @forelse ($metodos as $metodo)
                                                            <option value="{{ $metodo->id }}">{{ $metodo->name }}
                                                            </option>
                                                        @empty
                                                            <option value="0">NO hay registros.</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group w-100 mb-0">
                                                <label class="w-100 font-weight-bold size-14">Selecciona cuenta destino
                                                    del
                                                    pago</label>
                                                <div class="input-group mb-2">
                                                    <select name="cuenta_destino" id="cuenta_destino" class="form-control">
                                                        @forelse ($cuentas as $cuenta)
                                                            <option value="{{ $cuenta->id }}">
                                                                {{ $cuenta->account_name }}</option>
                                                        @empty
                                                            <option value="0">NO hay registros.</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row no-gutters p-2 border border-bottom-0">
                                            <p class="w-100 font-weight-bold size-14">Resumen de pago</p>
                                            <table class="w-100 size-14">
                                                <tbody>
                                                    <tr>
                                                        <td class="size-16"><b>Total*</b></td>
                                                        <td class="size-16 text-right"><b id="total">$0.00 MXN</b></td>
                                                        <input type="hidden" id="total_enviar">
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row no-gutters p-2 mb-3 border bg-light">
                                            <button class="btn btn-block btn-primary p-2" id="btnGoToCheckout"
                                                onclick="aplicarPago();">Realizar
                                                pago</button>
                                            <button class="btn btn-block btn-secondary"
                                                onclick="cancelarPago();">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admon.grupos.create')
        @include('admon.grupos.edit')
    </div><!-- /.container-fluid -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            reload();
        });

        function reload() {
            $('#cats').each(function() {
                dt = $(this).dataTable({
                    dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
        ]
                });
                dt.fnDraw();
            })
        }

        function datosPagosSeminario(id) {
            var ID = id;
            var route = '{{ url('/admon/CATgrupos/datos/pagos') }}/' + ID;
            Notiflix.Loading.Dots('Procesando...');
            $("#block-table").css("display", "none");
            $("#block-payments").css("display", "block");

            $.get(route, function(data) {
                Notiflix.Loading.Remove();
                console.log(data);
                $("#titulo-pago").text(data.estudiante.enrollment + '-' + data.estudiante.last_name + '/' + data
                    .estudiante.mother_last_name + ' ' + data.estudiante.name);
                $("#seminario").html('<strong>Seminario: </strong> ' + data.seminario.nombre + ' ' +
                    '<strong>Grupo: </strong>' + data.grupo.nombre);
                $("#fecha").html('<strong>Fecha de inscripción: </strong>' + data.inscripcion.created_at);
                $("#costo").text(data.seminario.precio_venta);
                $("#vendido").text(data.inscripcion.costo_final);
                $("#pagado").text(data.inscripcion.costo_final - data.deuda.monto);
                $("#debe").text(data.deuda.monto);
                if (data.deuda.monto <= 0) {
                    $("#block-nuevo-pago").css("display", "none");
                }
                $("#vendedor").text(data.vendedor.name);
                $("#id_inscripcion").val(data.inscripcion.id);

                $("#pendientes").empty();
                if (data.deuda.monto <= 0) {
                    
                }else{
                    $.each(data.pagos, function(key, value) {
                    var pendientes = '';
                    if (value.activo) {
                        pendientes +=
                            '<button type="button" onClick="mostrarFormularioPago(' + value.id +
                            ');" class="btn btn-block btn-outline-secondary h-100">';
                    } else {
                        pendientes +=
                            '<button type="button" onClick="mostrarFormularioPago(' + value.id +
                            ');" class="btn btn-block btn-success h-100" disabled>';
                    }
                    pendientes += '<p class="mb-0 size-24">';
                    pendientes += '<i class="fas fa-cash-register"></i>';
                    pendientes += '</p>';
                    if (value.activo) {
                        pendientes += '<p class="mb-0 size-12"><span>Pago número ' + value.numero_de_pago +
                            '<br>Click para pagar</span></p>';
                    } else {
                        pendientes += '<p class="mb-0 size-12"><span>Pago número ' + value.numero_de_pago +
                            '<br>Pago cubierto</span></p>';
                    }
                    pendientes += '</button>';
                    $("#pendientes").append(pendientes);
                });
                }
            });
        }

        function mostrarFormularioPago(id) {
            $("#pagar").css("display", "block");
            $("#ID_PAGAR").val(id);
        }

        function cancelarPago() {
            $('#pagar').css('display', 'none');
        }

        function aplicarMonto() {
            var montouNo = $("#montoUNo").val();
            $("#subtotal").text(montouNo);
            $("#total").text('$ ' + montouNo + ' MXN');
            $("#total_enviar").val(montouNo);
        }

        function reset() {
            $("#block-table").css("display", "block");
            $("#block-payments").css("display", "none");
            $("#pagar").css("display", "none");
            $('#message-error-save').css('display', 'none');
            location.reload();
        }

        function aplicarPago() {
            var monto_aplicar = $("#montoUNo").val();
            let id_pago = $("#ID_PAGAR").val();
            var monto = $("#total_enviar").val();
            var fecha_pago = $("#fecha_pago").val();
            var metodo_pago = $("#metodo_pago").val();
            var cuenta_destino = $("#cuenta_destino").val();

            var route = '/admon/CATgrupos/recibir/pago/';

            if (monto_aplicar != "") {
                $.ajax({
                    url: route,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id_pago: id_pago,
                        monto: monto,
                        fecha_pago: fecha_pago,
                        metodo_pago: metodo_pago,
                        cuenta_destino: cuenta_destino
                    },
                    beforeSend: function() {
                        Notiflix.Loading.Dots('Procesando...');
                    },
                    success: function(data) {
                        Notiflix.Loading.Remove();
                        $('#message-error-save').css('display', 'none');
                        Notiflix.Report.Success('Bien hecho', 'Has guardado un nuevo pago.', 'Click');
                        datosPagosSeminario(data.i.id);
                        $("#montoUNo").val("");
                        cancelarPago();
                        //reload();
                        console.log(data);
                    },
                    error: function(data) {
                        Notiflix.Loading.Remove();
                        Notiflix.Report.Failure('Algo salió mal', 'Revisa tu información', 'Cerrar');
                        var response = JSON.parse(data.responseText);
                        var errorString = "<ul>";
                        $.each(response.errors, function(key, value) {
                            errorString += "<li>" + value + "</li>";
                        });
                        $("#error-save").html(errorString);
                        $("#message-error-save").fadeIn();
                    }
                });
            } else {
                Notiflix.Notify.Failure('El monto del pago no puede estar vacío o ser zero.');
            }
        }

        function storeCat() {
            var nombre = $("#txNombre").val();

            var route = "/admon/CATgrupos/guardar";

            var form = $("#form-cat");

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    nombre: nombre
                },
                beforeSend: function() {
                    Notiflix.Loading.Dots('Procesando...');
                },
                success: function() {
                    Notiflix.Loading.Remove();
                    $('#message-error-save').css('display', 'none');
                    Notiflix.Report.Success('Bien hecho', 'Has guardado un nuevo grupo.', 'Click');
                    reload();
                    document.getElementById("form-cat").reset();
                    $("#block-table").css("display", "block");
                    $("#block-create").css("display", "none");
                },
                error: function(data) {
                    Notiflix.Loading.Remove();
                    Notiflix.Report.Failure('Algo salió mal', 'Revisa tu información', 'Cerrar');
                    var response = JSON.parse(data.responseText);
                    var errorString = "<ul>";
                    $.each(response.errors, function(key, value) {
                        errorString += "<li>" + value + "</li>";
                    });
                    $("#error-save").html(errorString);
                    $("#message-error-save").fadeIn();
                }
            });
        }

        function nuevoPago() {
            var id_inscripcion = $("#id_inscripcion").val();
            var route = "/admon/CATgrupos/agregar/pago/";
            Notiflix.Confirm.Show(
                'Cuotas de estudiante',
                '¿Esta seguro de agregar otro pago?',
                'Si',
                'No',
                function() {
                    $.ajax({
                            url: route,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id_inscripcion: id_inscripcion
                            },
                        })
                        .done(function(response) {
                            datosPagosSeminario(response.id);
                            Notiflix.Report.Success('Bien hecho', 'Has agregado un nuevo pago.',
                                'Click');
                        })
                        .fail(function() {
                            Notiflix.Report.Failure('Oooops!', 'Algo salio mal con la petición.',
                                'Click');
                        });
                },
                function() { // No button callback
                    Notiflix.Notify.Warning('Petición cancelada.');
                }
            );
        }

        function eliminarEstudiante(btn) {
            var id = btn.value;
            var route = "/admon/CATgrupos/estudiante/eliminar/" + id;
            Notiflix.Confirm.Show(
                'Cuotas Estudiantes',
                '¿Esta seguro de eliminar este alumno del grupo?',
                'Si',
                'No',
                function() {
                    $.ajax({
                            url: route,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'DELETE',
                            dataType: 'json',
                            data: {
                                id: id
                            },
                        })
                        .done(function(response) {
                            location.reload();
                            Notiflix.Report.Success('Bien hecho', 'Has eliminado un registro.',
                                'Click');
                        })
                        .fail(function() {
                            Notiflix.Report.Failure('Oooops!', 'Algo salio mal con la petición.',
                                'Click');
                        });
                },
                function() { // No button callback
                    Notiflix.Notify.Warning('Petición cancelada.');
                }
            );
        }

    </script>
@endsection
