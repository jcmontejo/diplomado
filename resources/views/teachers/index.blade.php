@extends('layouts.master')
@section('title')
Docentes
@endsection
@section('header-1')
Docentes
@endsection
@section('header-2')
Lista de Docentes
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Docentes</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Docente Actualizado Correctamente.</strong>
                </div>
                <a href="#" class="btn btn-rounded btn-primary mb-3 float-right" id="createTeacher">Agregar
                    Nuevo Docente</a>
                <table class="table" id="teachers">
                    <thead>
                        <th>Nombre Docente</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Genero</th>
                        <th>Teléfono</th>
                        <th>Correo Electrónico</th>
                        <th>Dirección</th>
                        <th>Fecha de Ingreso</th>
                        <th>Acciones</th>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nombre Docente</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Genero</th>
                            <th>Teléfono</th>
                            <th>Correo Electrónico</th>
                            <th>Dirección</th>
                            <th>Fecha de Ingreso</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@include('teachers.modal-edit')
@include('teachers.modal-create')
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#teachers').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#teachers').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '{!! route('teachers.data') !!}',
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
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'joining_date',
                    name: 'joining_date'
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

    $("#createTeacher").click(function () {
        $('#modalCreate').modal('show');
    })

    $("#saveTeacher").click(function () {
        var name = $("#nameSave").val();
        var last_name = $("#lastnameSave").val();
        var mother_last_name = $("#motherlastnameSave").val();
        var birthdate = $("#birthdateSave").val();
        var sex = $("#sexSave").val();
        var phone = $("#phoneSave").val();
        var email = $("#emailSave").val();
        var address = $("#addressSave").val();
        var joiningdate = $("#joiningdateSave").val();
        var route = "/docentes/guardar"

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
                email: email,
                address: address,
                joining_date: joiningdate
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $('#nameSave').val('');
                $('#lastnameSave').val('');
                $('#motherlastnameSave').val('');
                $('#birthdateSave').val('');
                $('#sexSave').val('');
                $('#phoneSave').val('');
                $('#emailSave').val('');
                $('#addressSave').val('');
                $('#joiningdateSave').val('');
                $("#modalCreate").modal('toggle');
                $('#message-error-save').css('display', 'none');
                reload();
                swal("Bien hecho!", "Has registrado un nuevo docente!", "success");
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

    function Show(btn) {
        var route = "docentes/editar/" + btn.value;

        $.get(route, function (res) {
            $("#name").val(res.name);
            $("#lastname").val(res.last_name);
            $("#motherlastname").val(res.mother_last_name);
            $("#birthdate").val(res.birthdate);
            $("#sex").val(res.sex);
            $("#phone").val(res.phone);
            $("#email").val(res.email);
            $("#address").val(res.address);
            $("#joiningdate").val(res.joining_date);
            $("#id").val(res.id);
        });
    }

    $("#updateTeacher").click(function () {
        var value = $("#id").val();
        var name = $("#name").val();
        var last_name = $("#lastname").val();
        var mother_last_name = $("#motherlastname").val();
        var birthdate = $("#birthdate").val();
        var sex = $("#sex").val();
        var phone = $("#phone").val();
        var email = $('#email').val();
        var address = $("#address").val();
        var joiningdate = $("#joiningdate").val();
        var route = "docentes/actualizar/" + value;

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
                email: email,
                address: address,
                joining_date: joiningdate
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $("#modalEdit").modal('toggle');
                $("#message-error-edit").fadeOut();
                reload();
                swal("Bien hecho!", "Has actualizado al docente exitosamente!", "success");
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

    function Delete(btn) {
        var id = btn.value;
        var route = "docentes/eliminar/" + btn.value;
        swal({
            title: '¿Estás seguro?',
            text: "Será eliminado permanentemente!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
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
