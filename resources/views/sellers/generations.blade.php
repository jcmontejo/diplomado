@extends('layouts.master')
@section('title')
Generaciones
@endsection
@section('header-1')
Diplomados
@endsection
@section('header-2')
Lista de Generaciones
@endsection
@section('css')
    
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Generaciones</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Generación Actualizado Correctamente.</strong>
                </div>
               <div class="table-responsive">
                    <table class="table" id="generations">
                    <thead>
                        <th>Nombre Diplomado</th>
                        <th>Docente</th>
                        <th>Generación</th>
                        <th>Alumnos Inscritos</th>
                        <th>Costo de Diplomado (BASE)</th>
                        <th>Importe a pagar por comisión (BASE</th>
                        <th>% a pagar por FULL PRICE</th>
                        <th>Fecha/Hora de Creación</th>
                        <th>Acciones</th>
                    </thead>
                </table>
               </div>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#generations').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function reloadStudents() {
        $('#students').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#generations').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '{!! route('sellers.generations') !!}',

            columns: [{
                    data: 'name_diplomat',
                    name: 'name_diplomat'
                },
                {
                    data: 'docent',
                    name: 'docent'
                },
                {
                    data: 'number_generation',
                    name: 'number_generation'
                },
                {
                    data: 'number_students',
                    name: 'number_students',
                },
                {
                    data: 'cost',
                    "render": function (data, type, row) {
                        return '$' + data;
                    }
                },
                {
                    data: 'commision',
                    "render": function (data, type, row) {
                        return '$' + data;
                    }
                },
                {
                    data: 'full_price',
                    "render": function (data, type, row) {
                        return data+'%';
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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
</script>
@endsection
