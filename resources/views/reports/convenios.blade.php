@extends('layouts.master')
@section('title')
Reporte de Convenios Pendientes
@endsection
@section('header-1')
Reporte de Convenios Pendientes
@endsection
@section('header-2')
Reporte de Convenios Pendientes
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Convenios Pendientes</h5>
                <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="convenios">
                            <thead class="bg-warning">
                                <th>Diplomado</th>
                                <th>Generación</th>
                                <th>Nombre Estudiante</th>
                                <th>Fecha pactada</th>
                                <th>Monto</th>
                            </thead>
                        </table>
                        
                    </div>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@include('teachers.modal-edit')
@include('teachers.modal-create')
@endsection
@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
<script>
    $(document).ready(function () {
        ChargeConvenios();
    });

    function reload() {
        $('#convenios').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function ChargeConvenios() {
        $('#convenios').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '/generaciones/convenios/pendientes/',

            columns: [
                {
                    data: 'name_diplomat',
                    name: 'name_diplomat'
                },
                {
                    data: 'generation',
                    name: 'generation'
                },
                {
                    data: 'full_name',
                    name: 'full_name'
                },
                {
                    data: 'fechaEsperada',
                    name: 'fechaEsperada'
                },
                {
                    data: 'montoPactado',
                    name: 'montoPactado'
                }
            ]
        });
    }

</script>
@endsection
