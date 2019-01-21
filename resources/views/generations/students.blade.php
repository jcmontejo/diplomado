@extends('layouts.master')
@section('title')
Generaciones
@endsection
@section('header-1')
{{$generation->name_diplomat}}
@endsection
@section('header-2')
Lista de Alumnos
@endsection
@section('css')

@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Alumnos Inscritos</h4>
                <table class="table" id="students">
                    <thead>
                        <th>Nombre Alumno</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Fecha-Hora de Inscripción</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        @if ($student->status === 'Alta')
                            <tr>
                        @else
                        <tr style="color:#F34621  ;">
                        @endif
                            <td>{{$student->name}}</td>
                            <td>{{$student->last_name}}</td>
                            <td>{{$student->mother_last_name}}</td>
                            <td>{{$student->date}}</td>
                            <td>{{$student->status}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                <button value="{{$student->id_inscription}}" OnClick="Show(this);" class="btn btn-rounded btn-xs btn-info mb-3"
                                    data-toggle="modal" data-target="#modalShow"><i class="fa fa-eye"></i> Detalles</button>
                                @if ($student->status === 'Alta') 
                                    <button value="{{$student->id_inscription}}" OnClick="Down(this);" class="btn btn-rounded btn-xs btn-danger mb-3"
                                    data-toggle="modal" data-target="#modalDown"><i class="fa fa-thumbs-down"></i> Dar de Baja</button>
                                @else
                                    <button value="{{$student->id_inscription}}" OnClick="Up(this);" class="btn btn-rounded btn-xs btn-success mb-3"
                                    data-toggle="modal" data-target="#modalUp"><i class="fa fa-thumbs-up"></i> Activar</button>
                                    <button value="{{$student->id_inscription}}" OnClick="DetailsDown(this);" class="btn btn-rounded btn-xs btn-primary mb-3"
                                    data-toggle="modal" data-target="#modalDetails"><i class="fa fa-info"></i> Detalles de Baja</button>
                                @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@include('generations.modal-show')
@include('generations.modal-down')
@include('generations.modal-details-low')
@endsection
@section('js')
<script>
    $(document).ready(function () {

        $('#students').DataTable();
    });

    function Show(btn) {
        var route = "/generaciones/alumnos/consultar/" + btn.value;

        $.get(route, function (res) {
            $("#fullname").val(res.fullname);
            $("#date").val(res.date);
            $("#discount").val(res.discount);
            $("#total").val(res.final_cost);
            $("#first_payment").val(res.first_payment);
            $("#debt").val(res.debt);
        });
    }

    function Down(btn) {
        var route = "/generaciones/alumnos/consultar/" + btn.value;

        $.get(route, function (res) {
            $("#studentDown").val(res.fullname);
            $("#inscriptionDown").val(res.id_inscription);
        });
    }

    function DetailsDown(btn) {
        var route = "/generaciones/alumnos/baja/consultar/" + btn.value;

        $.get(route, function (res) {
            $("#lowID").val(res.id);
            $("#reason").val(res.reason);
            $("#created_at").val(res.created_at);
            $("#comments").val(res.comments);
        });
    }

      $("#downStudent").click(function () {
        var value = $("#inscriptionDown").val();
        var reason = $("#reasonDown").val();
        var comments = $("#commentsDown").val();
        var route = "/generaciones/alumnos/baja/" + value;

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                reason: reason,
                comments: comments
            },
             beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $("#modalEdit").modal('toggle');
                
                swal("Bien hecho!", "Has dado de baja al alumno exitosamente!", "success");
                location.reload();
            },
            error: function (data) {
                $("#preloader").css("display", "none");
                var response = JSON.parse(data.responseText);
                var errorString = "<ul>";
                $.each(response.errors, function (key, value) {
                    errorString += "<li>" + value + "</li>";
                });

                $("#error-edit").html(errorString);
                $("#message-error-edit").fadeIn();
            }
        });
    });

    function Up(btn) {
        var id = btn.value;
        var status = 'Alta';
        var route = "/generaciones/alumnos/alta/" + btn.value;
        swal({
            title: '¿Estás seguro?',
            text: "Será dado de alta el alumno!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, dar de alta!',
            cancelButtonText: 'Cancelar',
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
                                status: status
                            },
                        })
                        .done(function (response) {
                            swal('Alumno dado de alta correctamente!', response.message, response.status);
                            location.reload();
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
