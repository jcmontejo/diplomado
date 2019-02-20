@extends('layouts.master')
@section('title')
Metodos de Pago
@endsection
@section('header-1')
Metodos
@endsection
@section('header-2')
Lista de Métodos de Pago
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Métodos De Pago</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Método Actualizada Correctamente.</strong>
                </div>
                <a href="#" class="btn btn-rounded btn-primary mb-3 float-right" id="createMethod">Agregar
                    Nuevo Método de Pago</a>
                <div class="table-responsive">
                    <table class="table" id="methods">
                    <thead>
                        <th>Nombre de Método de Pago</th>
                        <th>Acciones</th>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nombre de Método de Pago</th>
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
@include('payment_methods.modal-edit')
@include('payment_methods.modal-create')
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#methods').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#methods').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '{!! url('metodos-de-pago/datos') !!}',
            columns: [{
                    data: 'name',
                    name: 'name'
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

    $("#createMethod").click(function () {
        $('#modalCreate').modal('show');
    })

    $("#saveMethod").click(function () {
        var name = $("#nameSave").val();
        var route = "/metodos-de-pago/guardar"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: {
                name: name
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $('#nameSave').val('');
                $("#modalCreate").modal('toggle');
                $('#message-error').css('display', 'none');
                reload();
                swal("Bien hecho!", "Has creado un nuevo método de pago!", "success");
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
        var route = "metodos-de-pago/editar/" + btn.value;

        $.get(route, function (res) {
            $("#name").val(res.name);
            $("#id").val(res.id);
        });
    }

    $("#updateMethod").click(function () {
        var value = $("#id").val();
        var name = $("#name").val();
        var route = "metodos-de-pago/actualizar/" + value;

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                name: name
            },
             beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $("#modalEdit").modal('toggle');
                reload();
                swal("Bien hecho!", "Has actualizado el método de pago exitosamente!", "success");
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
        var route = "metodos-de-pago/eliminar/" + btn.value;
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
