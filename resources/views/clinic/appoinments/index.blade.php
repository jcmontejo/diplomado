@extends('layouts.adminLTEClinic')
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Citas</h4>
                <a href="#" class="btn btn-rounded btn-primary mb-3 float-right" id="createAppoinment">Agregar
                    Nueva Cita</a>
                <div class="table-responsive">
                    <table class="table" id="appoinments">
                        <thead>
                            <th>Fecha de Cita</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Paciente</th>
                            <th>Terapeuta</th>
                            <th>Consultorio</th>
                            <th>Observación</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@include('clinic.appoinments.modal-edit')
@include('clinic.appoinments.modal-create')
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#appoinments').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#appoinments').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '{!! route('appoinments.data') !!}',
            columns: [{
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'start',
                    name: 'start'
                },
                {
                    data: 'end',
                    name: 'end'
                },
                {
                    data: 'patient',
                    name: 'patient'
                },
                {
                    data: 'doctor',
                    name: 'doctor'
                },
                {
                    data: 'room',
                    name: 'room'
                },
                {
                    data: 'observation',
                    name: 'observation'
                },
                {
                    data: 'status',
                    "render": function (data, type, row, meta) {
                        if (data == 1) {
                            return 'ACTIVA';
                        }else{
                            return 'CANCELADA';
                        }
                    }
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

    $("#createAppoinment").click(function () {
        $('#modalCreate').modal('show');
    })

    $("#saveAppoinment").click(function () {
        var date = $("#dateSave").val();
        var start = $("#startSave").val();
        var end = $("#endSave").val();
        var patient = $("#patientSave").val();
        var doctor_id = $("#doctorSave").val();
        var room_id = $("#roomSave").val();
        var observation = $("#observationSave").val();

        var route = "/clinica/citas/guardar"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: {
                date: date,
                start: start,
                end: end,
                patient: patient,
                doctor_id: doctor_id,
                room_id: room_id,
                observation: observation
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $('#dateSave').val('');
                $('#startSave').val('');
                $('#endSave').val('');
                $('#patientSave').val('');
                $('#doctorSave').val('');
                $('#roomSave').val('');
                $('#observationSave').val('');
                $("#modalCreate").modal('toggle');
                $('#message-error-save').css('display', 'none');
                reload();
                toastr.success('Has registrado una nueva cita!', 'Bien hecho!')
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
        var route = "/clinica/consultorios/editar/" + btn.value;

        $.get(route, function (res) {
            $("#name").val(res.name);
            $("#price").val(res.price);
            $("#id").val(res.id);
        });
    }

    $("#updateRoom").click(function () {
        var value = $("#id").val();
        var name = $("#name").val();
        var price = $("#price").val();
        var route = "/clinica/consultorios/actualizar/" + value;

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                name: name,
                price: price
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $("#modalEdit").modal('toggle');
                $("#message-error-edit").fadeOut();
                reload();
                toastr.success('Has actualizado el consultorio exitosamente!', 'Bien hecho!')
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
        var route = "/clinica/citas/eliminar/" + btn.value;
        swal({
            title: '¿Estás seguro?',
            text: "Será cancelada la cita!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, cancelar!',
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
