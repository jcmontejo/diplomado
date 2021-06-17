@extends('layouts.adminLTEAux')
@section('title')
@section('content')

    <div class="container-fluid">
        <!-- DataTales Example -->
        <div id="block-table" style="display: block;">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-primary" value="{{ $generation->id }}"
                    onclick="mostrarPagoDocente({{ $generation->id }});"><i class="fas fa-check"></i> Pagos a
                    docentes</button>
                <button type="button" class="btn btn-secondary"><i class="fas fa-check"></i> Pagos a vendedores</button>
            </div>
            <hr>
            <div class="card shadow-lg">
                <div class="card-header bg-header-card">
                    <h4 class="header-title">DIPLOMADO: {{ $generation->name_diplomat }}</h4>
                    <input type="hidden" name="id_generation" id="id_generation" value="{{ $generation->id }}">
                    <h3 class="header-title">GENERACIÓN: {{ $generation->number_generation }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="cats" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Folio</th>
                                    <th>Matricula</th>
                                    <th>Estudiante</th>
                                    <th>Costo diplomado</th>
                                    <th>Descuento</th>
                                    <th>Primer pago</th>
                                    <th>Falta por pagar</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($estudiantes as $estudiante)
                                    <tr @if ($estudiante->debe <= 0) class="bg-success-custom" @endif>
                                        <td>
                                            <div class="btn-group">
                                                @if ($estudiante->baja)
                                                    <button type="button" class="btn btn-success"
                                                        value="{{ $estudiante->ID }}"
                                                        onClick="reactivarEstudiante({{ $estudiante->ID }});"
                                                        data-toggle="tooltip" data-placement="top" title="Reactivar alumno"><i
                                                            class="fa fa-arrow-circle-up"></i>
                                                    </button>
                                                    <button type="button" value="{{ $estudiante->ID }}"
                                                        OnClick="eliminarEstudiante(this);" class="btn btn-danger"
                                                        data-toggle="tooltip" data-placement="top" title="Eliminar del grupo"><i
                                                            class="fa fa-minus-circle"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-primary"
                                                        value="{{ $estudiante->ID }}"
                                                        onClick="datosPagosDiplomados({{ $estudiante->ID }});"
                                                        data-toggle="tooltip" data-placement="top" title="Pagos"><i
                                                            class="fa fa-cash-register"></i>
                                                    </button>
                                                    <button type="button" value="{{ $estudiante->ID }}"
                                                        OnClick="editarDatosEstudiante({{ $estudiante->ID }});"
                                                        class="btn btn-info" data-toggle="tooltip" data-placement="top"
                                                        title="Editar"><i class="fa fa-user-edit"></i>
                                                    </button>
                                                    <button type="button" value="{{ $estudiante->ID }}"
                                                        OnClick="bajaEstudiante(this);" class="btn btn-secondary"
                                                        data-toggle="tooltip" data-placement="top" title="Causar Baja"><i
                                                            class="fa fa-undo-alt"></i>
                                                    </button>
                                                    <button type="button" value="{{ $estudiante->ID }}"
                                                        OnClick="eliminarEstudiante(this);" class="btn btn-danger"
                                                        data-toggle="tooltip" data-placement="top" title="Eliminar del grupo"><i
                                                            class="fa fa-minus-circle"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            {{ $estudiante->folio }}
                                        </td>
                                        <td>
                                            {{ $estudiante->matricula }}
                                        </td>
                                        <td>
                                            {{ $estudiante->estudiante }}
                                        </td>
                                        <td>
                                            {{ $estudiante->costo_final }}
                                        </td>
                                        <td>
                                            {{ $estudiante->descuento }}
                                        </td>
                                        <td>
                                            {{ $estudiante->primer_pago }}
                                        </td>
                                        <td>
                                            {{ $estudiante->debe }}
                                        </td>
                                        <td>
                                            @if ($estudiante->debe <= 0)
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
                                            <button class="btn btn-block btn-info p-2" data-toggle="modal" data-target="#modalConvenio"
                                                onclick="mostrarModalConvenio();">Convenio de Pago</button>
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

        <div id="block-pagos-docentes" style="display: none;">
            <div class="card shadow-lg">
                <div class="card-header py-3 bg-primary">
                    <button type="button" onclick="reset();" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    MÓDULO PAGO A DOCENTES
                </div>
                <div class="card-body">
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
                                font-size: 14px;
                                overflow: hidden;
                                padding: 7px 16px;
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
                                padding: 7px 16px;
                                word-break: normal;
                            }

                            .tg .tg-0pky {
                                border-color: inherit;
                                text-align: left;
                                vertical-align: top
                            }

                            .tg .tg-0lax {
                                text-align: left;
                                vertical-align: top
                            }

                        </style>
                        <table class="tg">
                            <thead>
                                <tr>
                                    <th class="tg-0pky">Tipo de pago: <span id="tipo_pago"></span></th>
                                    <th class="tg-0pky">A pagar por estudiante: <span id="por_estudiante"></span></th>
                                    <th class="tg-0pky">Número de estudiantes: <span id="total_estudiantes"></span></th>
                                    <th class="tg-0lax">A pagar por semana : <span id="por_semana"></span></th>
                                    <th class="tg-0lax">Número de semanas: <span id="total_semanas"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="tg-0pky">Diplomado: <span id="diplomado_d"></span></td>
                                    <td class="tg-0pky">Generación: <span id="generacion_d"></span></td>
                                    <td class="tg-0pky">Docente: <span id="docente"></span></td>
                                    <td class="tg-0lax" colspan="2">
                                        <button class="btn btn-info btn-block"><i class="fas fa-sync-alt"></i> RE
                                            CALCULAR</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="col-4">
                            <h4>TOTAL A PAGAR: <span id="a_pagar_final"></span></h4>
                        </div>
                        <div class="col-4">
                            <h4>TOTAL PAGADO: <span id="t_pagado"></span></h4>
                        </div>
                        <div class="col-4">
                            <h4>FALTA POR PAGAR: <span id="f_pagar"></span></h4>
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="col-6">
                            PAGOS
                        </div>
                        <div class="col-6">
                            <div id="pagar_docentes" style="display: block;">
                                <div class="pr-lg-0 pr-xl-3">
                                    <div class="row no-gutters p-2 border border-bottom-0">
                                        <div class="form-group w-100 mb-0">
                                            <label class="w-100 font-weight-bold size-14">Digita monto a
                                                pagar</label>
                                            <div class="input-group mb-2">
                                                <input id="" onkeyup="aplicarMontoDocente();" type="number" min="1"
                                                    step="any" class="form-control d-inline" value="">
                                            </div>
                                        </div>
                                        <div class="form-group w-100 mb-0">
                                            <label class="w-100 font-weight-bold size-14">Selecciona fecha de
                                                pago</label>
                                            <div class="input-group mb-2">
                                                <input type="date" class="form-control" name="" id=""
                                                    value="{{ \Carbon\Carbon::now()->toDateString() }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters p-2 border border-bottom-0">
                                        <p class="w-100 font-weight-bold size-14">Resumen de pago</p>
                                        <table class="w-100 size-14">
                                            <tbody>
                                                <tr>
                                                    <td class="size-16"><b>Total*</b></td>
                                                    <td class="size-16 text-right"><b id="">$0.00 MXN</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row no-gutters p-2 mb-3 border bg-light">
                                        <button class="btn btn-block btn-success p-2" id="btnGoToCheckout"
                                            onclick="aplicarPagoDocente();">Realizar
                                            pago</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="block-pagos-vendedores" style="display: none;">

        </div>

        <div id="block-editar" style="display: none;">
            <div class="card">
                <div class="card-header py-3">
                    <button class="btn btn-rounded btn-danger mb-3 float-right" id="" onclick="reset();"><i
                            class="fas fa-window-close"></i>
                        Cancelar</button>
                </div>
                <div class="card-body">
                    <input type="hidden" name="ID_INS_EDITAR" id="ID_INS_EDITAR">
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <input type="hidden" id="id">
                            <label for="exampleInputEmail1">Selecciona Diplomado</label>
                            <select name="diplomat_id_e" id="diplomat_id_e" class="form-control form-control-lg">
                                @forelse ($diplomats as $diplomat)
                                    <option value="{{ $diplomat->id }}">{{ $diplomat->name }}</option>
                                @empty
                                    <option value="0">No hay diplomados registrados.</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputPassword1">Selecciona Generación</label>
                            <select name="generation_id_e" id="generation_id_e" class="form-control form-control-lg">
                                @forelse ($generations as $generation)
                                    <option value="{{ $generation->id }}">{{ $generation->number_generation }}</option>
                                @empty
                                    <option value="0">No hay generaciones registrados.</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Descuento</label>
                            <input type="number" value="0" min="1" step="1" id="discount_e" name="discount_e"
                                class="form-control form-control-lg">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Número de Pagos</label>
                            <input type="number" value="1" min="1" max="10" step="1" id="number_payments_e"
                                name="number_payments_e" class="form-control form-control-lg">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">¿De cuanto seran los pagos?</label>
                            <input type="text" name="amount_of_payments_e" id="amount_of_payments_e"
                                class="form-control form-control-lg">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Monto Primer Pago</label>
                            <input type="number" value="0" min="0" name="first_payment_e" id="first_payment_e"
                                class="form-control form-control-lg">
                        </div>
                    </div>
                    <div class="row">
                        <button type="button" id="editarDatosEstudiante" name="editarDatosEstudiante"
                            class="btn btn-block btn-success"><i class="fas fa-user-edit"></i> ACTUALIZAR DATOS</button>
                    </div>
                </div>
            </div>
        </div>
        @include('admon.grupos.create')
        @include('admon.grupos.edit')
        @include('auxiliar.generations.modal-convenio')
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
                    lengthMenu: [
                        [25, 100, -1],
                        [25, 100, "Todos"]
                    ],
                    pageLength: 25,
                    dom: 'lBfrtip',
                    buttons: [{
                        extend: 'excel',
                        text: '<span class="fas fa-file-excel-o"></span> Exportar Excel',
                        exportOptions: {
                            modifier: {
                                search: 'applied',
                                order: 'applied'
                            }
                        }
                    }]
                });
                dt.fnDraw();
            })
        }

        function datosPagosDiplomados(id) {
            var ID = id;
            var route = '{{ url('/admon/CATdiplomados/datos/pagos') }}/' + ID;
            Notiflix.Loading.Dots('Procesando...');
            $("#block-table").css("display", "none");
            $("#block-payments").css("display", "block");

            $.get(route, function(data) {
                Notiflix.Loading.Remove();
                console.log(data);
                $("#titulo-pago").text(data.estudiante.enrollment + '-' + data.estudiante.last_name + '/' + data
                    .estudiante.mother_last_name + ' ' + data.estudiante.name);
                $("#seminario").html('<strong>Diplomado: </strong> ' + data.diplomado.name + ' ' +
                    '<strong>Generación: </strong>' + data.generacion.number_generation);
                $("#fecha").html('<strong>Fecha de inscripción: </strong>' + data.inscripcion.created_at);
                $("#costo").text(data.diplomado.cost);
                $("#vendido").text(data.inscripcion.final_cost);
                $("#pagado").text(data.inscripcion.final_cost - data.deuda.amount);
                $("#debe").text(data.deuda.amount);
                if (data.deuda.amount <= 0) {
                    $("#block-nuevo-pago").css("display", "none");
                }
                $("#vendedor").text(data.vendedor.name);
                $("#id_inscripcion").val(data.inscripcion.id);

                $("#pendientes").empty();
                $.each(data.pagos, function(key, value) {
                    var pendientes = '';
                    if (value.status == 'PENDIENTE') {
                        if (value.convenio) {
                            pendientes +=
                            '<button type="button" onClick="mostrarFormularioPago(' + value.id +
                            ');" class="btn btn-block btn-outline-warning h-100">';
                        } else {
                            pendientes +=
                            '<button type="button" onClick="mostrarFormularioPago(' + value.id +
                            ');" class="btn btn-block btn-outline-secondary h-100">';
                        }
                    } else {
                        pendientes +=
                            '<button type="button" onClick="mostrarFormularioPago(' + value.id +
                            ');" class="btn btn-block btn-success h-100" disabled>';
                    }
                    pendientes += '<p class="mb-0 size-24">';
                    pendientes += '<i class="fas fa-cash-register"></i>';
                    pendientes += '</p>';
                    if (value.status == 'PENDIENTE') {
                        if (value.convenio) {
                            pendientes += '<p class="mb-0 size-12"><span>Pago número ' + value.number_payment +
                            ' [CONVENIO ACTIVO]<br>Click para pagar</span></p>';
                        } else {
                            pendientes += '<p class="mb-0 size-12"><span>Pago número ' + value.number_payment +
                            '<br>Click para pagar</span></p>';
                        }
                    } else {
                        pendientes += '<p class="mb-0 size-12"><span>Pago número ' + value.number_payment +
                            '<br>Pago cubierto</span></p>';
                    }
                    pendientes += '</button>';
                    $("#pendientes").append(pendientes);
                });

            });
        }

        function datosPagosDiplomados(id) {
            var ID = id;
            var route = '{{ url('/admon/CATdiplomados/datos/pagos') }}/' + ID;
            Notiflix.Loading.Dots('Procesando...');
            $("#block-table").css("display", "none");
            $("#block-payments").css("display", "block");

            $.get(route, function(data) {
                Notiflix.Loading.Remove();
                console.log(data);
                $("#titulo-pago").text(data.estudiante.enrollment + '-' + data.estudiante.last_name + '/' + data
                    .estudiante.mother_last_name + ' ' + data.estudiante.name);
                $("#seminario").html('<strong>Diplomado: </strong> ' + data.diplomado.name + ' ' +
                    '<strong>Generación: </strong>' + data.generacion.number_generation);
                $("#fecha").html('<strong>Fecha de inscripción: </strong>' + data.inscripcion.created_at);
                $("#costo").text(data.diplomado.cost);
                $("#vendido").text(data.inscripcion.final_cost);
                $("#pagado").text(data.inscripcion.final_cost - data.deuda.amount);
                $("#debe").text(data.deuda.amount);
                if (data.deuda.amount <= 0) {
                    $("#block-nuevo-pago").css("display", "none");
                }
                $("#vendedor").text(data.vendedor.name);
                $("#id_inscripcion").val(data.inscripcion.id);

                $("#pendientes").empty();
                $.each(data.pagos, function(key, value) {
                    var pendientes = '';
                    if (value.status == 'PENDIENTE') {
                        pendientes +=
                            '<button type="button" onClick="mostrarFormularioPago(' + value.id +
                            ');" class="btn btn-block btn-outline-secondary h-100">';
                    } else {
                        pendientes +=
                            '<button type="button" onClick="detalleDePago(' + value.id +
                            ');" class="btn btn-block btn-success h-100" data-toggle="modal" data-target="#mdlDetallePago">';
                    }
                    pendientes += '<p class="mb-0 size-24">';
                    pendientes += '<i class="fas fa-cash-register"></i>';
                    pendientes += '</p>';
                    if (value.status == 'PENDIENTE') {
                        pendientes += '<p class="mb-0 size-12"><span>Pago número ' + value.number_payment +
                            '<br>Click para pagar</span></p>';
                    } else {
                        pendientes += '<p class="mb-0 size-12"><span>Pago número ' + value.number_payment +
                            '<br>Pago cubierto</span></p>';
                    }
                    pendientes += '</button>';
                    $("#pendientes").append(pendientes);
                });

            });
        }
        
        function detalleDePago(id) {
            route = '/admon/CATdiplomados/detalle/pago/' + id;
            Notiflix.Loading.Dots('Procesando...');
            $.get(route, function(data) {
                Notiflix.Loading.Remove();
                console.log(data);
                //Tabla con información
                $("#cuentaDestino").text(data.detalle_pago.cuentaDestino);
                $("#fechaPago").text(data.detalle_pago.fechaPago);
                $("#metodoPago").text(data.detalle_pago.metodoPago);
                $("#montoRecibido").text(data.detalle_pago.montoRecibido);
                //Formulario de edición
                $("#ID_PAGO_EDITAR").val(data.detalle_pago.id_pago);
                $("#cuentaDestinoEditar").val(data.detalle_pago.idCuentaDestino).change();
                $("#fechaPagoEditar").val(data.detalle_pago.fechaPago);
                $("#metodoPagoEditar").val(data.detalle_pago.idMetodoPago).change();
                $("#montoRecibidoEditar").val(data.detalle_pago.montoRecibido);
            });
        }

        function editarPago() {
            Notiflix.Loading.Dots('Procesando...');
            $("#block-editar_pago").css("display", "block");
            Notiflix.Loading.Remove();
        }

        function actualizarPago() {
            var route = '/admon/CATdiplomados/estudiantes/editar/pago';
            var id_pago = $("#ID_PAGO_EDITAR").val();
            var cuenta_destino = $("#cuentaDestinoEditar").val();
            var fecha_pago = $("#fechaPagoEditar").val();
            var metodo_pago = $("#metodoPagoEditar").val();
            var monto = $("#montoRecibidoEditar").val();
            //checkPsd
            var psd = $("#psdMasterEditarPago").val();
            var route_psd = "/admon/consultar/contrasenia/" + psd;
            console.log(psd);
            if (psd != "") {
                $.get(route_psd, function(res) {
                    if (res.success == true) {
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
                        datosPagosDiplomados(data.i.id);
                        $("#montoUNo").val("");
                        cancelarPago();
                        //reload();
                        console.log(data);
                        $("#mdlDetallePago .close").click();
                        $("#block-editar_pago").css("display", "none");
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
                        alert('Clave maestra incorrecta.');
                    }
                });

            } else {
                alert('Por favor llena el campo de clave maestra.');
            }
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
            $("#block-pagos-docentes").css("display", "none");
            $("#block-pagos-vendedores").css("display", "none");
            $("#block-editar").css("display", "none");
            $("#pagar").css("display", "none");
            $('#message-error-save').css('display', 'none');
            s
            location.reload();
        }

        function editarDatosEstudiante(id) {
            $("#ID_INS_EDITAR").val(id);

            var route = '{{ url('/admon/CATdiplomados/datos/pagos') }}/' + id;
            Notiflix.Loading.Dots('Procesando...');
            $("#block-table").css("display", "none");
            $("#block-editar").css("display", "block");

            $.get(route, function(data) {
                Notiflix.Loading.Remove();
                console.log(data);
                $("#diplomat_id_e").val(data.inscripcion.diplomat_id).change();
                $("#generation_id_e").val(data.inscripcion.generation_id).change();
                $("#discount_e").val(data.inscripcion.discount);
                $("#number_payments_e").val(data.inscripcion.number_of_payments);
                $("#first_payment_e").val(data.inscripcion.first_payment)
                $("#amount_of_payments_e").val(data.inscripcion.amount_of_payments);
            });
        }

        $("#editarDatosEstudiante").click(function() {
            var inscripcion_id = $("#ID_INS_EDITAR").val();

            var diplomat_id = $("#diplomat_id_e").val();
            var generation_id = $("#generation_id_e").val();
            var discount = $("#discount_e").val();
            var number_payments = $("#number_payments_e").val();
            var first_payment = $("#first_payment_e").val();
            var amount_of_payments = $("#amount_of_payments_e").val();

            var route = "/admon/alumnos/editarInscripcionDiplomado";

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    //Datos alumno
                    inscripcion_id: inscripcion_id,
                    //Datos seminario
                    diplomat_id: diplomat_id,
                    generation_id: generation_id,
                    discount: discount,
                    number_payments: number_payments,
                    first_payment: first_payment,
                    amount_of_payments: amount_of_payments,
                },
                beforeSend: function() {
                    $("#preloader").css("display", "block");
                },
                success: function() {
                    $("#preloader").css("display", "none");
                    $("#modalInscriptionSeminario .close").click();
                    $('#message-error-save-N').css('display', 'none');
                    Notiflix.Report.Success('Bien hecho', 'Has editado los datos del alumno.',
                        'Click');
                    location.reload();
                },
                error: function(data) {
                    var response = JSON.parse(data.responseText);
                    var errorString = "<ul>";
                    $.each(response.errors, function(key, value) {
                        errorString += "<li>" + value + "</li>";
                    });
                    $("#preloader").css("display", "none");
                    $("#error-save-N").html(errorString);
                    $("#message-error-save-N").fadeIn();
                }
            });
        })

        function aplicarPago() {
            var monto_aplicar = $("#montoUNo").val();
            let id_pago = $("#ID_PAGAR").val();
            var monto = $("#total_enviar").val();
            var fecha_pago = $("#fecha_pago").val();
            var metodo_pago = $("#metodo_pago").val();
            var cuenta_destino = $("#cuenta_destino").val();

            var route = '/admon/CATdiplomados/recibir/pago/';

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
                        datosPagosDiplomados(data.i.id);
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
            var route = "/admon/CATdiplomados/agregar/pago/";
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
                            datosPagosDiplomados(response.id);
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

        function bajaEstudiante(btn) {
            var id = btn.value;

            var route = "/admon/generaciones/alumnos/CAUSARBAJA/" + id;
            Notiflix.Confirm.Show(
                'Cuotas Estudiantes',
                '¿Esta seguro de dar de baja a este alumno del grupo?',
                'Si',
                'No',
                function() {
                    $.ajax({
                            url: route,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'PUT',
                            dataType: 'json',
                            data: {
                                id: id
                            },
                        })
                        .done(function(response) {
                            location.reload();
                            Notiflix.Report.Success('Bien hecho', 'Has dado de baja un registro.',
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

        function reactivarEstudiante(btn) {
            var id = btn;
            console.log(btn);
            var route = "/admon/generaciones/alumnos/REACTIVAR/" + id;
            Notiflix.Confirm.Show(
                'Cuotas Estudiantes',
                '¿Esta seguro de re activar a este alumno al grupo?',
                'Si',
                'No',
                function() {
                    $.ajax({
                            url: route,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'PUT',
                            dataType: 'json',
                            data: {
                                id: id
                            },
                        })
                        .done(function(response) {
                            location.reload();
                            Notiflix.Report.Success('Bien hecho', 'Has re activado un registro.',
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

            var route = "/admon/generaciones/alumnos/ELIMINARDEFINITIVO/" + id;
            Notiflix.Confirm.Show(
                'Cuotas Estudiantes',
                '¿Esta seguro de dar eliminar a este alumno del grupo?',
                'Si',
                'No',
                function() {
                    $.ajax({
                            url: route,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'PUT',
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


        // Funciones para pagar a docentes
        function mostrarPagoDocente(id) {
            $("#block-table").css("display", "none");
            $("#block-pagos-docentes").css("display", "block");
            datosPagosDocente(id);
        }

        
        function datosPagosDocente(id) {
            var ID = id;
            var route = '{{ url('/admon/CATdiplomados/datos/pagos/docentes/') }}/' + ID;
            Notiflix.Loading.Dots('Procesando...');
            $("#block-table").css("display", "none");
            $("#block-pagos-docentes").css("display", "block");

            $.get(route, function(data) {
                Notiflix.Loading.Remove();
                console.log(data);
                if (data.e.tipo_pago == 1) {
                    $("#id_esquema_pago").val(data.e.id);
                    $("#tipo_pago").text('PAGO POR ESTUDIANTE');
                    $("#por_estudiante").text(data.e.pago_por_estudiante);
                    $("#total_estudiantes").text(data.e.total_estudiantes);

                    $("#por_semana").text('----------');
                    $("#total_semanas").text('----------');
                } else {
                    $("#id_esquema_pago").val(data.e.id);
                    $("#tipo_pago").text('PAGO POR SEMANA');
                    $("#por_semana").text(data.e.pago_por_semana);
                    $("#total_semanas").text(data.e.total_semanas);

                    $("#por_estudiante").text('----------');
                    $("#total_estudiantes").text('----------');
                }

                $("#diplomado_d").text(data.d.name);
                $("#generacion_d").text(data.g.number_generation);
                $("#docente").text(data.dc.name + ' ' + data.dc.last_name + ' ' + data.dc.mother_last_name);
                $("#a_pagar_final").text('$' + data.e.total_a_pagar);
            });
        }

        function aplicarMontoDocente() {
            var montouNo = $("#montoPagarDocente").val();
            $("#sMontoPagarDocente").text('$ ' + montouNo + ' MXN');
        }

        function aplicarPagoDocente() {
            var monto_aplicar = $("#montoPagarDocente").val();
            let id_pago = $("#id_esquema_pago").val();
            var monto = $("#montoPagarDocente").val();
            var fecha_pago = $("#fechaPagarDocente").val();
            //var metodo_pago = $("#metodo_pago").val();
            //var cuenta_destino = $("#cuenta_destino").val();

            var route = "{{url('admon/CATdiplomados/aplicar_pago/docente')}}";

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
                        //metodo_pago: metodo_pago,
                        //cuenta_destino: cuenta_destino
                    },
                    beforeSend: function() {
                        Notiflix.Loading.Dots('Procesando...');
                    },
                    success: function(data) {
                        Notiflix.Loading.Remove();
                        $('#message-error-save').css('display', 'none');
                        Notiflix.Report.Success('Bien hecho', 'Has guardado un nuevo pago.', 'Click');
                        datosPagosDiplomados(data.i.id);
                        $("#montoPagarDocente").val("");
                        var gen = $("#id_g").val();
                        datosPagosDocente(gen);
                        //cancelarPago();
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

    </script>
@endsection
