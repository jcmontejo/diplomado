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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Redactar Mensaje</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Generación Actualizado Correctamente.</strong>
                </div>
                <form id="form">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="exampleInputPassword1">Selecciona Alumno</label>
                            <select name="student_id" id="student_id" class="form-control student_id">
                                @forelse ($students as $student)
                                <option value="{{$student->id}}">{{$student->name}} {{$student->last_name}}
                                    {{$student->mother_last_name}}</option>
                                @empty
                                <option value="NA">No hay registros.</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputPassword1">Redactar Mensaje</label>
                            <textarea class="form-control summernote" name="message" id="message" required></textarea>
                        </div </div> <div>
                        <a href="#" id="sendEmail" class="btn btn-info mt-4 pr-4 pl-4" name="sendEmail">Enviar
                            Correo</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('.student_id').select2();

        $('#message').summernote({
            placeholder: 'Redacta el mensaje a enviar.',
            tabsize: 2,
            height: 300
        });
    });

     $("#sendEmail").click(function () {
        var student_id = $("#student_id").val();
        var message = $('#message').val();
        var route = "/mensajeria/enviar"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: {
                student_id: student_id,
                message: message
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $('#student_id').val('');
                $('#message').val('');
                $('#message-error').css('display', 'none');
                swal("Bien hecho!", "Has enviado un nuevo correo!", "success");
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

</script>
@endsection
