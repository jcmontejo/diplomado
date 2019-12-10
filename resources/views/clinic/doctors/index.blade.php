@extends('layouts.adminLTEClinic')
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Terapeutas</h4>
                <a href="#" class="btn btn-rounded btn-primary mb-3 float-right" id="createDoctor">Agregar
                    Nuevo Terapeuta</a>
                <div class="table-responsive">
                    <table class="table" id="doctors">
                    <thead>
                        <th>Nombre Docente</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Correo Electrónico</th>
                        <th>Acciones</th>
                    </thead>
                </table>
                </div>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@include('clinic.doctors.modal-edit')
@include('clinic.doctors.modal-create')
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#doctors').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#doctors').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '{!! route('doctors.data') !!}',
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'lastname',
                    name: 'lastname'
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
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    }

    $("#createDoctor").click(function () {
        $('#modalCreate').modal('show');
    })

    $("#saveDoctor").click(function () {
        var name = $("#nameSave").val();
        var lastname = $("#lastnameSave").val();
        var phone = $("#phoneSave").val();
        var email = $("#emailSave").val();
        var route = "/clinica/terapeutas/guardar"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: {
                name: name,
                lastname: lastname,
                phone: phone,
                email: email
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $('#nameSave').val('');
                $('#lastnameSave').val('');
                $('#phoneSave').val('');
                $('#emailSave').val('');
                $("#modalCreate").modal('toggle');
                $('#message-error-save').css('display', 'none');
                reload();
                toastr.success('Has registrado un nuevo terapeuta!', 'Bien hecho!')
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
        var route = "/clinica/terapeutas/editar/" + btn.value;

        $.get(route, function (res) {
            $("#name").val(res.name);
            $("#lastname").val(res.lastname);
            $("#phone").val(res.phone);
            $("#email").val(res.email);
            $("#id").val(res.id);
        });
    }

    $("#updateDoctor").click(function () {
        var value = $("#id").val();
        var name = $("#name").val();
        var lastname = $("#lastname").val();
        var phone = $("#phone").val();
        var email = $('#email').val();
        var route = "/clinica/terapeutas/actualizar/" + value;

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                name: name,
                lastname: lastname,
                phone: phone,
                email: email
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $("#modalEdit").modal('toggle');
                $("#message-error-edit").fadeOut();
                reload();
                toastr.success('Has actualizado al docente exitosamente!', 'Bien hecho!')
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
        var route = "/clinica/terapeutas/eliminar/" + btn.value;
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
