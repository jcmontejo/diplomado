@extends('layouts.adminLTEClinic')
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Consultorios</h4>
                <a href="#" class="btn btn-rounded btn-primary mb-3 float-right" id="createRoom">Agregar
                    Nuevo Consultorio</a>
                <div class="table-responsive">
                    <table class="table" id="rooms">
                    <thead>
                        <th>Nombre Consultorio</th>
                        <th>Precio de Renta</th>
                        <th>Acciones</th>
                    </thead>
                </table>
                </div>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@include('clinic.rooms.modal-edit')
@include('clinic.rooms.modal-create')
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#rooms').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#rooms').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '{!! route('rooms.data') !!}',
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'price',
                    name: 'price'
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

    $("#createRoom").click(function () {
        $('#modalCreate').modal('show');
    })

    $("#saveRoom").click(function () {
        var name = $("#nameSave").val();
        var price = $("#priceSave").val();
        var route = "/clinica/consultorios/guardar"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
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
                $('#nameSave').val('');
                $('#priceSave').val('');
                $("#modalCreate").modal('toggle');
                $('#message-error-save').css('display', 'none');
                reload();
                toastr.success('Has registrado un nuevo consultorio!', 'Bien hecho!')
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
        var route = "/clinica/consultorios/eliminar/" + btn.value;
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
