@extends('layouts.adminLTEAdmon')
@section('content')

<div class="row">
    <!-- data table start -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Generaciones</h4>

                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Generación Actualizado Correctamente.</strong>
                </div>
                <a href="#" class="btn btn-rounded btn-primary mb-3 float-right" id="createGeneration"><i
                        class="fas fa-plus"></i> Agregar
                    Nueva Generación</a>
                <div class="table-responsive">
                    <table class="table" id="generations">
                        <thead>
                            <th>Nombre Diplomado</th>
                            <th>Docente</th>
                            <th>Generación</th>
                            <th>Alumnos Inscritos</th>
                            <th>Costo de Diplomado (BASE)</th>
                            <th>Costo Máximo</th>
                            <th>Importe a pagar por comisión (BASE</th>
                            <th>% a pagar por FULL PRICE</th>
                            <th>Fecha/Hora de Creación</th>
                            <th>Acciones</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>

@include('admon.generations.modal-edit')
@include('admon.generations.modal-create')
@include('admon.generations.modal-students')
@include('admon.generations.modal-delete')
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
            ajax: '/admon/generaciones/datos',

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
                    data: 'total_inscriptions',
                    name: 'total_inscriptions',
                },
                {
                    data: 'cost',
                    "render": function (data, type, row) {
                        return '$' + data;
                    }
                },
                {
                    data: 'maximum_cost',
                    "render": function (data, type, row) {
                        return '$' + data;
                    }
                },
                {
                    data: 'commision',
                    "render": function (data, type, row) {
                        return '$' + data;
                    }
                },
                {
                    data: 'full_price',
                    "render": function (data, type, row) {
                        return data + '%';
                    }
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
        var commision = $("#commisionSave").val();
        var full_price = $("#full_priceSave").val();
        var cost = $("#costSave").val();
        var maximum_cost = $("#maximum_costSave").val();
        var status = $("#statusSave").val();
        var docent_id = $("#docentSave").val();
        var route = "/generaciones/guardar"

        //checkPsd
        var psd = $("#psdMaster").val();
        var route_psd = "/admon/consultar/contrasenia/" + psd;

        if (psd != "") {
            $.get(route_psd, function (res) {
                if (res.success == true) {
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
                            commision: commision,
                            full_price: full_price,
                            cost: cost,
                            maximum_cost: maximum_cost,
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
                            $("#psdMaster").val("");
                            toastr.success('Has creado una nueva generación!',
                                'Bien hecho!')
                        },
                        error: function (data) {
                            if (data.status === 400) {
                                $("#preloader").css("display", "none");
                                swal("Error!",
                                    "Ya existe un registro de este diploma con el mismo número de generación.",
                                    "error");
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
                } else {
                    alert('Clave maestra incorrecta.');
                }
            });
        } else {
            alert('Por favor llena el campo de clave maestra.');
        }
    })

    function Show(btn) {
        var route = "/admon/generaciones/editar/" + btn.value;

        $.get(route, function (res) {

            $("#dateEdit").val(res.start_date);
            $("#commisionEdit").val(res.commision);
            $("#full_priceEdit").val(res.full_price);
            $("#costEdit").val(res.cost);
            $("#maximum_costEdit").val(res.maximum_cost);
            $("#number_generationEdit").val(res.number_generation);
            $("#docentEdit").val(res.docent_id).change();
            $("#idEdit").val(res.id);
        });
    }

    $("#updateGeneration").click(function () {
        var value = $("#idEdit").val();
        var start_date = $("#dateEdit").val();
        var commission = $("#commisionEdit").val();
        var full_price = $("#full_priceEdit").val();
        var cost = $("#costEdit").val();
        var maximum_cost = $("#maximum_costEdit").val();
        var number_generation = $("#number_generationEdit").val();
        var docent_id = $("#docentEdit").val();

        var route = "/admon/generaciones/actualizar/" + value;

        //checkPsd
        var psd = $("#psdMasterEdit").val();
        var route_psd = "/admon/consultar/contrasenia/" + psd;

        if (psd != "") {
            $.get(route_psd, function (res) {
                if (res.success == true) {
                    $.ajax({
                        url: route,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'PUT',
                        dataType: 'json',
                        data: {
                            start_date: start_date,
                            commission: commission,
                            full_price: full_price,
                            cost: cost,
                            maximum_cost: maximum_cost,
                            number_generation: number_generation,
                            docent_id: docent_id
                        },
                        beforeSend: function () {
                            $("#preloader").css("display", "block");
                        },
                        success: function () {
                            $("#preloader").css("display", "none");
                            $("#modalEdit .close").click();
                            reload();
                            $("#psdMasterEdit").val("");
                            toastr.success('Has actualizado la generación exitosamente!',
                                'Bien hecho!')
                        }
                    });
                } else {
                    alert('Clave maestra incorrecta.');
                }
            });
        } else {
            alert('Por favor llena el campo de clave maestra.');
        }
    });

    function DeleteMod(btn) {
        $("#id-delete").val(btn);
    }

    $("#deleteAccount").click(function () {
        var id = $("#id-delete").val();
        var route = "/admon/generaciones/eliminar/";
        //checkPsd
        var psd = $("#psdMasterDelete").val();
        var route_psd = "/admon/consultar/contrasenia/" + psd;

        if (psd != "") {
            $.get(route_psd, function (res) {
                if (res.success == true) {
                    $.ajax({
                        url: route,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        beforeSend: function () {
                            $("#preloader").css("display", "block");
                        },
                        success: function () {
                            $("#preloader").css("display", "none");
                            $("#message-error-edit").fadeOut();
                            $("#modalDelete").modal('toggle');
                            reload();
                            $("#psdMasterDelete").val("");
                            toastr.success('Eliminado!', 'Bien hecho!')
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
                    })
                } else {
                    alert('Clave maestra incorrecta.');
                }
            });
        } else {
            alert('Por favor llena el campo de clave maestra.');
        }
    });

    function Students(btn) {
        var route = "generaciones/alumnos/" + btn.value;

        $('#students').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: 'generaciones/alumnos/' + btn.value,
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
