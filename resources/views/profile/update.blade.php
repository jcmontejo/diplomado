@extends('layouts.master')
@section('title')
Actualizar Perfil
@endsection
@section('header-1')
Perfil de Usuario
@endsection
@section('header-2')
Actualizar Perfil
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Actualizar Perfil de Usuario</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Alumno Actualizado Correctamente.</strong>
                </div>
                <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                    <strong id="error-save"></strong>
                </div>
                <form id="form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="hidden" id="id">
                            <label for="exampleInputEmail1">Nombre de Usuario</label>
                            <input type="text" class="form-control form-control-lg" id="name" placeholder="Introduce nombre de docente">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Correo Electrónico de Acceso</label>
                            <input type="email" class="form-control form-control-lg" id="email" placeholder="Introduce apellido paterno">
                        </div>
                    </div>
                    <div>
                        <a href="#" id="updateProfile" class="btn btn-success mt-4 pr-4 pl-4" name="updateProfile">Actualizar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Show();
    });

    function Show(btn) {
        var route = "perfil/editar/";

        $.get(route, function (res) {
            $("#name").val(res.name);
            $("#email").val(res.email);
            $("#id").val(res.id);
        });
    }

    $("#updateProfile").click(function () {
        var value = $("#id").val();
        var name = $("#name").val();
        var email = $("#email").val();
        var route = "perfil/actualizar/" + value;

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                name: name,
                email: email
            },
            success: function () {
                Show();
                $('#message-error-save').css('display', 'none');
                swal("Bien hecho!", "Has actualizado tu perfil exitosamente!", "success");
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
    });

</script>
@endsection
