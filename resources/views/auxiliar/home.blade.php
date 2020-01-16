@extends('layouts.adminLTEAux')
@section('content')

@php
$todos = DB::table('todos')->where([
['status', '=', '0'],
['user_id', '=', Auth::user()->id],
])->get();

@endphp
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>150</h3>

                        <p>New Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>

                        <p>Bounce Rate</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>44</h3>

                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>65</h3>

                        <p>Unique Visitors</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
           
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@include('todos.modal-create')
@include('partials.modal-detail-inscription')
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Charge();
        ChargeConvenios();
    });

    $("#saveTodo").click(function () {
        var task_title = $("#task_title").val();
        var route = "/tareas/guardar"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: {
                title: task_title
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $('#task_title').val('');
                $("#todoAdd").modal('toggle');
                $('#message-error').css('display', 'none');
                location.reload();
                // reload();
                swal("Bien hecho!", "Tarea creada!", "success");
            },
            error: function (data) {
                $("#preloader").css("display", "none");
                var response = JSON.parse(data.responseText);
                var errorString = "<ul>";
                $.each(response.errors, function (key, value) {
                    errorString += "<li>" + value + "</li>";
                });

                $("#error-save").html(errorString);
                $("#message-error-save").fadeIn();
            }
        });
    })

    function task_done(id) {
        $.get("/tareas/actualizar/" + id, function (data) {
            if (data == "OK") {
                location.reload();
                swal("Bien hecho!", "Tarea finalizada!", "success");
            }
        });
    }

    function reload() {
        $('#recent_inscriptions').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#recent_inscriptions').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '/generaciones/inscripciones/recientes/',

            columns: [{
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
                    data: 'enrollment',
                    name: 'enrollment'
                },
                {
                    data: 'curp',
                    name: 'curp'
                },
                {
                    data: 'date',
                    name: 'date',
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

    function ShowInscriptionRecent(btn) {
        var route = "/generaciones/consultar/inscripcion/" + btn.value;


        $.get(route, function (res) {
            $("#student").append(res.full_name);
            $("#curp").append(res.curp);
            $("#email").append(res.enrollment);
            $("#diplomat").append(res.name_diplomat + ' ' + res.generation);
            $("#discount").append('$' + res.discount);
            $("#final_cost").append('$' + res.final_cost);
            $("#number_of_payments").append('<h3 style="color:black;">' + res.number_of_payments + '</h3>');
            $("#payment").append('$' + res.payment);
            $("#idInscription").val(res.id);
        });
    }

    function clearData() {
        $("#student").html("");
        $("#curp").html("");
        $("#email").html("");
        $("#diplomat").html("");
        $("#discount").html("");
        $("#final_cost").html("");
        $("#number_of_payments").html("");
        $("#payment").html("");
        $("#idInscription").val("");
    }

    function markRead(btn) {
        var id = btn.value;
        var route = "generaciones/marcar/leida/" + btn.value;
        swal({
            title: '¿Estás seguro?',
            text: "Será marcada como leída permanentemente!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, marcar!',
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
                            swal('Procesada!', response.message, response.status);
                        })
                        .fail(function () {
                            swal('Oops...', 'Algo salió mal con la petición!', 'error ');
                        });
                });
            },
            allowOutsideClick: false
        });
    }

    function sendVoucher(btn) {
        var id = btn.value;
        var route = "generaciones/enviar/recibo/" + btn.value;
        swal({
            title: '¿Estás seguro?',
            text: "Será enviado el recibo vía Email!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, envíar!',
            showLoaderOnConfirm: true,

            preConfirm: function () {
                return new Promise(function (resolve) {

                    $.ajax({
                            url: route,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'GET',
                            dataType: 'json',
                            data: {
                                id: id
                            },
                        })
                        .done(function (response) {
                            reload();
                            swal('Procesada!', response.message, response.status);
                        })
                        .fail(function () {
                            swal('Oops...', 'Algo salió mal con la petición!', 'error ');
                        });
                });
            },
            allowOutsideClick: false
        });
    }

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
            ajax: '/control-escolar/generaciones/convenios/pendientes/al-dia',

            columns: [{
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
