@extends('layouts.master')
@section('title')
Reporte de Prospectos
@endsection
@section('header-1')
Reporte de Prospectos
@endsection
@section('header-2')
Reporte de Prospectos
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Reporte de Prospectos</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Docente Actualizado Correctamente.</strong>
                </div>
                <div class="table-responsive">
                    <table class="table" id="prospects">
                        <thead>
                            <th>Matricula</th>
                            <th>CURP</th>
                            <th>Nombre</th>
                            <th>Estatus</th>
                            <th>Teléfono</th>
                            <th>Correo Electrónico</th>
                            <th>Fecha/hora de Alta</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@include('students.modal-adddocuments')
@endsection
@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#prospects').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#prospects').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "Todos"]],
            "pageLength": 25,
            processing: true,
            serverSide: true,
            ajax: '/inicio/datos/prospectos',
            "dom": 'lBfrtip',
            "buttons": ['excel', 'pdf'],
            columns: [{
                    data: 'enrollment',
                    name: 'enrollment'
                },
                {
                    data: 'curp',
                    name: 'curp'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'now',
                    name: 'now'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                 {
                    data: 'email',
                    name: 'email'
                }, {
                    data: 'created_at',
                    name: 'created_at'
                }
            ]
        });
    }
</script>
@endsection
