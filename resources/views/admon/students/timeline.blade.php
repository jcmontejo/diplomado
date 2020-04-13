@extends('layouts.adminLTEAdmon')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Expediente Electrónico</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Alumnos</a></li>
                        <li class="breadcrumb-item active">Expediente</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" @if ($student->sex != 'H')
                                src="{{asset('/images/usr_woman.png')}}"
                                @else
                                src="{{asset('/images/usr_man.png')}}"
                                @endif
                                alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{ $student->name }} {{ $student->last_name }}
                                {{ $student->mother_last_name }}</h3>
                            <p class="text-muted text-center">{{ $student->profession }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Acerca de</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-qrcode mr-1"></i> Curp</strong>
                            <p class="text-muted">
                                <span class="tag tag-danger">{{ $student->curp }}</span>
                            </p>
                            <hr>
                            <strong><i class="fas fa-phone mr-1"></i> Teléfono</strong>
                            <p class="text-muted">
                                {{ $student->phone }}
                            </p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Dirección</strong>
                            <p class="text-muted">{{ $student->state }}</p>
                            <p class="text-muted">{{ $student->city }}</p>
                            <p class="text-muted">{{ $student->address }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                @include('admon.students.modal-details-inscription')
                <div class="col-md-9">
                    @forelse($inscriptions as $key => $value)
                    @php
                    $generation = \DB::table('generations')
                    ->where('id', '=', $value->generation_id)
                    ->first();

                    $payments = \DB::table('payments')
                    ->where('debt_id', '=', $value->debt_id)
                    ->get();
                    @endphp
                    <!-- The time line -->
                    <div class="timeline">
                        <!-- timeline time label -->
                        <div class="time-label">
                            <span class="bg-blue">FECHA DE INSCRIPCIÓN: {{ $value->created_at }}</span>
                        </div>
                        <!-- /.timeline-label -->
                        <!-- timeline item -->
                        <div>
                            <i class="fas fa-user-graduate bg-blue"></i>
                            <div class="timeline-item">
                                <h3 class="timeline-header"><a href="#">DIPLOMADO: </a> {{ $value->diplomat }} <a
                                        href="#">GENERACIÓN:</a> {{ $value->generation }}</h3>

                                <div class="timeline-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>COSTO DIPLOMADO</th>
                                                    <th>INSCRIPCIÓN</th>
                                                    <th>DESCUENTO</th>
                                                    <th>TOTAL PAGADO</th>
                                                    <th>TOTAL ADEUDO</th>
                                                    <th>COMPLETO PAGO</th>
                                                    <th>ACCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">${{number_format($value->final_cost,2)}}</th>
                                                    <th>${{number_format($value->first_payment,2)}}</th>
                                                    <th>${{number_format($value->discount,2)}}</th>
                                                    <td>${{number_format($value->final_cost - $value->debt,2)}}</td>
                                                    <td>${{number_format($value->debt,2)}}</td>
                                                    <td>@if ($value->debt == 0)
                                                        SI @else NO
                                                        @endif</td>
                                                    <td>
                                                        <button class="btn btn-primary"
                                                            OnClick="ShowDetailsInscription({{$value}});"
                                                            data-toggle="modal" data-target="#modalEditInscription"><i
                                                                class="fas fa-edit"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END timeline item -->
                        <!-- timeline item -->
                        <div>
                            <i class="fas fa-funnel-dollar bg-green"></i>
                            <div class="timeline-item">
                                <h3 class="timeline-header no-border"><a href="#">HISTORIAL DE PAGOS</a> </h3>
                                <div class="timeline-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    @foreach ($payments as $payment_title)
                                                    <th>Pago ({{$payment_title->number_payment}})</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @foreach ($payments as $payment_data)
                                                    @php
                                                    $debt = App\Debt::where('id', '=', $payment_data->debt_id)->first();

                                                    $agreement = \DB::table('agreements')
                                                    ->where('debt_id', '=', $debt->id)
                                                    ->where('num_pay', '=', $payment_data->number_payment)
                                                    ->first();
                                                    @endphp
                                                    <th>
                                                        @if ($payment_data AND $payment_data->status != 'PENDIENTE')
                                                        ${{number_format($payment_data->amount_paid,2)}}({{$payment_data->date}})<br><button
                                                            data-toggle="modal" data-target="#modalEditarPago"
                                                            onclick="editarPago({{$debt->id}}, {{$debt->amount}}, {{$payment_data->number_payment}});"
                                                            class="btn btn-xs btn-info"><i
                                                                class="fas fa-edit"></i></button>
                                                        @else
                                                        <div class="btn-group">
                                                            <button @if ($debt->amount == 0)
                                                                disabled
                                                                @endif class="btn btn-success btn-xs"
                                                                onclick="modalPay({{$payment_data->number_payment}},{{$debt->id}});"
                                                                data-toggle="modal"
                                                                data-target="#modalPay"><i
                                                                    class="fas fa-wallet"></i> Pagar</button>
                                                            <button @if ($agreement OR $debt->amount == 0)
                                                                class="btn btn-warning btn-xs"
                                                                disabled
                                                                @endif class="btn btn-primary btn-xs"
                                                                onclick="modalConvenio({{$payment_data->number_payment}},{{$debt->id}},
                                                                {{$debt->amount}});"
                                                                data-toggle="modal"
                                                                data-target="#modalConvenio"><i
                                                                    class="fas fa-handshake"></i> Convenio</button>
                                                        </div>
                                                        @endif
                                                    </th>
                                                    @endforeach
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="timeline-footer">
                                </div>
                            </div>
                        </div>
                        <!-- END timeline item -->
                    </div>
                    @empty

                    @endforelse
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.timeline -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@include('auxiliar.generations.modal-pay')
@include('auxiliar.generations.modal-convenio')
@include('auxiliar.generations.modal-editar-pago')
@include('auxiliar.generations.modal-editar-pago-dos')
@endsection
@section('js')
<script>
    function ShowDetailsInscription(btn) {
        var route = "/admon/alumnos/consultar/inscripcion/" + btn.id_ins;

        $.get(route, function (res) {
            $("#ID-INSCRIPTION").val(res.id);
            $("#final_costIns").val(res.final_cost);
            $("#first_paymentIns").val(res.first_payment);
            $("#number_of_paymenstIns").val(res.number_of_payments);
            $("#number_of_paymenstIns").attr({
                "max": 10,
                "min": res.number_of_payments
            });
            $("#amount_of_paymenstIns").val(res.amount_of_payments);
        });
    }

    $("#updateIns").click(function () {
        var value = $("#ID-INSCRIPTION").val();
        var final_cost = $("#final_costIns").val();
        var first_payment = $("#first_paymentIns").val();
        var number_of_payments = $("#number_of_paymenstIns").val();
        var amount_of_payments = $("#amount_of_paymenstIns").val();

        var route = "/admon/alumnos/inscripcion/actualizar/" + value;

        //checkPsd
        var psd = $("#psdMasterEditIns").val();
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
                            final_cost: final_cost,
                            first_payment: first_payment,
                            number_of_payments: number_of_payments,
                            amount_of_payments: amount_of_payments
                        },
                        beforeSend: function () {
                            $("#preloader").css("display", "block");
                        },
                        success: function () {
                            $("#preloader").css("display", "none");
                            $("#message-error-edit").fadeOut();
                            $("#modalEdit").modal('toggle');
                            $("#psdMasterEditIns").val("");
                            toastr.success('Has actualizado la inscripción exitosamente!',
                                'Bien hecho!')
                            location.reload();
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


    function modalPay(num_pay, debt_id) {
        var number_payment = num_pay;
        var debt_id = debt_id;

        $("#num_pay").val(number_payment);
        $("#debt_id").val(debt_id);
    }

    $("#processPay").click(function () {
        var debt_id = $("#debt_id").val();
        var date_payment = $("#date_payment").val();
        var observation = $("#observation").val();
        var number_payment = $("#num_pay").val();
        var payment_method = $("#payment_method").val();
        var destination_account = $("#destination_account").val();
        var account_type = $("#account_type").val();
        var amount = $("#amount").val();
        var discount = 0;
        var total = $("#ammount").val();

        var route = "/pagos/recibir/alterno"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: {
                debt_id: debt_id,
                date_payment: date_payment,
                observation: observation,
                number_payment: number_payment,
                payment_method: payment_method,
                destination_account: destination_account,
                account_type: account_type,
                amount: amount,
                discount: discount
                //total: total
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");

                $('#message-error-save').css('display', 'none');
                toastr.success('Hemos procesado el pago exitosamente!', 'Bien hecho!')
                location.reload();
            },
            error: function (data) {
                if (data.status === 400) {
                    $("#preloader").css("display", "none");
                    swal("Error!", "Estas introduciendo un monto mayor al adeudo del alumno.",
                        "error");
                }
                if (data.status === 406) {
                    $("#preloader").css("display", "none");
                    swal("Error!",
                        "Número de pago procesado anteriormente, seleccione otro número de pago.",
                        "error");
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

    function modalConvenio(num_pay, debt_id, total_debt) {
        var convenio_number_payment = num_pay;
        var convenio_debt_id = debt_id;
        var convenio_total_debt = total_debt;

        $("#convenio_num_pay").val(convenio_number_payment);
        $("#convenio_debt_id").val(convenio_debt_id);
        $("#convenio_total_debt").val(convenio_total_debt);
    }

    function modalEditarPrimerPago(debt_id, total_debt) {
        var primer_pago_debt_id = debt_id;
        var primer_pago_total_debt = total_debt;
        $("#primer_pago_debt_id").val(primer_pago_debt_id);
        $("#primer_pago_total_debt").val(primer_pago_total_debt);
    }

    function editarPago(debt_id, total_debt, num_pay) {
        var editar_pago_debt_id = debt_id;
        var editar_pago_total_debt = total_debt;
        var editar_num_pago = num_pay;
        $("#editar_pago_debt_id").val(editar_pago_debt_id);
        $("#editar_pago_total_debt").val(editar_pago_total_debt);
        $("#editar_num_pago").val(editar_num_pago);
        $(".inner").append("<span> </span>");
        $(".inner").append("<span> " + editar_num_pago + "</span>");
    }

    $("#procesarEditarPago").click(function () {
        var debt_id = $("#editar_pago_debt_id").val();
        var amount_pay = $("#montoNuevoPago").val();
        var total_debt = $("#editar_pago_total_debt").val();
        var num_pay = $("#editar_num_pago").val();

        var route = "/admon/generaciones/editar/pago/alterno";

        //checkPsd.
        var psd = $("#psdMasterEditPay").val();
        var route_psd = "/admon/consultar/contrasenia/" + psd;

        if (psd != "") {
            $.get(route_psd, function (res) {
                if (res.success == true) {
                    if (parseInt(amount_pay) > parseInt(total_debt)) {
                        toastr.error('Monto mayor al adeudo!', 'Ooops!')
                    } else {
                        $.ajax({
                            url: route,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                debt_id: debt_id,
                                num_pay: num_pay,
                                amount_pay: amount_pay
                            },
                            beforeSend: function () {
                                $("#preloader").css("display", "block");
                            },
                            success: function () {
                                $("#preloader").css("display", "none");
                                $("#modalEditarPrimerPago .close").click();
                                toastr.success('Pago editado exitosamente!', 'Bien hecho!')
                                location.reload();
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
                    }
                } else {
                    alert('Clave maestra incorrecta.');
                }
            });
        } else {
            alert('Por favor llena el campo de clave maestra.');
        }
    })


    $("#procesarConvenio").click(function () {
        var debt_id = $("#convenio_debt_id").val();
        var number_payment = $("#convenio_num_pay").val();
        var date_payment = $("#fechaConvenio").val();
        var amount = $("#montoConvenio").val();
        var total_debt = $("#convenio_total_debt").val();

        var route = "/pagos/recibir/convenio"

        if (parseInt(amount) > parseInt(total_debt)) {
            toastr.error('Monto mayor al adeudo!', 'Ooops!')
        } else {
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    debt_id: debt_id,
                    date_payment: date_payment,
                    number_payment: number_payment,
                    amount: amount
                },
                beforeSend: function () {
                    $("#preloader").css("display", "block");
                },
                success: function () {
                    $("#preloader").css("display", "none");

                    $('#message-error-save').css('display', 'none');
                    toastr.success('Hemos procesado el convenio exitosamente!', 'Bien hecho!')
                    location.reload();
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
        }
    })

    $("#procesarEditarPrimerPago").click(function () {
        var debt_id = $("#primer_pago_debt_id").val();
        var amount_pay = $("#montoPrimerPago").val();
        var total_debt = $("#primer_pago_total_debt").val();

        var route = "/admon/generaciones/editar/pago/";

        if (parseInt(amount_pay) > parseInt(total_debt)) {
            toastr.error('Monto mayor al adeudo!', 'Ooops!')
        } else {
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    debt_id: debt_id,
                    amount_pay: amount_pay
                },
                beforeSend: function () {
                    $("#preloader").css("display", "block");
                },
                success: function () {
                    $("#preloader").css("display", "none");
                    $("#modalEditarPrimerPago .close").click();
                    toastr.success('Pago editado exitosamente!', 'Bien hecho!')
                    location.reload();
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
        }
    })

</script>
@endsection
