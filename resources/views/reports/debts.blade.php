@extends('layouts.master')
@section('title')
Reporte de Adeudos
@endsection
@section('header-1')
Reporte de Adeudos
@endsection
@section('header-2')
Reporte de Adeudos
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Reporte de Adeudos</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Docente Actualizado Correctamente.</strong>
                </div>
                {{-- <a href="{{url('/reportes/datos/adeudos/descargar')}}" class="btn btn-rounded btn-primary mb-3 float-right">Generar PDF</a> --}}
                <div class="table-responsive">
                    <table class="table" id="debts">
                        <thead>
                            <th>Matricula</th>
                            <th>CURP</th>
                            <th>Nombre Estudiante</th>
                            <th>Diplomado</th>
                            <th>Generación</th>
                            <th>Teléfono</th>
                            <th>Total Pagado</th>
                            <th>Total Adeudo</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@include('teachers.modal-edit')
@include('teachers.modal-create')
@endsection
@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#debts').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#debts').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '/reportes/datos/adeudos',
            "dom": 'lBfrtip',
            "buttons": ['csv', 'print', 'excel', 'pdf'],
            columns: [{
                    data: 'enrollment_student',
                    name: 'enrollment_student'
                },
                {
                    data: 'curp_student',
                    name: 'curp_student'
                },
                {
                    data: 'student',
                    name: 'student'
                },
                {
                    data: 'diplomat_name',
                    name: 'diplomat_name'
                },
                {
                    data: 'generation_number',
                    name: 'generation_number'
                },
                {
                    data: 'phone_student',
                    name: 'phone_student'
                },
                {
                    data: 'total_payment',
                    name: 'total_payment'
                },
                {
                    data: 'debt',
                    name: 'debt'
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
