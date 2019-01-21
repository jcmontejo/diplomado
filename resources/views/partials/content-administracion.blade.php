
@php
$todos = DB::table('todos')->where([
    ['status', '=', '0'],
    ['user_id', '=', Auth::user()->id],
])->get();

@endphp
{{-- Count --}}
<hr>
<div class="row">
 <div class="container">
        <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Estudiantes Inscritos Recientemente</h5>
                <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="recent_inscriptions">
                            <thead class="thead-dark">
                                <th>Diplomado</th>
                                <th>Generación</th>
                                <th>Nombre Estudiante</th>
                                <th>Matricula</th>
                                <th>CURP</th>
                                <th>Fecha-Hora de Inscripción</th>
                                <th>Acciones</th>
                            </thead>
                        </table>
                    </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tareas <button class="btn btn-xs btn-success float-right" data-toggle="modal" data-target="#todoAdd">Agregar</button></h5>
                @include('todos.ajaxData')
            </div>
        </div>
    </div>
 </div>
</div>

@include('todos.modal-create')
@include('partials.modal-detail-inscription')
@section('js')
<script>
    $(document).ready(function () {
     Charge();  
    });

     $("#saveTodo").click(function () {
        var task_title = $("#task_title").val();
        var route = "/tareas/guardar"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: {
                title: task_title
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $('#task_title').val('');
                $("#todoAdd").modal('toggle');
                $('#message-error').css('display', 'none');
                location.reload();
                // reload();
                swal("Bien hecho!", "Tarea creada!", "success");
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

    function task_done(id){
    $.get("/tareas/actualizar/"+id, function(data) {
        if(data=="OK"){
            location.reload();
            swal("Bien hecho!", "Tarea finalizada!", "success");
        }
    });
    }

    function reload() {
        $('#recent_inscriptions').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#recent_inscriptions').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '/generaciones/inscripciones/recientes/',

            columns: [
                {
                    data: 'name_diplomat',
                    name: 'name_diplomat'
                },
                {
                    data: 'generation',
                    name: 'generation'
                },
                {
                    data: 'full_name',
                    name: 'full_name'
                },
                {
                    data: 'enrollment',
                    name: 'enrollment'
                },
                {
                    data: 'curp',
                    name: 'curp'
                },
                {
                    data: 'date',
                    name: 'date',
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

    function ShowInscriptionRecent(btn) {
        var route = "/generaciones/consultar/inscripcion/" + btn.value;

        $.get(route, function (res) {
            $("#student").append(res.full_name);
            $("#curp").append(res.curp);
            $("#email").append(res.enrollment);
            $("#diplomat").append(res.name_diplomat+' '+res.generation);
            $("#discount").append('$'+res.discount);
            $("#final_cost").append('$'+res.final_cost);
            $("#payment").append('$'+res.payment);
            $("#idInscription").val(res.id);
        });
    }

    function clearData()
    {
         $("#student").html("");
            $("#curp").html("");
            $("#email").html("");
            $("#diplomat").html("");
            $("#discount").html("");
            $("#final_cost").html("");
            $("#payment").html("");
            $("#idInscription").val("");
    }

    function markRead(btn) {
        var id = btn.value;
        var route = "generaciones/marcar/leida/" + btn.value;
        swal({
            title: '¿Estás seguro?',
            text: "Será marcada como leída permanentemente!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, marcar!',
            showLoaderOnConfirm: true,

            preConfirm: function () {
                return new Promise(function (resolve) {

                    $.ajax({
                            url: route,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'PUT',
                            dataType: 'json',
                            data: {
                                id: id
                            },
                        })
                        .done(function (response) {
                            reload();
                            swal('Procesada!', response.message, response.status);
                        })
                        .fail(function () {
                            swal('Oops...', 'Algo salió mal con la petición!', 'error ');
                        });
                });
            },
            allowOutsideClick: false
        });
    }

    function sendVoucher(btn) {
        var id = btn.value;
        var route = "generaciones/enviar/recibo/" + btn.value;
        swal({
            title: '¿Estás seguro?',
            text: "Será enviado el recibo vía Email!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, envíar!',
            showLoaderOnConfirm: true,

            preConfirm: function () {
                return new Promise(function (resolve) {

                    $.ajax({
                            url: route,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'GET',
                            dataType: 'json',
                            data: {
                                id: id
                            },
                        })
                        .done(function (response) {
                            reload();
                            swal('Procesada!', response.message, response.status);
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
