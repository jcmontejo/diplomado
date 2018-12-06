@extends('layouts.master')
@section('title')
Ingresos
@endsection
@section('header-1')
Ingresos
@endsection
@section('header-2')
Total de Ingresos
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css">
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Todos los Ingresos</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Método Actualizada Correctamente.</strong>
                </div>
                <div class="table-responsive">
                    <form action="" class="form-inline">
                        <div class="form-group mb-2">
                            <label for="start_date" class="sr-only">Fecha Inicio</label>
                            <input type="date" class="form-control" id="one" name="one">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="start_date" class="sr-only">Fecha Fin</label>
                            <input type="date" class="form-control" id="second" name="second">
                        </div>
                        <button type="submit" id="dateSearch" name="dateSearch" class="btn btn-primary mb-2">Filtrar</button>
                    </form>
                    <hr>
                    <table class="table" id="receiveds">
                        <thead>
                            <th>Diplomado</th>
                            <th>Generación</th>
                            <th>Alumno</th>
                            <th>Fecha de Pago</th>
                            <th>Observaciones</th>
                            <th>Método de Pago</th>
                            <th>Cuenta Destino</th>
                            <th>Tipo de Cuota</th>
                            <th>Importe</th>
                            <th>Descuento</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="10" style="text-align:right">Total:</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@include('payment_methods.modal-edit')
@include('payment_methods.modal-create')
@endsection
@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
<script>
    $(function () {
        var oTable = $('#receiveds').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            "dom": 'lBfrtip',
            "buttons": ['csv', 'print', 'excel', 'pdf'],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total = api
                    .column(10)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(10, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(10).footer()).html(
                    '$' + pageTotal + ' ( $' + total + ' total)'
                );
            },
            processing: true,
            serverSide: true,
            // ajax: '{!! url('pagos/recibidos') !!}',
            ajax: {
                url: '{!! url('pagos/recibidos') !!}',
                data: function (d) {
                    d.one = $('input[name=one]').val();
                    d.second = $('input[name=second]').val();
                }
            },
            columns: [{
                    data: 'diplomat',
                    name: 'diplomat'
                },
                {
                    data: 'generation',
                    name: 'generation'
                },
                {
                    data: 'student',
                    name: 'student'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'observation',
                    name: 'observation'
                },
                {
                    data: 'method',
                    name: 'method'
                },
                {
                    data: 'destination',
                    name: 'destination'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'discount',
                    name: 'discount'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });
        $('#dateSearch').on('click', function (e) {
            oTable.draw();
            e.preventDefault();
        });
    });

</script>
@endsection
