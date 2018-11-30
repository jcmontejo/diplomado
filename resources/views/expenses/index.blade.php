@extends('layouts.master')
@section('title')
Gastos 
@endsection
@section('header-1')
Gastos
@endsection
@section('header-2')
Lista de Gastos
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Gastos</h4>
                <a href="#" class="btn btn-rounded btn-primary mb-3 float-right" id="createExpense">Agregar
                    Nuevo Gasto</a>
                <table class="table" id="expenses">
                    <thead>
                        <th>Concepto</th>
                        <th>Monto</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>Concepto</th>
                          <th>Monto</th>
                          <th>Descripción</th>
                          <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@include('expenses.modal-edit')
@include('expenses.modal-create')
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#expenses').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#expenses').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '{!! url('gastos/datos') !!}',
            columns: [{
                    data: 'concept',
                    name: 'concept'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'description',
                    name: 'description'
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

    $("#createExpense").click(function () {
        $('#modalCreate').modal('show');
    })

    $("#saveExpense").click(function () {
        var concept = $('#conceptSave > option:selected').text();
        var amount = $("#amountSave").val();
        var description = $("#descriptionSave").val();
        // var voucher = $("#voucherSave").val();
        var user_id = $("#userSave").val();
        var account_id = $("#accountSave").val();
        // Save Files
    
        var voucher = $('#voucherSave').prop('files')[0];

        var form_data = new FormData();
            // data
            form_data.append('concept', concept);
            form_data.append('amount', amount);
            form_data.append('description', description);
            form_data.append('voucher', voucher);

            form_data.append('user_id', user_id);
            form_data.append('account_id', account_id);
        var route = "/gastos/guardar"

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
                $('#conceptSave').val('');
                $('#amountSave').val('');
                $('#descriptionSave').val('');
                $('#voucherSave').val('');
                $('#userSave').val('');
                $('#accountSave').val('');
                $("#modalCreate").modal('toggle');
                $('#message-error').css('display', 'none');
                reload();
                swal("Bien hecho!", "Has registrado un nuevo gasto!", "success");
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
        var route = "gastos/editar/" + btn.value;

        $.get(route, function (res) {
            $("#concept").val(res.concept);
            $("#amount").val(res.amount);
            $("#description").val(res.description);
            $("#voucher").val(res.voucher);
            $("#user").val(res.user_id);
            $("#account").val(res.account_id);
            $("#id").val(res.id);
        });
    }

    $("#updateExpense").click(function () {
        var value = $("#id").val();
         var concept = $('#concept > option:selected').text();
        var amount = $("#amount").val();
        var description = $("#description").val();
        var user_id = $("#user").val();
        var account_id = $("#account").val();
        //  Files
    
        var voucher = $('#voucher').prop('files')[0];

        var form_data_edit = new FormData();
            // data
            form_data_edit.append('concept', concept);
            form_data_edit.append('amount', amount);
            form_data_edit.append('description', description);
            form_data_edit.append('voucher', voucher);

            form_data_edit.append('user_id', user_id);
            form_data_edit.append('account_id', account_id);
        var route = "gastos/actualizar/" + value;

         $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PUT',
            dataType: 'json',
            data: form_data_edit,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $('#conceptSave').val('');
                $('#amountSave').val('');
                $('#descriptionSave').val('');
                $('#voucherSave').val('');
                $('#userSave').val('');
                $('#accountSave').val('');
                $("#modalEdit").modal('toggle');
                $('#message-error').css('display', 'none');
                reload();
                swal("Bien hecho!", "Has editado el gasto!", "success");
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
        var route = "cuentas/eliminar/" + btn.value;
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
