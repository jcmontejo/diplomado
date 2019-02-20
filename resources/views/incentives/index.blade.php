@extends('layouts.master')
@section('title')
Comisiones
@endsection
@section('header-1')
Comisiones
@endsection
@section('header-2')
Todas las comisiones
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
                <h4 class="header-title">Todos las Comisiones</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Método Actualizada Correctamente.</strong>
                </div>
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table" id="incentives">
                        <thead>
                            <th>Comisión</th>
                            <th>FULL PRICE</th>
                            <th>Estatus de pago</th>
                            <th>Vendedor</th>
                            <th>Detalles</th>
                            <th>Acciones</th>
                        </thead>
                    </table>
                    </div>
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
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#incentives').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#incentives').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '{!! url('comisiones/datos') !!}',
            columns: [{
                    data: 'commission',
                    name: 'commission'
                },
                {
                    data: 'full_price',
                    name: 'full_price'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'employe',
                    name: 'employe'
                },
                {
                    data: 'details',
                    name: 'details'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    }

    function Pay(btn) {
        var id = btn.value;
        var route = "/comisiones/pagar/" + btn.value;
        swal({
            title: '¿Estás seguro?',
            text: "Será pagada la comisión!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, pagar!',
            showLoaderOnConfirm: true,

            preConfirm: function () {
                return new Promise(function (resolve) {

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
                        .done(function (response) {
                            reload();
                            swal('Pagado!', response.message, response.status);
                        })
                        .fail(function () {
                            swal('Oops...', 'Algo salió mal con la petición!', 'error ');
                        });
                });
            },
            allowOutsideClick: false
        });
    }

</script>
@endsection
