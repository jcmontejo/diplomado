@extends('layouts.master')
@section('title')
Generaciones
@endsection
@section('header-1')
Reporte de Adeudos
@endsection
@section('header-2')
Lista de Alumnos
@endsection
@section('css')
<style>
    .lightRed {
  background-color: #ff8080 !important
}

.lightRed a {
  color: #fff;
  font-weight: bold;
}

.red {
  background-color: #f00;
}
</style>
@endsection
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
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane container active" id="home">
                        <h4 class="header-title">NOMBRE DEL DIPLOMADO: {{$generation->name_diplomat}}</h4>
                        <h3 class="header-title">GENERACIÓN: {{$generation->number_generation}}</h3>
                        <div class="table-responsive">
                            <table class="table display" id="students">
                                <thead>
                                    <th>NP</th>
                                    <th>ESTATUS</th>
                                    <th>NOMBRE DEL ALUMNO</th>
                                    <th>MATRICULA</th>
                                    <th>CURP</th>
                                    <th>EMAIL</th>
                                    <th>TELÉFONO</th>
                                    <th>DOCUMENTOS</th>
                                    <th>OBSERVACIONES</th>
                                    <th>DES. APLICABLE</th>
                                    <th>INSCRIPCIÓN</th>
                                    <th>COSTO DIPLOMADO</th>
                                </thead>
                                <tbody>
                                    @foreach ($students as $indexKey => $student)
                                    <tr>
                                        <td>{{$indexKey+1}}</td>
                                        <td>{{$student->status}}</td>
                                        <td>{{$student->full_name}}</td>
                                        <td>{{$student->enrollment}}</td>
                                        <td>{{$student->curp}}</td>
                                        <td>{{$student->email}}</td>
                                        <td>{{$student->phone}}</td>
                                        <td>{{$student->documents}}</td>
                                        <td>{{$student->observations}}</td>
                                        <td>${{number_format($student->discount,2)}}</td>
                                        <td>${{number_format($student->first_payment,2)}}</td>
                                        <td>${{number_format($student->final_cost,2)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
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
@endsection
@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
<script>
    $(document).ready(function () {

        $('table.display').DataTable({
            "dom": 'lBfrtip',
            "buttons": ['csv', 'excel', 'print'],
            // "columnDefs": [{
            //     "targets": 1,
            //     "render": function (data, type, full, meta) {
            //         var cellText = $(data).text(); //Stripping html tags !!!
            //         if (type === 'display' && (cellText == "Baja" || data == 'Baja')) {
            //             var rowIndex = meta.row + 1;
            //             var colIndex = meta.col + 1;
            //             $('#students tbody tr:nth-child(' + rowIndex + ')').addClass(
            //                 'lightRed');
            //             $('#students tbody tr:nth-child(' + rowIndex + ') td:nth-child(' +
            //                 colIndex + ')').addClass('red');
            //             return data;
            //         } else {
            //             return data;
            //         }
            //     }
            // }]
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
