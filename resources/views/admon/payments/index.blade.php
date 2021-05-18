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

        function reloadApplys() {
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
                destroy: true,
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api(),
                        data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(3)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    pageTotal = api
                        .column(3, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Update footer
                    $(api.column(3).footer()).html(
                        '$' + pageTotal + ' ( $' + total + ' total)'
                    );
                },
                lengthMenu: [
                    [25, 100, -1],
                    [25, 100, "Todos"]
                ],
                pageLength: 25,
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'excel',
                    text: '<span class="fas fa-file-excel-o"></span> Exportar Excel',
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied'
                        }
                    }
                }],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                lengthChange: true,
                processing: true,
                serverSide: true,
                ajax: "{{ url('/admon/CATpagosDocentes/datos/pagos') }}/" + id,
                columns: [{
                        data: 'number',
                        name: 'number'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'amount_expected',
                        name: 'amount_expected'
                    },
                    {
                        data: 'amount_paid_out',
                        name: 'amount_paid_out'
                    },
                    {
                        data: 'rest',
                        name: 'rest'
                    },
                    {
                        data: 'status',
                        "render": function(data, type, row, meta) {
                            if (data == 1) {
                                return 'PENDIENTE';
                            } else {
                                return 'PAGADO';
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action'
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

        function editCatPaidOut(id) {
            $("#ID_paid_out").val(id);
            //alert(id);
            //$("#block-table").css("display", "none");
            $("#block-paid_out").css("display", "block");
            //getCat();
            //getScheme();
        }

        function getCat() {
            var id = $("#id_cat").val();
            var route = "{{ url('/admon/CATpagosDocentes/editar') }}/" + id;
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
            var route = "{{ url('/admon/CATpagosDocentes/esquema') }}/" + id;
            Notiflix.Loading.Dots('Procesando...');
            $.get(route, function(data) {
                Notiflix.Loading.Remove();
                if (data.exist == 1) {
                    $("#block-scheme-create").css("display", "none");
                    $("#block-apply-create").css("display", "block");
                    $("#ID_scheme").val(data.scheme.id);
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

        function getSchemeTwo() {
            var id = $("#id_cat").val();
            var route = "{{ url('/admon/CATpagosDocentes/esquema') }}/" + id;
            Notiflix.Loading.Dots('Procesando...');
            $.get(route, function(data) {
                Notiflix.Loading.Remove();
                $("#block-apply-create").css("display", "none");
                $("#block-edit-scheme").css("display", "block");
                $("#ID_scheme_to_edit").val(data.scheme.id);
                $("#type_scheme_e").val(data.scheme.type_scheme).change();
                $("#cost_student_e").val(data.scheme.cost_student);
                $("#cost_week_e").val(data.scheme.cost_week);
                $("#weeks_e").val(data.scheme.weeks);
                $("#number_payments_e").val(data.scheme.number_payments);
            });
        }

        function cancel() {
            //document.getElementById("form-cat").reset();
            $("#block-table").css("display", "block");
            $("#block-create").css("display", "none");
            $("#block-scheme-create").css("display", "none");
            $("#block-apply-create").css("display", "none");
            $('#message-error-save').css('display', 'none');
            reload();
        }

        function cancelSchemeEdit() {
            //document.getElementById("form-cat").reset();
            getScheme();
            $("#block-apply-create").css("display", "block");
            $("#block-edit-scheme").css("display", "none");
        }

        function storeScheme() {
            var type_scheme = $("#type_scheme").val();
            var cost_student = $("#cost_student").val();
            var cost_week = $("#cost_week").val();
            var weeks = $("#weeks").val();
            var number_payments = $("#number_payments").val();
            var total_students = $("#i_total_pay").val();
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
                    total_students: total_students,
                    number_payments: number_payments,
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
                    //reload();
                    cancel();
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

        function updateScheme() {
            var id = $("#ID_scheme_to_edit").val();
            var type_scheme = $("#type_scheme_e").val();
            var cost_student = $("#cost_student_e").val();
            var cost_week = $("#cost_week_e").val();
            var weeks = $("#weeks_e").val();
            var number_payments = $("#number_payments_e").val();
            var total_students = $("#i_total_pay").val();
            var generation_id = $("#id_cat").val();


            var route = "/admon/CATpagosDocentes/actualizar/" + id;

            Notiflix.Confirm.Show(
                'Cat Pagos a Docentes',
                '¿Esta seguro de modificar el esquema de pagos? Los pagos que ya fueron efectuados se veran afectados.',
                'Si',
                'No',
                function() {
                    $.ajax({
                        url: route,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'PUT',
                        dataType: 'json',
                        data: {
                            type_scheme: type_scheme,
                            cost_student: cost_student,
                            cost_week: cost_week,
                            weeks: weeks,
                            total_students: total_students,
                            number_payments: number_payments,
                            generation_id: generation_id
                        },
                        beforeSend: function() {
                            Notiflix.Loading.Dots('Procesando...');
                        },
                        success: function() {
                            Notiflix.Loading.Remove();
                            $('#message-error-save').css('display', 'none');
                            Notiflix.Report.Success('Bien hecho', 'Has actualizado correctamente.',
                                'Cerrar');
                            reload();
                            cancel();
                            $("#block-edit-scheme").css("display", "none");

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
                },
                function() { // No button callback
                    Notiflix.Notify.Warning('Petición cancelada.');
                }
            );
        }
        

        $("#saveApply").click(function() {
            var id = $("#ID_paid_out").val();
            var date = $("#date_pay").val();
            var amount = $("#amount_pay").val();
            var scheme = $("#ID_scheme").val();
            var total_students = $("#i_total_pay").val();
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
                    id: id,
                    date: date,
                    amount: amount,
                    scheme: scheme,
                    total_students: total_students,
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
                    $("#ID_paid_out").val("");
                    $("#block-paid_out").css("display", "none");
                    $("#date_pay").val("");
                    $("#amount_pay").val("");
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
