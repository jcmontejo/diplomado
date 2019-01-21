@extends('layouts.master')
@section('title')
Reporte de Estudiantes sin Documentos
@endsection
@section('header-1')
Reporte de Estudiantes sin Documentos
@endsection
@section('header-2')
Reporte de Estudiantes sin Documentos
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Reporte de Estudiantes sin Documentos</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Docente Actualizado Correctamente.</strong>
                </div>
                <div class="table-responsive">
                    <table class="table" id="documents">
                        <thead>
                            <th>Matricula</th>
                            <th>CURP</th>
                            <th>Nombre Estudiante</th>
                            <th>Diplomado</th>
                            <th>Generación</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@include('students.modal-adddocuments')
@endsection
@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#documents').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#documents').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '/reportes/estudiantes/no-documentos',
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
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    }

    function addDocuments(btn) {
        // 
        var route = "/alumnos/consultar/" + btn.value;
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
        if (file_address && file_studies) {
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
                    // $("#modalAddDocuments").modal('toggle');
                    $("#modalAddDocuments .close").click()
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
        } else {
            swal("Error!", "Tienes que seleccionar los archivos!", "error");
        }
    })

</script>
@endsection
