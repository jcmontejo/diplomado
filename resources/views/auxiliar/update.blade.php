@extends('layouts.adminLTEAux')
@section('content')
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
                        <div class="form-group col-md-4">
                            <input type="hidden" id="id">
                            <label for="exampleInputEmail1">Nombre de Usuario</label>
                            <input type="text" class="form-control form-control-lg" id="name" placeholder="Introduce tu nombre de usuario">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputPassword1">Correo Electrónico de Acceso</label>
                            <input type="email" class="form-control form-control-lg" id="email" placeholder="EJ. admin@serendipity.com">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputPassword1">Contraseña de Acceso</label>
                            <input type="password" class="form-control form-control-lg" id="password" placeholder="********">
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
            $("#passowrd").val();
            $("#id").val(res.id);
        });
    }

    $("#updateProfile").click(function () {
        var value = $("#id").val();
        var name = $("#name").val();
        var email = $("#email").val();
        var password = $("#password").val();
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
                email: email,
                password: password
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                Show();
                $('#message-error-save').css('display', 'none');
                toastr.success('Has actualizado tu perfil exitosamente!', 'Bien hecho!')
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
