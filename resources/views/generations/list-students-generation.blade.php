@extends('layouts.adminLTEAdmon')
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home">Todos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#admon">Adeudan Pago #6</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane container active" id="home">
                        <h4 class="header-title">NOMBRE DEL DIPLOMADO: {{$generation->name_diplomat}}</h4>
                        <input type="hidden" name="id_generation" id="id_generation" value="{{$generation->id}}">
                        <h3 class="header-title">GENERACIÓN: {{$generation->number_generation}}</h3>
                        <div class="table-responsive">
                            <table class="table display" id="rows">
                                <thead>
                                    <th></th>
                                    <th>ALUMNO</th>
                                    <th>MATRICULA</th>
                                    <th>CURP</th>
                                    <th>EMAIL</th>
                                    <th>TELÉFONO</th>
                                    <th>DES. APLICABLE</th>
                                    <th>INSCRIPCIÓN</th>
                                    <th>COSTO DIPLOMADO</th>
                                    <th>POR PAGAR</th>
                                    <th></th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@include('generations.modal-show')
@include('generations.modal-down')
@include('generations.modal-details-low')
@include('generations.modal-pay')
@include('generations.modal-convenio')
@endsection
@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#rows').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        let id_generation = $("#id_generation").val();
        $('#rows').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '{{url("/admon/generaciones/alumnos/inscritos/datos")}}/' + id_generation,
            columns: [
                {
                    data: 'payments',
                    name: 'payments'
                },
                {
                    data: 'full_name',
                    name: 'full_name'
                },
                {
                    data: 'enrollment',
                    name: 'enrollment'
                },
                {
                    data: 'curp',
                    name: 'curp'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'discount',
                    name: 'discount'
                },
                {
                    data: 'first_payment',
                    name: 'first_payment'
                },
                {
                    data: 'final_cost',
                    name: 'final_cost'
                },
                {
                    data: 'total_debt',
                    name: 'total_debt'
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

    function Show(btn) {
        var route = "/generaciones/alumnos/consultar/" + btn.value;

        $.get(route, function (res) {
            $("#fullname").val(res.fullname);
            $("#date").val(res.date);
            $("#discount").val(res.discount);
            $("#total").val(res.final_cost);
            $("#first_payment").val(res.first_payment);
            $("#debt").val(res.debt);
        });
    }

    function modalPay(num_pay,debt_id) {
        var number_payment = num_pay;
        var debt_id = debt_id;

        $("#num_pay").val(number_payment);
        $("#debt_id").val(debt_id);
    }

    function modalConvenio(num_pay,debt_id) {
        var convenio_number_payment = num_pay;
        var convenio_debt_id = debt_id;

        $("#convenio_num_pay").val(convenio_number_payment);
        $("#convenio_debt_id").val(convenio_debt_id);
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
            
                swal("Bien hecho!", "Hemos procesado el pago exitosamente!", "success");
                location.reload();
            },
            error: function (data) {
                if (data.status === 400) {
                     $("#preloader").css("display", "none");
                     swal("Error!", "Estas introduciendo un monto mayor al adeudo del alumno.", "error");
                }
                if (data.status === 406) {
                     $("#preloader").css("display", "none");
                     swal("Error!", "Número de pago procesado anteriormente, seleccione otro número de pago.", "error");
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

    function Down(btn) {
        var route = "/generaciones/alumnos/consultar/" + btn.value;

        $.get(route, function (res) {
            $("#studentDown").val(res.fullname);
            $("#inscriptionDown").val(res.id_inscription);
        });
    }

    function DetailsDown(btn) {
        var route = "/generaciones/alumnos/baja/consultar/" + btn.value;

        $.get(route, function (res) {
            $("#lowID").val(res.id);
            $("#reason").val(res.reason);
            $("#created_at").val(res.created_at);
            $("#comments").val(res.comments);
        });
    }

    $("#downStudent").click(function () {
        var value = $("#inscriptionDown").val();
        var reason = $("#reasonDown").val();
        var comments = $("#commentsDown").val();
        var route = "/generaciones/alumnos/baja/" + value;

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                reason: reason,
                comments: comments
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $("#modalDown .close").click();

                swal("Bien hecho!", "Has dado de baja al alumno exitosamente!", "success");
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
    });

    function Up(btn) {
        var id = btn.value;
        var status = 'Alta';
        var route = "/generaciones/alumnos/alta/" + btn.value;
        swal({
            title: '¿Estás seguro?',
            text: "Será dado de alta el alumno!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, dar de alta!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,

            preConfirm: function () {
                return new Promise(function (resolve) {

                    $.ajax({
                            url: route,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'PUT',
                            dataType: 'json',
                            data: {
                                status: status
                            },
                        })
                        .done(function (response) {
                            swal('Alumno dado de alta correctamente!', response.message,
                                response.status);
                            location.reload();
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
