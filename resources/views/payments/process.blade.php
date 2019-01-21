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
                         <div class="form-group col-md-12">
                           <div class="input-group">
                            <input type="text" id="curp" class="form-control" placeholder="Por favor introduce la CURP">
                            <div class="input-group-append">
                            <button class="btn btn-secondary" id="searchCurp" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                            </div>
                        </div>
                        </div>
                        <div class="form-group col-md-3">
                            <input type="hidden" id="id">
                            <label for="exampleInputEmail1">Diplomado</label>
                            <input type="hidden" class="form-control" id="diplomat_id">
                            <input type="text" class="form-control" id="diplomat_name">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputPassword1">Generación</label>
                            <input type="hidden" class="form-control" id="generation_id">
                            <input type="text" class="form-control" id="generation_number">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputPassword1">Alumno</label>
                            <input type="hidden" id="student_id">
                            <input type="text" id="name_student" class="form-control">
                        </div>
                         <div class="form-group col-md-3">
                            <label for="exampleInputPassword1">Total para Liquidar</label>
                            <input type="text" class="form-control bg-warning" id="debt" name="debt" style="font-size:30px; text-align:center;" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputPassword1">Fecha de Pago</label>
                            <input type="date" class="form-control" id="date_payment">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="exampleInputPassword1">Observaciones</label>
                            <select name="observation" id="observation" class="form-control form-control-lg">
                                <option value="PAGO PARCIAL DE DIPLOMADO">PAGO PARCIAL DE DIPLOMADO</option>
                                <option value="PAGO TOTAL DE DIPLOMADO">PAGO TOTAL DE DIPLOMADO</option>
                            </select>
                            {{-- <input type="text" class="form-control" id="observation"> --}}
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
                                            {{-- <th style="text-align:left">Descuento $</th> --}}
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
                                                {{-- <td><input type="text" class="discount form-control form-control-lg"
                                                        name="discount" id="discount" value="0" required>
                                                </td> --}}
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

        $('select[name="student_id"]').on('change', function () {
            var inscriptionID = $(this).val();
            if (inscriptionID) {
                $.ajax({
                    url: '/pagos/deuda/' + inscriptionID,
                    type: "GET",
                    dataType: "json",
                    beforeSend: function () {
                        $("#preloader").css("display", "block");
                    },
                    success: function (data) {
                        $("#preloader").css("display", "none");
                        var input = $( "#debt" );
                        input.val(data.amount);
                        console.log(data.amount);
                    }
                });
            } else {
                $('select[name="debt"]').empty();
            }
        });

        $(document).on('keyup', '.amount', function () {
            var amount = parseFloat($(this).closest("tr").find(".amount").val());
            var discount = parseFloat(0);
            $(this).closest("tr").find(".sub_total").val(amount - discount);

            //Show Total Amount
            var total = 0;
            var sub_total = parseFloat($(this).find(".total").val());
            total += sub_total;

            // $("#total").val(total);
        });
    });

    $("#searchCurp").click(function () {
        var curp = $("#curp").val();
        var route = "/pagos/buscar/curp/" + curp;
         if (curp) {
                $.ajax({
                    url: '/pagos/buscar/curp/'+ curp,
                    type: "GET",
                    dataType: "json",
                    beforeSend: function () {
                        $("#preloader").css("display", "block");
                    },
                    success: function (data) {
                        $("#preloader").css("display", "none");
                        $("#diplomat_id").val(data.diplomat_id);
                        $("#generation_id").val(data.generation_id);
                        $("#student_id").val(data.student_id);
                        $("#name_student").val(data.name_student+' '+data.last_name+' '+data.mother_last_name);
                        $("#diplomat_name").val(data.diplomat_name);
                        $("#generation_number").val('Generación: '+data.generation_number);
                        $("#debt").val(data.debt);
                    },
                    error: function (data) {
                        if (data.status === 400) {
                            $("#preloader").css("display", "none");
                            swal("Error!", "Estas introduciendo una curp no registrada, verifica los datos.", "error");
                        }
                    }
                });
            }else{
                swal("Error!", "Introduce una CURP.", "error");
            }
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
        var discount = 0;
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
                // Clear Data
                $("#curp").val('');
                $("#diplomat_id").val('');
                $("#generation_id").val('');
                $("#student_id").val('');
                $("#name_student").val('');
                $("#diplomat_name").val('');
                $("#generation_number").val('');
                $("#debt").val('');
                // End
                $('#nameSave').val('');
                $("#diplomat_id").val('');
                $("#generation_id").val('');
                $("#student_id").val('');
                $("#date_payment").val('');
                $("#amount").val('0');
                $("#discount").val('0');
                $("#total").val('0');
                $('select[name="student_id"]').empty();

                $('#message-error-save').css('display', 'none');
                var input = $( "#debt" );
                input.val('');
                swal("Bien hecho!", "Hemos procesado el pago exitosamente!", "success");
            },
            error: function (data) {
                if (data.status === 400) {
                     $("#preloader").css("display", "none");
                     swal("Error!", "Estas introduciendo un monto mayor al adeudo del alumno.", "error");
                }
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
