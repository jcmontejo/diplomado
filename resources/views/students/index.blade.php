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
@section('css')
<style>
    switch {
        display: inline-block;
        height: 34px;
        position: relative;
        width: 60px;
    }

    .switch input {
        display: none;
    }

    .slider {
        background-color: #ccc;
        bottom: 0;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: .4s;
    }

    .slider:before {
        background-color: #fff;
        bottom: 4px;
        content: "";
        height: 26px;
        left: 4px;
        position: absolute;
        transition: .4s;
        width: 26px;
    }

    input:checked+.slider {
        background-color: #66bb6a;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">
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
                @can('agregar-alumno')
                     <a href="#" class="btn btn-rounded btn-primary mb-3 float-right" id="createStudent">Agregar
                    Nuevo Alumno</a>
                @endcan
                <div class="table-responsive">
                    <table class="table" id="students">
                        <thead>
                            <th>Curp</th>
                            <th>Matricula</th>
                            <th>Nombre Alumno</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Genero</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Correo Electrónico</th>
                            <th>Profesión</th>
                            <th>Documentos</th>
                            <th>Fecha/Hora de Creación</th>
                            <th>Estatus</th>
                            <th>Vendedor</th>
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
                                <th>Profesión</th>
                                <th>Documentos</th>
                                <th>Fecha/Hora de Creación</th>
                                <th>Estatus</th>
                                <th>Vendedor</th>
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
@include('students.modal-adddocuments')
@include('students.modal-documents')
@include('students.modal-inscription')
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
<script>
    $(document).ready(function () {
        Charge();
        $('#modalDocuments').on('hidden.bs.modal', function () {
            $("#file-address").append("");
            $("#file-address").attr("href", "");
            $("#file-study").append("");
            $("#file-study").attr("href", "");
        });

        $('select[name="diplomat_id"]').on('change', function () {
            var diplomatID = $(this).val();
            if (diplomatID) {
                $.ajax({
                    url: '/pagos/generaciones/' + diplomatID,
                    type: "GET",
                    dataType: "json",
                    beforeSend: function () {
                        $("#preloader").css("display", "block");
                    },
                    success: function (data) {
                        $("#preloader").css("display", "none");
                        $('select[name="generation_id"]').empty();
                        $.each(data, function (key, value) {
                            $('select[name="generation_id"]').append(
                                '<option value="' + key +
                                '">Generación: ' + value + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="generation_id"]').empty();
                $('select[name="student_id"]').empty();
            }
        });
    });

    $('#status').on('change', function () {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        if (valueSelected == 1) {
            $("#blockDiplomat").show();
        } else {
            $("#blockDiplomat").hide();
        }
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
            "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "Todos"]],
            "pageLength": 25,
            "dom": 'lBfrtip',
            "buttons": ['excel', 'pdf'],
            processing: true,
            serverSide: true,
            ajax: '{!! url('alumnos/datos') !!}',
            columns: [
                {
                    data: 'curp',
                    name: 'curp'
                },
                {
                    data: 'enrollment',
                    name: 'enrollment'
                },
                {
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
                    data: 'profession',
                    name: 'profession'
                },
                {
                    data: 'documents',
                    "render": function (data, type, row) {
                        return (data == true) ?
                            'SI' :
                            'NO';
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'now',
                    name: 'now',
                    orderable: false,
                    searchable: false
                },
                {
                  data: 'owner',
                  name: 'owner'  
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
        var facebook = $("#facebookSave").val();
        var interested = $("#interestedSave").val();
        var birthdate = $("#birthdateSave").val();
        var sex = $("#sexSave").val();
        var phone = $("#phoneSave").val();
        var address = $("#addressSave").val();
        var state = $("#stateSave").val();
        var city = $("#citySave").val();
        var email = $("#emailSave").val();
        var profession = $("#professionSave").val();
        var status = $("#statusSave").val();
        var generation_id = $("#generationSave").val();
        // Save Files

        // var file_address = $('#proofaddressSave').prop('files')[0];
        // var file_studies = $("#proofstudiesSave").prop('files')[0];

        var form_data = new FormData();
        // Files
        // form_data.append('file_address', file_address);
        // form_data.append('file_studies', file_studies);
        // Rest of data
        form_data.append('name', name);
        form_data.append('last_name', last_name);
        form_data.append('mother_last_name', mother_last_name);
        form_data.append('facebook', facebook);
        form_data.append('interested', interested);
        form_data.append('birthdate', birthdate);
        form_data.append('sex', sex);
        form_data.append('phone', phone);
        form_data.append('address', address);
        form_data.append('state', state);
        form_data.append('city', city);
        form_data.append('email', email);
        form_data.append('profession', profession);
        form_data.append('status', status);
        form_data.append('generation_id', generation_id);

        // End
        var route = "/alumnos/guardar"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: form_data,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
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
                $('#addressSave').val('');
                $('#emailSave').val('');
                $("#modalCreate").modal('toggle');
                $('#message-error').css('display', 'none');
                reload();
                swal("Bien hecho!", "Has registrado un nuevo alumno!", "success");
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
        var route = "alumnos/editar/" + btn.value;


        $.get(route, function (res) {
            $("#curp").val(res.curp);
            $("#name").val(res.name);
            $("#lastname").val(res.last_name);
            $("#motherlastname").val(res.mother_last_name);
            $("#birthdate").val(res.birthdate);
            $("#sex").val(res.sex);
            $("#phone").val(res.phone);
            $("#facebook").val(res.facebook);
            $("#address").val(res.address);
            $("#state").val(res.state);
            $("#city").val(res.city);
            $("#email").val(res.email);
            $("#status").val(res.status);
            $("#profession").val(res.profession);
            $("#id").val(res.id);
        });
    }

    $("#updateStudent").click(function () {
        var value = $("#id").val();
        var curp = $("#curp").val();
        var name = $("#name").val();
        var last_name = $("#lastname").val();
        var mother_last_name = $("#motherlastname").val();
        var birthdate = $("#birthdate").val();
        var sex = $("#sex").val();
        var phone = $("#phone").val();
        var address = $("#address").val();
        var state = $("#state").val();
        var city = $("#city").val();
        var email = $("#email").val();
        var status = $("#status").val();
        var profession = $("#profession").val();
        var route = "/alumnos/actualizar/" + value;

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                curp: curp,
                name: name,
                last_name: last_name,
                mother_last_name: mother_last_name,
                birthdate: birthdate,
                sex: sex,
                phone: phone,
                address: address,
                state: state,
                city: city,
                email: email,
                status: status
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $("#modalEdit .close").click();
                reload();
                swal("Bien hecho!", "Has actualizado al alumno exitosamente!", "success");
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

    function Documents(btn) {
        var route = "alumnos/documentos/" + btn.value;

        $.get(route, function (res) {
            $("#file-address").append(res.proof_of_address);
            $("#file-address").attr("href", "assets/files/" + res.proof_of_address);
            $("#file-study").append(res.proof_of_studies);
            $("#file-study").attr("href", "assets/files/" + res.proof_of_studies);
            $("#file-id").val(res.id);
        });
    }

    function addDocuments(btn) {
        // 
        var route = "alumnos/consultar/" + btn.value;

        $.get(route, function (res) {
            $("#id").val(res.id);
            $("#name-student").val(res.name + ' ' + res.last_name + ' ' + res.mother_last_name);
            console.log(res.name);
        });
    }

    $("#updateDocuments").click(function () {
        var id = $("#id").val();
        var file_address = $('#document-address').prop('files')[0];
        var file_studies = $("#document-study").prop('files')[0];

        var form_data = new FormData();
        // Files
        form_data.append('file_address', file_address);
        form_data.append('file_studies', file_studies);
        // Rest of data
        form_data.append('id', id);

        // End
        var route = "/alumnos/subir/documentos"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: form_data,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $('#id').val('');
                $('#document-address').val('');
                $('#document-study').val('');
                $("#modalAddDocuments").modal('toggle');
                $('#message-error-document').css('display', 'none');
                reload();
                swal("Bien hecho!", "Has cargado los documentos del alumno!", "info");
            },
            error: function (data) {
                $("#preloader").css("display", "none");
                var response = JSON.parse(data.responseText);
                var errorString = "<ul>";
                $.each(response.errors, function (key, value) {
                    errorString += "<li>" + value + "</li>";
                });

                $("#error-save-document").html(errorString);
                $("#message-error-save-document").fadeIn();
            }
        });
    })

    function inscriptionStudent(btn) {
        var route = "alumnos/consultar/" + btn.value;

        $.get(route, function (res) {
            $("#nameInscription").val(res.name);
            $("#lastnameInscription").val(res.last_name);
            $("#motherlastnameInscription").val(res.mother_last_name);
            $("#id-student").val(res.id);
        });
    }

    $("#processInscription").click(function () {
        var student_id = $("#id-student").val();
        var generation_id = $("#generation_id").val();
        // Save Files

        var form_data = new FormData();
        // Rest of data
        form_data.append('generation_id', generation_id);
        form_data.append('student_id', student_id)

        // End
        var route = "/alumnos/procesar/inscripcion"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: form_data,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $('#nameInscription').val('');
                $('#lastnameInscription').val('');
                $('#motherlastnameInscription').val('');
                $('#id-student').val('');
                $("#modalInscription").modal('toggle');
                $('#message-error-inscription').css('display', 'none');
                reload();
                swal("Bien hecho!", "Has registrado un nuevo alumno!", "success");
            },
            error: function (data) {
                $("#preloader").css("display", "none");
                var response = JSON.parse(data.responseText);
                var errorString = "<ul>";
                $.each(response.errors, function (key, value) {
                    errorString += "<li>" + value + "</li>";
                });

                $("#error-inscription").html(errorString);
                $("#message-error-inscription").fadeIn();
            }
        });
    })

</script>
@endsection
