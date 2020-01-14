@extends('layouts.adminLTEAdmon')
@section('title')
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Diplomados</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Diplomado Actualizado Correctamente.</strong>
                </div>
                <a href="#" class="btn btn-rounded btn-primary mb-3 float-right" id="createDiplomat"><i class="fas fa-plus"></i> Agregar
                    Nuevo Diplomado</a>
                <div class="table-responsive">
                    <table class="table" id="diplomats">
                    <thead>
                        <th>Nombre Diplomado</th>
                        <th>Clave Diplomado</th>
                        <th>Costo (BASE)</th>
                        <th>Costo Máximo (VENDEDORES)</th>
                        <th>Acciones</th>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nombre Diplomado</th>
                            <th>Clave Diplomado</th>
                            <th>Costo (BASE)</th>
                            <th>Costo Máximo (VENDEDORES)</th>
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
@include('admon.diplomats.modal-edit')
@include('admon.diplomats.modal-create')
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Charge();
    });

    function checkPassword(){
        var password = $("#password").val();
        if (password==='Temporal.2019') {
            toastr.success('Contraseña correcta!', 'Bien hecho!')
            $('.actions input').attr('disabled', false);
        }else{
            $('.actions input').attr('disabled', 'disabled');
            toastr.error('Contraseña incorrecta!', 'Ooops!')
        }
    }

    function reload() {
        $('#diplomats').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#diplomats').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '{!! route('admon.diplomats.data') !!}',
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'key',
                    name: 'key'
                },
                {
                    data: 'cost',
                    name: 'cost'
                },
                {
                    data: 'maximum_cost',
                    name: 'maximum_cost'
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

    $("#createDiplomat").click(function () {
        $('#modalCreate').modal('show');
    })

    $("#saveDiplomat").click(function () {
        var name = $("#nameSave").val();
        var key = $("#keySave").val();
        var cost = $("#costSave").val();
        var maximum_cost = $("#maximum_costSave").val();
        var route = "/admon/diplomados/guardar"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: {
                name: name,
                key: key,
                cost: cost,
                maximum_cost: maximum_cost
            },
             beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $('#nameSave').val('');
                $('#keySave').val('');
                $('#costSave').val('');
                $("#modalCreate").modal('toggle');
                $('#message-error').css('display', 'none');
                reload();
                swal("Bien hecho!", "Has creado un nuevo diplomado!", "success");
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
        var route = "/admon/diplomados/editar/" + btn.value;

        $.get(route, function (res) {
            $("#name").val(res.name);
            $("#key").val(res.key);
            $("#cost").val(res.cost);
            $("#maximum_cost").val(res.maximum_cost);
            $("#id").val(res.id);
        });
    }

    $("#updateDiplomat").click(function () {
        var value = $("#id").val();
        var name = $("#name").val();
        var key = $("#key").val();
        var cost = $("#cost").val();
        var maximum_cost = $("#maximum_cost").val();
        var route = "/admon/diplomados/actualizar/" + value;

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                name: name,
                key: key,
                cost: cost,
                maximum_cost: maximum_cost
            },
             beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $("#modalEdit").modal('toggle');
                reload();
                swal("Bien hecho!", "Has actualizado un diplomado exitosamente!", "success");
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
        var route = "/admon/diplomados/eliminar/" + btn.value;
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
