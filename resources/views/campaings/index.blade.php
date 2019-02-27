@extends('layouts.master')
@section('title')
Campañas
@endsection
@section('header-1')
Campañas
@endsection
@section('header-2')
Lista de Campañas
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Campañas</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Docente Actualizado Correctamente.</strong>
                </div>
                <a href="#" class="btn btn-rounded btn-primary mb-3 float-right" id="createCampaing">Agregar
                    Nueva Campaña</a>
                <div class="table-responsive">
                    <table class="table" id="campaings">
                    <thead>
                        <th>Asunto</th>
                        <th>Nombre Campaña</th>
                        <th>Html_url</th>
                        <th>Fecha de Envío Programada</th>
                        <th>Mensaje</th>
                        <th>Tipo de Camapaña</th>
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
@include('campaings.modal-edit')
@include('campaings.modal-create')
@include('campaings.modal-add-students')
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Charge();
        ChargeStudents();
    });

    function reload() {
        $('#campaings').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#campaings').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '{!! route('campaings.data') !!}',
            columns: [{
                    data: 'subject',
                    name: 'subject'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'html_url',
                    name: 'html_url'
                },
                {
                    data: 'send_date',
                    name: 'send_date'
                },
                {
                    data: 'message',
                    name: 'message'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'status',
                    "render": function ( data, type, row, meta ) {
                        if (data == 0) {
                        return 'Pendiente';
                        }
                    else {
                        return 'Enviada';
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    }

    function ChargeStudents() {
        $('#addStudents').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '{!! route('campaings.students') !!}',
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
                    data: 'curp',
                    name: 'curp'
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
                    data: 'facebook',
                    name: 'facebook'
                },
                {
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    }

    $("#createCampaing").click(function () {
        $('#modalCreate').modal('show');
    })

    $("#saveCampaing").click(function () {
        var subject = $("#subjectSave").val();
        var name = $("#nameSave").val();
        var html_url = $("#html_urlSave").val();
        var send_date = $("#send_dateSave").val();
        var message = $("#messageSave").val();
        var type = $("#typeSave").val();
    
        var route = "/campanias/guardar"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: {
                subject: subject,
                name: name,
                html_url: html_url,
                send_date: send_date,
                message: message,
                type: type
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $('#subjectSave').val('');
                $('#nameSave').val('');
                $('#html_urlSave').val('');
                $('#send_dateSave').val('');
                $('#messageSave').val('');
                $('#typeSave').val('');
        
                $("#modalCreate").modal('toggle');
                $('#message-error-save').css('display', 'none');
                reload();
                swal("Bien hecho!", "Has registrado una nueva campaña!", "success");
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

    function addStudents(btn) {
        $("#idCampaingAdd").val(btn.value);
    }

    function showStudents(btn){
        var route = "docentes/editar/" + btn.value;
    }

    $("#checkAll").click(function(){
        $('input:checkbox').prop('checked', this.checked);    
    });

    $("#bulk_add").click(function () {
        var id = [];
        var campaing =  $("#idCampaingAdd").val();

        if(confirm("¿Seguro de agregar a la lista?"))
        {
            $('.student_checkbox:checked').each(function(){
                id.push($(this).val());
            });
            if(id.length > 0)
            {
                $.ajax({
                    url:"{{ route('campaings.massadd')}}",
                    method:"get",
                    data:{id:id, campaing:campaing},
                    success:function(data)
                    {
                        alert(data);
                        //$('#student_table').DataTable().ajax.reload();
                    }
                });
            }
            else
            {
                alert("Por favor seleccione al menos una persona.");
            }
        }
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
