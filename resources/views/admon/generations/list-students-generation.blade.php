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
                            <a class="nav-link" data-toggle="tab" href="#admon">Pagos vendedores</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane container active" id="home">
                            <h4 class="header-title">NOMBRE DEL DIPLOMADO: {{ $generation->name_diplomat }}</h4>
                            <input type="hidden" name="id_generation" id="id_generation" value="{{ $generation->id }}">
                            <h3 class="header-title">GENERACIÓN: {{ $generation->number_generation }}</h3>
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
                                        <th>DEBE</th>
                                        <th></th>
                                    </thead>
                                </table>
                            </div>
                            <div id="block-payments" style="display: none;">
                                <div class="card shadow-lg">
                                    <div class="card-header py-3 bg-primary">
                                        <button type="button" onclick="reset();" class="close" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <span id="titulo-pago"></span>
                                    </div>
                                    <div class="card-body">
                                        <div id="block-nuevo-pago" style="display: block;">
                                            <button class="btn btn-rounded btn-info mb-3 float-left" id="btnNuevoPago" onclick="nuevoPago();"><i
                                                    class="fas fa-plus"></i>
                                                Agregar Pago</button>
                                        </div>
                                        <input type="hidden" name="id_inscripcion" id="id_inscripcion">
                                        <div class="col d-flex justify-content-center">
                                            <style type="text/css">
                                                .tg {
                                                    border-collapse: collapse;
                                                    border-spacing: 0;
                                                }
                    
                                                .tg td {
                                                    border-color: black;
                                                    border-style: solid;
                                                    border-width: 1px;
                                                    font-family: Arial, sans-serif;
                                                    font-size: 16px;
                                                    overflow: hidden;
                                                    padding: 10px 5px;
                                                    word-break: normal;
                                                }
                    
                                                .tg th {
                                                    border-color: black;
                                                    border-style: solid;
                                                    border-width: 1px;
                                                    font-family: Arial, sans-serif;
                                                    font-size: 14px;
                                                    font-weight: normal;
                                                    overflow: hidden;
                                                    padding: 10px 5px;
                                                    word-break: normal;
                                                }
                    
                                                .tg .tg-0lax {
                                                    text-align: left;
                                                    vertical-align: top
                                                }
                    
                                            </style>
                                            <table class="tg">
                                                <thead>
                                                    <tr>
                                                        <th class="tg-0lax" colspan="3"><span id="seminario"></span></th>
                                                        <th class="tg-0lax" colspan="2"><span id="fecha"></span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="tg-0lax"><strong>Costo seminario: </strong> <span id="costo"></span></td>
                                                        <td class="tg-0lax"><strong>Vendido en: </strong><span id="vendido"></span></td>
                                                        <td class="tg-0lax"><strong>Total pagado: </strong> <span id="pagado"></span></td>
                                                        <td class="tg-0lax"><strong>Por pagar: </strong><span id="debe"></span></td>
                                                        <td class="tg-0lax"><strong>Vendedor: </strong><span id="vendedor"></span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                        <div id="lista-pagos">
                                            <style>
                                                .submit-btn {
                                                    color: #ffffff;
                                                    background: #EA1C74;
                                                    Padding: 6px 12px;
                                                    font: 16px;
                                                }
                    
                                            </style>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div id="pendientes">
                    
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div id="pagar" style="display: none;">
                                                        <input type="hidden" id="ID_PAGAR">
                                                        <div class="pr-lg-0 pr-xl-3">
                                                            <div class="row no-gutters p-2 border border-bottom-0">
                                                                <div class="form-group w-100 mb-0">
                                                                    <label class="w-100 font-weight-bold size-14">Digita monto a
                                                                        pagar</label>
                                                                    <div class="input-group mb-2">
                                                                        <input id="montoUNo" onkeyup="aplicarMonto();" type="number" min="1"
                                                                            step="any" class="form-control d-inline" value="">
                    
                                                                        <!--<div class="input-group-append dropleft">
                                                                                            <button id="agregarMontoUno" class="btn btn-outline-primary" type="button"
                                                                                                onclick="aplicarMonto();">Aplicar</button>
                                                                                        </div>-->
                                                                    </div>
                                                                </div>
                                                                <div class="form-group w-100 mb-0">
                                                                    <label class="w-100 font-weight-bold size-14">Selecciona fecha de
                                                                        pago</label>
                                                                    <div class="input-group mb-2">
                                                                        <input type="date" class="form-control" name="fecha_pago"
                                                                            id="fecha_pago"
                                                                            value="{{ \Carbon\Carbon::now()->toDateString() }}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group w-100 mb-0">
                                                                    <label class="w-100 font-weight-bold size-14">Selecciona método de
                                                                        pago</label>
                                                                    <div class="input-group mb-2">
                                                                        <select name="metodo_pago" id="metodo_pago" class="form-control">
                                                                            @forelse ($metodos as $metodo)
                                                                                <option value="{{ $metodo->id }}">{{ $metodo->name }}
                                                                                </option>
                                                                            @empty
                                                                                <option value="0">NO hay registros.</option>
                                                                            @endforelse
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group w-100 mb-0">
                                                                    <label class="w-100 font-weight-bold size-14">Selecciona cuenta destino
                                                                        del
                                                                        pago</label>
                                                                    <div class="input-group mb-2">
                                                                        <select name="cuenta_destino" id="cuenta_destino" class="form-control">
                                                                            @forelse ($cuentas as $cuenta)
                                                                                <option value="{{ $cuenta->id }}">
                                                                                    {{ $cuenta->account_name }}</option>
                                                                            @empty
                                                                                <option value="0">NO hay registros.</option>
                                                                            @endforelse
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row no-gutters p-2 border border-bottom-0">
                                                                <p class="w-100 font-weight-bold size-14">Resumen de pago</p>
                                                                <table class="w-100 size-14">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="size-16"><b>Total*</b></td>
                                                                            <td class="size-16 text-right"><b id="total">$0.00 MXN</b></td>
                                                                            <input type="hidden" id="total_enviar">
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="row no-gutters p-2 mb-3 border bg-light">
                                                                <button class="btn btn-block btn-primary p-2" id="btnGoToCheckout"
                                                                    onclick="aplicarPago();">Realizar
                                                                    pago</button>
                                                                <button class="btn btn-block btn-secondary"
                                                                    onclick="cancelarPago();">Cancelar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    @include('generations.modal-convenio')
    @include('admon.generations.modal-payments')
@endsection
@section('js')
    <script type="text/javascript"
        src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js">
    </script>
    <script>
        $(document).ready(function() {
            Notiflix.Loading.Dots('Procesando...');
            Charge();
            Notiflix.Loading.Remove();
        });

        function reload() {
            $('#rows').each(function() {
                dt = $(this).dataTable();
                dt.fnDraw();
            })
        }

        function Charge() {
            let id_generation = $("#id_generation").val();
            $('#rows').DataTable().clear();
            $('#rows').DataTable().destroy();
            $('#rows').DataTable({
                dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
        ],
        
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                ajax: '{{ url('/admon/generaciones/alumnos/inscritos/datos') }}/' + id_generation,
                columns: [{
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

            $.get(route, function(res) {
                $("#fullname").val(res.fullname);
                $("#date").val(res.date);
                $("#discount").val(res.discount);
                $("#total").val(res.final_cost);
                $("#first_payment").val(res.first_payment);
                $("#debt").val(res.debt);
            });
        }

        function modalPay(num_pay, debt_id) {
            var number_payment = num_pay;
            var debt_id = debt_id;

            $("#num_pay").val(number_payment);
            $("#debt_id").val(debt_id);
        }

        function modalConvenio(num_pay, debt_id) {
            var convenio_number_payment = num_pay;
            var convenio_debt_id = debt_id;

            $("#convenio_num_pay").val(convenio_number_payment);
            $("#convenio_debt_id").val(convenio_debt_id);
        }

        $("#processPay").click(function() {
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
                beforeSend: function() {
                    $("#preloader").css("display", "block");
                },
                success: function() {
                    $("#preloader").css("display", "none");

                    $('#message-error-save').css('display', 'none');

                    swal("Bien hecho!", "Hemos procesado el pago exitosamente!", "success");
                    location.reload();
                },
                error: function(data) {
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
                    $.each(response.errors, function(key, value) {
                        errorString += "<li>" + value + "</li>";
                    });

                    $("#error-save").html(errorString);
                    $("#message-error-save").fadeIn();
                }
            });
        })

        function Down(btn) {
            var route = "/generaciones/alumnos/consultar/" + btn.value;

            $.get(route, function(res) {
                $("#studentDown").val(res.fullname);
                $("#inscriptionDown").val(res.id_inscription);
            });
        }

        function DetailsDown(btn) {
            var route = "/generaciones/alumnos/baja/consultar/" + btn.value;

            $.get(route, function(res) {
                $("#lowID").val(res.id);
                $("#reason").val(res.reason);
                $("#created_at").val(res.created_at);
                $("#comments").val(res.comments);
            });
        }

        $("#downStudent").click(function() {
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
                beforeSend: function() {
                    $("#preloader").css("display", "block");
                },
                success: function() {
                    $("#preloader").css("display", "none");
                    $("#modalDown .close").click();

                    swal("Bien hecho!", "Has dado de baja al alumno exitosamente!", "success");
                    location.reload();
                },
                error: function(data) {
                    $("#preloader").css("display", "none");
                    var response = JSON.parse(data.responseText);
                    var errorString = "<ul>";
                    $.each(response.errors, function(key, value) {
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

                preConfirm: function() {
                    return new Promise(function(resolve) {

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
                            .done(function(response) {
                                swal('Alumno dado de alta correctamente!', response.message,
                                    response.status);
                                location.reload();
                            })
                            .fail(function() {
                                swal('Oops...', 'Algo salió mal con la petición!', 'error ');
                            });
                    });
                },
                allowOutsideClick: false
            });
        }

        //News functions for payments
        function showPayments(id) {
            Notiflix.Loading.Dots('Procesando...');
            console.log('go');
            var route = '/admon/generaciones/alumnos/traerDatos/' + id;

            $.get(route, function(res) {
                console.log(res);
                ChargeListPayments(res.inscription.id);
                $("#total_debt").text(res.debt.amount);
                $("#ID_INS").val(res.inscription.id);
            });
            Notiflix.Loading.Remove();
        }

        function closeFormPayment() {
            $("#APPLY_PAYMENT").css('display', 'none');
            $("#amount_alt").val("");
        }

        function closeFormAgreement() {
            $("#APPLY_AGREEMENT").css('display', 'none');
            //$("#amount_alt").val("");
        }

        function ChargeListPayments(id) {
            closeFormPayment();
            $('#PAYMENTS').DataTable().clear();
            $('#PAYMENTS').DataTable().destroy();
            $('#PAYMENTS').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                ajax: '{{ url('/admon/generaciones/alumnos/traerPagos/') }}/' + id,
                columns: [{
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'agreement',
                        name: 'agreement'
                    },
                    {
                        data: 'payment',
                        name: 'payment',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        }

        function applyPayment(id) {
            $("#APPLY_PAYMENT").css('display', 'block');
            $("#ID_PAYMENT").val(id);
        }

        function applyAgreement(id) {
            $("#APPLY_AGREEMENT").css('display', 'block');
            var route = '/admon/generaciones/alumnos/traerDatosGenerales/' + id;

            $.get(route, function(res) {
                console.log(res);
                ChargeListPayments(res.inscription.id);
                $("#total_debt").text(res.debt.amount);
                $("#ID_INS").val(res.inscription.id);
            });
        }

        function storePayment() {
            let inscription = $("#ID_INS").val();
            var id_payment = $("#ID_PAYMENT").val();
            var date_payment = $("#date_payment_alt").val();
            var payment_method = $("#payment_method").val();
            var destination_account = $("#destination_account").val();
            var account_type = $("#account_type").val();
            var amount = $("#amount_alt").val();
            var route = "/admon/generaciones/alumnos/pagos/recibir";
            if (amount != "") {
                $.ajax({
                    url: route,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id_payment: id_payment,
                        date_payment: date_payment,
                        payment_method: payment_method,
                        destination_account: destination_account,
                        account_type: account_type,
                        amount: amount
                    },
                    beforeSend: function() {
                        Notiflix.Loading.Dots('Procesando...');
                    },
                    success: function() {
                        Notiflix.Loading.Remove();
                        $('#message-error-save').css('display', 'none');
                        Notiflix.Report.Success('Bien hecho', 'Has guardado un nuevo pago.', 'Click');
                        ChargeListPayments(inscription);
                        Charge();
                        closeFormPayment();
                        showPayments($("#ID_INS").val(res.inscription.id));
                        /*document.getElementById("form-cat").reset();
                        $("#block-table").css("display", "block");
                        $("#block-create").css("display", "none");*/
                    },
                    error: function(data) {
                        Notiflix.Loading.Remove();
                        if (data.error = 1) {
                            Notiflix.Report.Failure('Oooops!',
                                'Monto mayor al adeudo del alumno, modifica el monto.', 'Cerrar');
                        }
                    }
                });
            }else{
                Notiflix.Notify.Failure('El campo monto es obligatorio.');
            }

        }

    </script>
@endsection
