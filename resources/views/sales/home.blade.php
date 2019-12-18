@extends('layouts.adminLTESales')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Ventas</a></li>
                    <li class="breadcrumb-item active">v 1.0</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@php
    $todos = DB::table('todos')->where([
    ['status', '=', '0'],
    ['user_id', '=', Auth::user()->id],
])->get();

$all = App\Student::where('user_id', '=', Auth::user()->id);

$actives = App\Student::join('student_inscriptions', 'student_inscriptions.student_id', '=', 'students.id')
    ->where('students.user_id', '=', Auth::user()->id)
    ->where('student_inscriptions.status', '=', 'Alta')
    ->get();

    $downs = App\Student::join('student_inscriptions', 'student_inscriptions.student_id', '=', 'students.id')
    ->where('students.user_id', '=', Auth::user()->id)
    ->where('student_inscriptions.status', '=', 'Baja')
    ->get();
@endphp
<!-- Main content -->
<section class="content">
     <!-- Small boxes (Stat box) -->
     <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$all->count()}}</h3>

                    <p>Todos tus alumnos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$actives->count()}}</h3>

                    <p>Alumnos activos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-long-arrow-alt-up"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$downs->count()}}</h3>

                    <p>Alumnos con baja</p>
                </div>
                <div class="icon">
                    <i class="fas fa-long-arrow-alt-down"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        {{--  <div class="col-lg-3 col-6">
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
        </div>  --}}
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tareas <button class="btn btn-xs btn-success float-right" data-toggle="modal" data-target="#todoAdd">Agregar</button></h5>
                @include('todos.ajaxData')
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
@include('todos.modal-create')
@include('partials.modal-detail-inscription')
@endsection
@section('js')
<script>
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

    function task_done(id){
    $.get("/tareas/actualizar/"+id, function(data) {
        if(data=="OK"){
            location.reload();
            swal("Bien hecho!", "Tarea finalizada!", "success");
        }
    });
    }
</script>
@endsection
