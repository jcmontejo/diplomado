@extends('layouts.master')
@section('title')
Mensajería
@endsection
@section('header-1')
Mensajería
@endsection
@section('header-2')
Lista de mensajes enviados
@endsection
@section('css')
    
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Mensajes Enviados</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Generación Actualizado Correctamente.</strong>
                </div>
                <a href="#" class="btn btn-rounded btn-primary mb-3 float-right" id="createGeneration">Agregar
                    Nueva Generación</a>
                <table class="table" id="generations">
                    <thead>
                        <th>Nombre Diplomado</th>
                        <th>Docente</th>
                        <th>Generación</th>
                        <th>Alumnos Inscritos</th>
                        <th>Costo de Diplomado</th>
                        <th>Número de Pagos</th>
                        <th>Observaciones</th>
                        <th>Fecha/Hora de Creación</th>
                        <th>Acciones</th>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nombre Diplomado</th>
                            <th>Docente</th>
                            <th>Generación</th>
                            <th>Alumnos Inscritos</th>
                            <th>Costo de Diplomado</th>
                            <th>Número de Pagos</th>
                            <th>Observaciones</th>
                            <th>Fecha/Hora de Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@include('generations.modal-edit')
@include('generations.modal-create')
@include('generations.modal-students')
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#generations').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function reloadStudents() {
        $('#students').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function addStudents(btn) {
        var id_generation = btn.value;
        $("#id_generation").val(id_generation);
        $('#modalStudents').modal('show');
    }

    function Charge() {
        $('#generations').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '{!! route('generations.data') !!}',
            columns: [{
                    data: 'name_diplomat',
                    name: 'name_diplomat'
                },
                {
                    data: 'docent',
                    name: 'docent'
                },
                {
                    data: 'number_generation',
                    name: 'number_generation'
                },
                {
                    data: 'number_students',
                    name: 'number_students',
                },
                {
                    data: 'cost',
                    name: 'cost'
                },
                {
                    data: 'number_payments',
                    name: 'number_payments'
                },
                {
                    data: 'note',
                    name: 'note'
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

    $("#createGeneration").click(function () {
        $('#modalCreate').modal('show');
    })

    $("#saveGeneration").click(function () {
        var name_diplomat = $('#namediplomatSave').val();
        var number_generation = $("#numbergenerationSave").val();
        var start_date = $("#startdateSave").val();
        var number_payments = $("#numberpaymentsSave").val();
        var note = $("#noteSave").val();
        var status = $("#statusSave").val();
        var docent_id = $("#docentSave").val();
        var route = "/generaciones/guardar"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: {
                name_diplomat: name_diplomat,
                number_generation: number_generation,
                start_date: start_date,
                number_payments: number_payments,
                note: note,
                status: status,
                docent_id: docent_id
            },
             beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $('#namediplomatSave').val('');
                $('#numbergenerationSave').val('');
                $('#startdateSave').val('');
                $('#numberpaymentsSave').val('');
                $('#noteSave').val('');
                $('#statusSave').val('');
                $("#docentSave").val('');
                $("#modalCreate").modal('toggle');
                $('#message-error').css('display', 'none');
                reload();
                swal("Bien hecho!", "Has creado una nueva generación!", "success");
            },
            error: function (data) {
                if (data.status === 400) {
                     $("#preloader").css("display", "none");
                     swal("Error!", "Ya existe un registro de este diploma con el mismo número de generación.", "error");
                }
                $("#preloader").css("display", "none");
                var response = JSON.parse(data.responseText);
                var errorString = "<ul>";
                $.each(response.errors, function (key, value) {
                    errorString += "<li>" + value + "</li>";
                });
                // $('#namediplomatSave').val('');
                $("#error-save").html(errorString);
                $("#message-error-save").fadeIn();
            }
        });
    })

    function Show(btn) {
        var route = "generaciones/editar/" + btn.value;

        $.get(route, function (res) {
            $("#namediplomat").val(res.name_diplomat);
            $("#numbergeneration").val(res.number_generation);
            $("#numberpayments").val(res.number_payments);
            $("#note").val(res.note);
            $("#status").val(res.status);
            $("#id").val(res.id);
        });
    }

    $("#updateGeneration").click(function () {
        var value = $("#id").val();
        var name_diplomat = $("#namediplomat").val();
        var number_generation = $("#numbergeneration").val();
        var number_payments = $("#numberpayments").val();
        var note = $("#note").val();
        var status = $("#status").val();
        var route = "generaciones/actualizar/" + value;

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                name_diplomat: name_diplomat,
                number_generation: number_generation,
                number_payments: number_payments,
                note: note,
                status: status
            },
            success: function () {
                $("#modalEdit").modal('toggle');
                reload();
                swal("Bien hecho!", "Has actualizado la generación exitosamente!", "success");
            }
        });
    });

    function Delete(btn) {
        var id = btn.value;
        var route = "generaciones/eliminar/" + btn.value;
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

     function Students(btn) {
        var route = "generaciones/alumnos/" + btn.value;
        
        $('#students').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax:  'generaciones/alumnos/' + btn.value,
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
                    data: 'debt',
                    name: 'debt'
                }
            ]
        });
    }

</script>
@endsection
