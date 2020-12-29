@extends('layouts.adminLTEAdmon')
@section('title')
@section('content')
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div id="block-table" style="display: block;">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="cats" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Diplomado</th>
                                    <th>Generación</th>
                                    <th>Fecha de Inicio</th>
                                    <th>Docente</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('admon.payments.create')
    </div><!-- /.container-fluid -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            Charge();
        });

        function reload() {
            $('#cats').each(function() {
                dt = $(this).dataTable();
                dt.fnDraw();
            })
        }

        function reloadApplys(){
       var table = $('#cat_apply').DataTable();
       var id = $("#id_cat").val();
       table.destroy();
        Notiflix.Loading.Dots('Procesando...');
        ChargePays(id);
        Notiflix.Loading.Remove();
    }

        function Charge() {
            $('#cats').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                lengthChange: true,
                processing: true,
                serverSide: true,
                ajax: "{{ url('/admon/CATpagosDocentes/datos') }}",
                columns: [{
                        data: 'diplomat',
                        name: 'diplomat'
                    },
                    {
                        data: 'generation',
                        name: 'generation'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'teacher',
                        name: 'teacher'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
        }

        function ChargePays(id) {
            $('#cat_apply').DataTable({
                "footerCallback": function (row, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total = api
                    .column(1)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(1, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(1).footer()).html(
                    '$' + pageTotal + ' ( $' + total + ' total)'
                );
            },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                lengthChange: true,
                processing: true,
                serverSide: true,
                ajax: "{{ url('/admon/CATpagosDocentes/datos/pagos') }}/" + id,
                columns: [{
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    }
                ]
            });
        }

        function editCat(id) {
            $("#id_cat").val(id);
            $("#block-table").css("display", "none");
            $("#block-create").css("display", "block");
            getCat();
            getScheme();
        }

        function getCat() {
            var id = $("#id_cat").val();
            var route = '{{ url('/admon/CATpagosDocentes/editar') }}/' + id;
            Notiflix.Loading.Dots('Procesando...');
            $.get(route, function(data) {
                Notiflix.Loading.Remove();
                $("#s_diplomat").text(data.cat.diplomat);
                $("#s_generation").text(data.cat.generation);
                $("#s_docent").text(data.cat.teacher);
                $("#s_total_ins").text(data.total_ins);
                $("#s_down").text(data.total_down);
                $("#s_total_pay").text(data.rest);
                $("#i_total_pay").val(data.rest);

            });
        }

        function getScheme() {
            var id = $("#id_cat").val();
            var route = '{{ url('/admon/CATpagosDocentes/esquema') }}/' + id;
            Notiflix.Loading.Dots('Procesando...');
            $.get(route, function(data) {
                Notiflix.Loading.Remove();
                if (data.exist == 1) {
                    $("#block-scheme-create").css("display", "none");
                    $("#block-apply-create").css("display", "block");
                    if (data.scheme.type_scheme == 1) {
                        $("#t_scheme").text('POR ALUMNO');
                        $("#t_cost_student").text(data.scheme.cost_student);
                        $("#t_cost_week").text(data.scheme.cost_week);
                        $("#t_weeks").text(data.scheme.weeks);
                        var rest = $("#i_total_pay").val();
                        var total = (data.scheme.cost_student * rest);
                        $("#t_total_pay").text(total);
                    } else {
                        $("#t_scheme").text('POR SEMANA');
                        $("#t_cost_student").text(data.scheme.cost_student);
                        $("#t_cost_week").text(data.scheme.cost_week);
                        $("#t_weeks").text(data.scheme.weeks);
                        var total = (data.scheme.cost_week * data.scheme.weeks);
                        $("#t_total_pay").text(total);
                    }
                    $("#block-table-pays").css("display", "block");
                    ChargePays(id);
                } else {
                    $("#block-scheme-create").css("display", "block");
                    $("#block-apply-create").css("display", "none");
                    $("#block-table-pays").css("display", "none");
                }

            });
        }

        function cancel() {
            //document.getElementById("form-cat").reset();
            $("#block-table").css("display", "block");
            $("#block-create").css("display", "none");
            $("#block-scheme-create").css("display", "none");
            $("#block-apply-create").css("display", "none");
            $('#message-error-save').css('display', 'none');
        }

        function storeScheme() {
            var type_scheme = $("#type_scheme").val();
            var cost_student = $("#cost_student").val();
            var cost_week = $("#cost_week").val();
            var weeks = $("#weeks").val();
            var generation_id = $("#id_cat").val();

            var route = "/admon/CATpagosDocentes/guardar";

            var form = $("#form-cat");

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    type_scheme: type_scheme,
                    cost_student: cost_student,
                    cost_week: cost_week,
                    weeks: weeks,
                    generation_id: generation_id
                },
                beforeSend: function() {
                    Notiflix.Loading.Dots('Procesando...');
                },
                success: function() {
                    Notiflix.Loading.Remove();
                    $('#message-error-save').css('display', 'none');
                    Notiflix.Report.Success('Bien hecho', 'Has generado un nuevo esquema de pago.', 'Click');
                    reload();
                    document.getElementById("form-cat").reset();
                    getScheme();
                },
                error: function(data) {
                    Notiflix.Loading.Remove();
                    Notiflix.Report.Failure('Algo salió mal', 'Revisa tu información', 'Cerrar');
                    var response = JSON.parse(data.responseText);
                    var errorString = "<ul>";
                    $.each(response.errors, function(key, value) {
                        errorString += "<li>" + value + "</li>";
                    });
                    $("#error-save").html(errorString);
                    $("#message-error-save").fadeIn();
                }
            });
        }

        $("#saveApply").click(function() {
            var date = $("#date_pay").val();
            var amount = $("#amount_pay").val();
            var generation_id = $("#id_cat").val();

            var route = "/admon/CATpagosDocentes/guardar/nuevoPago";

            var form = $("#form-cat");

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    date: date,
                    amount: amount,
                    generation_id: generation_id
                },
                beforeSend: function() {
                    Notiflix.Loading.Dots('Procesando...');
                },
                success: function() {
                    Notiflix.Loading.Remove();
                    $('#message-error-save').css('display', 'none');
                    Notiflix.Report.Success('Bien hecho', 'Has generado un nuevo pago.', 'Click');
                    //reload();
                    //document.getElementById("form-cat").reset();
                    getScheme();
                    reloadApplys();
                },
                error: function(data) {
                    Notiflix.Loading.Remove();
                    Notiflix.Report.Failure('Algo salió mal', 'Revisa tu información', 'Cerrar');
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
    </script>
@endsection
