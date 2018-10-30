@extends('layouts.master')
@section('title')
Alumnos
@endsection
@section('header-1')
Alumnos
@endsection
@section('header-2')
Lista de Alumnos
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Alumnos</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Alumno Actualizado Correctamente.</strong>
                </div>
                <a href="#" class="btn btn-rounded btn-primary mb-3 float-right" id="createStudent">Agregar
                    Nuevo Alumno</a>
                <div class="table-responsive">
                    <table class="table" id="students">
                        <thead>
                            <th>Nombre Alumno</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Genero</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Correo Electrónico</th>
                            <th>Fecha/Hora de Creación</th>
                            <th>Acciones</th>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nombre Alumno</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Fecha de Nacimiento</th>
                                <th>Genero</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Correo Electrónico</th>
                                <th>Fecha/Hora de Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@include('students.modal-edit')
@include('students.modal-create')
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#students').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#students').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '{!! url('alumnos/datos') !!}',
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'last_name',
                    name: 'last_name'
                },
                {
                    data: 'mother_last_name',
                    name: 'mother_last_name'
                },
                {
                    data: 'birthdate',
                    name: 'birthdate'
                },
                {
                    data: 'sex',
                    name: 'sex'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'email',
                    name: 'email'
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

    $("#createStudent").click(function () {
        $('#modalCreate').modal('show');
    })

    $("#saveStudent").click(function () {
        var name = $("#nameSave").val();
        var last_name = $("#lastnameSave").val();
        var mother_last_name = $("#motherlastnameSave").val();
        var birthdate = $("#birthdateSave").val();
        var sex = $("#sexSave").val();
        var phone = $("#phoneSave").val();
        var address = $("#addressSave").val();
        var email = $("#emailSave").val();
        var route = "/alumnos/guardar"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: {
                name: name,
                last_name: last_name,
                mother_last_name: mother_last_name,
                birthdate: birthdate,
                sex: sex,
                phone: phone,
                address: address,
                email: email
            },
            success: function () {
                $('#nameSave').val('');
                $('#lastnameSave').val('');
                $('#motherlastnameSave').val('');
                $('#birthdateSave').val('');
                $('#sexSave').val('');
                $('#phoneSave').val('');
                $('#addressSave').val('');
                $('#emailSave').val('');
                $("#modalCreate").modal('toggle');
                $('#message-error').css('display', 'none');
                reload();
                swal("Bien hecho!", "Has registrado un nuevo alumno!", "success");
            },
            error: function (data) {
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

    function Show(btn) {
        var route = "alumnos/editar/" + btn.value;

        $.get(route, function (res) {
            $("#name").val(res.name);
            $("#lastname").val(res.last_name);
            $("#motherlastname").val(res.mother_last_name);
            $("#birthdate").val(res.birthdate);
            $("#sex").val(res.sex);
            $("#phone").val(res.phone);
            $("#address").val(res.address);
            $("#email").val(res.email);
            $("#id").val(res.id);
        });
    }

    $("#updateStudent").click(function () {
        var value = $("#id").val();
        var name = $("#name").val();
        var last_name = $("#lastname").val();
        var mother_last_name = $("#motherlastname").val();
        var birthdate = $("#birthdate").val();
        var sex = $("#sex").val();
        var phone = $("#phone").val();
        var address = $("#address").val();
        var email = $("#email").val();
        var route = "alumnos/actualizar/" + value;

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                name: name,
                last_name: last_name,
                mother_last_name: mother_last_name,
                birthdate: birthdate,
                sex: sex,
                phone: phone,
                address: address,
                email: email
            },
            success: function () {
                $("#modalEdit").modal('toggle');
                reload();
                swal("Bien hecho!", "Has actualizado al alumno exitosamente!", "success");
            }
        });
    });

    function Delete(btn) {
        var id = btn.value;
        var route = "alumnos/eliminar/" + btn.value;
        swal({
            title: '¿Estás seguro?',
            text: "Será eliminado permanentemente!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, borralo!',
            showLoaderOnConfirm: true,

            preConfirm: function () {
                return new Promise(function (resolve) {

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
                        .done(function (response) {
                            reload();
                            swal('Eliminado!', response.message, response.status);
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
