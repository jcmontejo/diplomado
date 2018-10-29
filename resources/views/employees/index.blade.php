@extends('layouts.master')
@section('title')
Cuentas de Usuario
@endsection
@section('header-1')
Cuentas
@endsection
@section('header-2')
Lista de Cuentas de Usuario
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Cuentas de Usuario</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Cuenta Actualizada Correctamente.</strong>
                </div>
                <a href="#" class="btn btn-rounded btn-primary mb-3 float-right" id="createEmploye">Agregar
                    Nueva Cuenta de Usuario</a>
                <table class="table" id="employees">
                    <thead>
                        <th>Nombre de Usuario</th>
                        <th>Correo Electrónico</th>
                        <th>Acciones</th>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nombre de Usuario</th>
                            <th>Correo Electrónico</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@include('employees.modal-edit')
@include('employees.modal-create')
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#employees').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#employees').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '{!! url('usuarios/datos') !!}',
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
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

    $("#createEmploye").click(function () {
        $('#modalCreate').modal('show');
    })

    $("#saveEmploye").click(function () {
        var name = $("#nameSave").val();
        var email = $("#emailSave").val();
        var password = $("#passwordSave").val();
        var route = "/usuarios/guardar"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: {
                name: name,
                email: email,
                password: password
            },
            success: function () {
                $('#nameSave').val('');
                $('#emailSave').val('');
                $('#passwordSave').val('');
                $("#modalCreate").modal('toggle');
                $('#message-error-save').css('display', 'none');
                reload();
                swal("Bien hecho!", "Has creado una nueva cuenta de usuario!", "success");
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
        var route = "usuarios/editar/" + btn.value;

        $.get(route, function (res) {
            $("#name").val(res.name);
            $("#email").val(res.email);
            $("#password").val();
            $("#id").val(res.id);
        });
    }

    $("#updateEmploye").click(function () {
        var value = $("#id").val();
        var name = $("#name").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var route = "usuarios/actualizar/" + value;

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                name: name,
                email: email,
                password: password
            },
            success: function () {
                $("#modalEdit").modal('toggle');
                reload();
                swal("Bien hecho!", "Has actualizado la cuenta de usuario exitosamente!", "success");
            },
            error: function (data) {
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
        var route = "usuarios/eliminar/" + btn.value;
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
