@extends('layouts.adminLTE')
@section('content')
<div class="row">
    @include('escolar.generations.ajax-1')
    <div class="loading">
        <i class="fas fa-refresh fa-spin fa-2x fa-fw"></i><br />
        <span>Cargando</span>
    </div>
</div>
@include('escolar.generations.modal-show')
@include('escolar.generations.modal-down')
@include('escolar.generations.modal-details-low')
@include('escolar.generations.modal-pay')
@include('escolar.generations.modal-convenio')
@include('escolar.generations.modal-editar-pago')
@endsection
@section('js')
<script>
    $(document).ready(function () {
        $('table.display').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            "searching": true,
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf'
            ],
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Todos"]
            ],
        });
        $('.field input').on('keyup', function () {
            let empty = false;

            $('.field input').each(function () {
                empty = $(this).val().length == 0;
            });

            if (empty)
                $('.actions input').attr('disabled', 'disabled');
            else
                $('.actions input').attr('disabled', false);
        });

        $('.editarPago input').on('keyup', function () {
            let empty = false;

            $('.editarPago input').each(function () {
                empty = $(this).val().length == 0;
            });

            if (empty)
                $('.actionsPago input').attr('disabled', 'disabled');
            else
                $('.actionsPago input').attr('disabled', false);
        });
    });

    function ajaxLoad(filename, content) {
        content = typeof content !== 'undefined' ? content : 'content';
        $('.loading').show();
        $.ajax({
            type: "GET",
            url: filename,
            contentType: false,
            success: function (data) {
                $("#" + content).html(data);
                $('.loading').hide();
                $(document).ready(function () {
                    $('table.display').DataTable({
                        "searching": false,
                        dom: 'Bfrtip',
                        buttons: [
                            'excel', 'pdf'
                        ],
                        "lengthMenu": [
                            [10, 25, 50, 100, -1],
                            [10, 25, 50, 100, "Todos"]
                        ],
                    });
                });
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

    function Show(btn) {
        var route = "/control-escolar/generaciones/alumnos/consultar/" + btn.value;

        $.get(route, function (res) {
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

    function modalEditarPrimerPago(debt_id) {
        var primer_pago_debt_id = debt_id;
        $("#primer_pago_debt_id").val(primer_pago_debt_id);
    }


    $("#procesarConvenio").click(function () {
        var debt_id = $("#convenio_debt_id").val();
        var number_payment = $("#convenio_num_pay").val();
        var date_payment = $("#fechaConvenio").val();
        var amount = $("#montoConvenio").val();
        var total_debt = $("#convenio_total_debt").val();

        var route = "/pagos/recibir/convenio"

        if (parseInt(amount) > parseInt(total_debt)) {
            toastr.error('Monto mayor al adeudo!', 'Bien hecho!')
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
        var date_pay = $("#fechaPrimerPago").val();
        var amount_pay = $("#montoPrimerPago").val();

        var route = "/control-escolar/generaciones/editar/pago/";

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: {
                debt_id: debt_id,
                date_pay: date_pay,
                amount_pay: amount_pay
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $("#modalEditarPrimerPago .close").click();
                toastr.success('Pago editado exitosamente!', 'Bien hecho!')
                //location.reload();
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
