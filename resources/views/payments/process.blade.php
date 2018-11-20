@extends('layouts.master')
@section('title')
Procesar Pago
@endsection
@section('header-1')
Procesar Pago
@endsection
@section('header-2')
Procesar Pago
@endsection
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Recibir Nuevo Pago</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Alumno Actualizado Correctamente.</strong>
                </div>
                <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                    <strong id="error-save"></strong>
                </div>
                <form id="form">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <input type="hidden" id="id">
                            <label for="exampleInputEmail1">Selecciona Diplomado</label>
                            <select name="diplomat_id" id="diplomat_id" class="form-control">
                                <option value="">--- Selecciona Diplomado ---</option>
                                @forelse ($diplomats as $diplomat)
                                <option value="{{$diplomat->id}}">{{$diplomat->name}}</option>
                                @empty
                                <option value="0">No hay diplomados registrados.</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputPassword1">Selecciona Generación</label>
                            <select name="generation_id" id="generation_id" class="form-control">
                                <option value="">--- Selecciona Diplomado Antes---</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputPassword1">Selecciona Alumno</label>
                            <select name="student_id" id="student_id" class="form-control student_id">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputPassword1">Fecha de Pago</label>
                            <input type="date" class="form-control" id="date_payment">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="exampleInputPassword1">Observaciones</label>
                            <input type="text" class="form-control" id="observation">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Método de Pago</label>
                            <select name="paymentMethod" id="payment_method" class="form-control">
                                @forelse ($paymentMethods as $paymentMethod)
                                <option value="{{$paymentMethod->id}}">{{$paymentMethod->name}}</option>
                                @empty
                                <option value="0">No existen metodos de pago registrados.</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Cuenta Destino</label>
                            <select name="account" id="destination_account" class="form-control">
                                @forelse ($accounts as $account)
                                <option value="{{$account->id}}">{{$account->account_name}}</option>
                                @empty
                                <option value="0">No existen cuentas registradas.</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <table class="table">
                                        <thead style="background:#dce9f9;">
                                            <th>Tipo de Cuota</th>
                                            <th style="text-align:left">Monto $</th>
                                            <th style="text-align:left">Descuento $</th>
                                            <th style="text-align:left">Total $</th>
                                        </thead>
                                        <tbody id="invoice">
                                            <tr>
                                                <td width="40%">
                                                    <select name='account_type' id="account_type" class='form-control form-control-lg'>
                                                        @forelse ($types as $type)
                                                        <option value="{{$type->id}}">{{$type->account_type}}</option>
                                                        @empty
                                                        <option>No hay tipos de cuotas registradas.</option>
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="amount form-control form-control-lg" name="amount" id="amount"
                                                        value="0" required>
                                                </td>
                                                <td><input type="text" class="discount form-control form-control-lg"
                                                        name="discount" id="discount" value="0" required>
                                                </td>
                                                <td>
                                                    <input type="text" class="sub_total form-control form-control-lg"
                                                        name="sub_total" id="total" value="0" readOnly="true" required>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="#" id="paymentReceived" class="btn btn-info mt-4 pr-4 pl-4" name="paymentReceived">Procesar
                            Pago</a>
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
        $('.student_id').select2({
            theme: 'bootstrap',
        });
        $('select[name="diplomat_id"]').on('change', function () {
            var diplomatID = $(this).val();
            if (diplomatID) {
                $.ajax({
                    url: '/pagos/generaciones/' + diplomatID,
                    type: "GET",
                    dataType: "json",
                    beforeSend: function () {
                        $("#preloader").css("display", "block");
                    },
                    success: function (data) {
                        $("#preloader").css("display", "none");
                        $('select[name="generation_id"]').empty();
                        $.each(data, function (key, value) {
                            $('select[name="generation_id"]').append(
                                '<option value="' + key +
                                '">Generación: ' + value + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="generation_id"]').empty();
                $('select[name="student_id"]').empty();
            }
        });

        $('select[name="generation_id"]').on('click', function () {
            var generationID = $(this).val();
            if (generationID) {
                $.ajax({
                    url: '/pagos/generaciones/alumnos/' + generationID,
                    type: "GET",
                    dataType: "json",
                    beforeSend: function () {
                        $("#preloader").css("display", "block");
                    },
                    success: function (data) {
                        $("#preloader").css("display", "none");
                        $('select[name="student_id"]').empty();
                        $.each(data, function (key, value) {
                            $('select[name="student_id"]').append('<option value="' +
                                key +
                                '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="student_id"]').empty();
            }
        });

        $(document).on('keyup', '.amount,.discount', function () {
            var amount = parseFloat($(this).closest("tr").find(".amount").val());
            var discount = parseFloat($(this).closest("tr").find(".discount").val());
            $(this).closest("tr").find(".sub_total").val(amount - discount);

            //Show Total Amount
            var total = 0;
            var sub_total = parseFloat($(this).find(".total").val());
            total += sub_total;

            // $("#total").val(total);
        });
    });

     $("#paymentReceived").click(function () {
        var diplomat_id = $("#diplomat_id").val();
        var generation_id = $("#generation_id").val();
        var student_id = $("#student_id").val();
        var date_payment = $("#date_payment").val();
        var observation = $("#observation").val();
        var payment_method = $("#payment_method").val();
        var destination_account = $("#destination_account").val();
        var account_type = $("#account_type").val();
        var amount = $("#amount").val();
        var discount = $("#discount").val();
        var total = $("#total").val();

        var route = "/pagos/recibir"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: {
                diplomat_id: diplomat_id,
                generation_id: generation_id,
                student_id: student_id,
                date_payment: date_payment,
                observation: observation,
                payment_method: payment_method,
                destination_account: destination_account,
                account_type: account_type,
                amount: amount,
                discount: discount,
                total: total
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $('#nameSave').val('');
                $("#diplomat_id").val('');
                $("#generation_id").val('');
                $("#student_id").val('');
                $("#date_payment").val('');
                $("#observation").val('');
                $("#payment_method").val('');
                $("#destination_account").val('');
                $("#account_type").val('');
                $("#amount").val('0');
                $("#discount").val('0');
                $("#total").val('0');
                $('select[name="student_id"]').empty();

                $('#message-error-save').css('display', 'none');
                swal("Bien hecho!", "Hemos procesado el pago exitosamente!", "success");
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
