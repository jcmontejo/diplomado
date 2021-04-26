@extends('layouts.adminLTEAdmon')
@section('title')
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Cuentas Bancarias</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Cuenta Actualizada Correctamente.</strong>
                </div>
                <a href="#" class="btn btn-rounded btn-primary mb-3 float-right" id="createAccount">Agregar
                    Nueva Cuenta</a>
                <div class="table-responsive">
                    <table class="table" id="accounts">
                        <thead>
                            <th>Nombre Cuenta</th>
                            <th>Saldo</th>
                            <th>Notas</th>
                            <th>Acciones</th>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nombre Cuenta</th>
                                <th>Saldo</th>
                                <th>Notas</th>
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
@include('admon.accounts.modal-edit')
@include('admon.accounts.modal-create')
@include('admon.accounts.modal-delete')
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#accounts').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#accounts').DataTable({
            dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
        ]
,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '/admon/cuentas/datos',
            columns: [{
                    data: 'account_name',
                    name: 'account_name'
                },
                {
                    data: 'opening_balance',
                    name: 'opening_balance'
                },
                {
                    data: 'note',
                    name: 'note'
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

    $("#createAccount").click(function () {
        $('#modalCreate').modal('show');
    })

    $("#saveAccount").click(function () {
        var account_name = $("#accountnameSave").val();
        var opening_balance = $("#openingbalanceSave").val();
        var note = $("#noteSave").val();
        var route = "/admon/cuentas/guardar"

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
                            account_name: account_name,
                            opening_balance: opening_balance,
                            note: note
                        },
                        beforeSend: function () {
                            $("#preloader").css("display", "block");
                        },
                        success: function () {
                            $("#preloader").css("display", "none");
                            $('#accountnameSave').val('');
                            $('#openingbalanceSave').val('');
                            $('#noteSave').val('');
                            $("#modalCreate").modal('toggle');
                            $('#message-error').css('display', 'none');
                            reload();
                            $("#psdMaster").val("");
                            toastr.success('Has creado una nueva cuenta!', 'Bien hecho!')
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
                } else {
                    alert('Clave maestra incorrecta.');
                }
            });
        } else {
            alert('Por favor llena el campo de clave maestra.');
        }
    })

    function Show(btn) {
        var route = "cuentas/editar/" + btn.value;

        $.get(route, function (res) {
            $("#accountname").val(res.account_name);
            $("#openingbalance").val(res.opening_balance);
            $("#note").val(res.note);
            $("#id").val(res.id);
        });
    }

    $("#updateAccount").click(function () {
        var value = $("#id").val();
        var accountname = $("#accountname").val();
        var openingbalance = $("#openingbalance").val();
        var note = $("#note").val();
        var route = "/admon/cuentas/actualizar/" + value;

        //checkPsd.
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
                            account_name: accountname,
                            opening_balance: openingbalance,
                            note: note
                        },
                        beforeSend: function () {
                            $("#preloader").css("display", "block");
                        },
                        success: function () {
                            $("#preloader").css("display", "none");
                            $("#message-error-edit").fadeOut();
                            $("#modalEdit").modal('toggle');
                            reload();
                            $("#psdMasterEdit").val("");
                            toastr.success('Has actualizado la cuenta exitosamente!', 'Bien hecho!')
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
        var route = "/admon/cuentas/eliminar/";
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

</script>
@endsection
