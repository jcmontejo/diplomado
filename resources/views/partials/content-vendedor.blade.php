@php
$ten = DB::table('students')->where([
['status', '=', '10'],
['user_id', '=', Auth::user()->id],
])->get();
$twenty = DB::table('students')->where([
['status', '=', '20'],
['user_id', '=', Auth::user()->id],
])->get();
$thirty = DB::table('students')->where([
['status', '=', '30'],
['user_id', '=', Auth::user()->id],
])->get();
$forty = DB::table('students')->where([
['status', '=', '40'],
['user_id', '=', Auth::user()->id],
])->get();
$fifty = DB::table('students')->where([
['status', '=', '50'],
['user_id', '=', Auth::user()->id],
])->get();
$sixty = DB::table('students')->where([
['status', '=', '60'],
['user_id', '=', Auth::user()->id],
])->get();
$seventy = DB::table('students')->where([
['status', '=', '70'],
['user_id', '=', Auth::user()->id],
])->get();
$eighty = DB::table('students')->where([
['status', '=', '80'],
['user_id', '=', Auth::user()->id],
])->get();
$ninety = DB::table('students')->where([
['status', '=', '90'],
['user_id', '=', Auth::user()->id],
])->get();
$one_hundred = DB::table('students')->where([
['status', '=', '100'],
['user_id', '=', Auth::user()->id],
])->get();

$todos = DB::table('todos')->where([
    ['status', '=', '0'],
    ['user_id', '=', Auth::user()->id],
])->get();
@endphp
{{-- Count --}}
<hr>
<div class="row">
    <div class="col-md-6">
        <div class="card  border-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Contador de prospectos</h5>
                <div class="table-wrapper-scroll-y">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">%</th>
                                <th scope="col">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">10</th>
                                <td>{{$ten->count()}}  <a href="{{url('/alumnos/detalles/10')}}"><i class="fa fa-search"></i></a></td>
                            </tr>
                            <tr>
                                <th scope="row">20</th>
                                <td>{{$twenty->count()}}  <a href="{{url('/alumnos/detalles/20')}}"><i class="fa fa-search"></i></a></td>
                            </tr>
                            <tr>
                                <th scope="row">30</th>
                                <td>{{$thirty->count()}}  <a href="{{url('/alumnos/detalles/30')}}"><i class="fa fa-search"></i></a></td>
                            </tr>
                            <tr>
                                <th scope="row">40</th>
                            <td>{{$forty->count()}} <a href="{{url('/alumnos/detalles/40')}}"><i class="fa fa-search"></i></a></td>
                            </tr>
                            <tr>
                                <th scope="row">50</th>
                                <td>{{$fifty->count()}}  <a href="{{url('/alumnos/detalles/50')}}"><i class="fa fa-search"></i></a></td>
                            </tr>
                            <tr>
                                <th scope="row">60</th>
                                <td>{{$sixty->count()}}  <a href="{{url('/alumnos/detalles/60')}}"><i class="fa fa-search"></i></a></td>
                            </tr>
                            <tr>
                                <th scope="row">70</th>
                                <td>{{$seventy->count()}} <a href="{{url('/alumnos/detalles/70')}}"><i class="fa fa-search"></i></a></td>
                            </tr>
                            <tr>
                                <th scope="row">80</th>
                                <td>{{$eighty->count()}}  <a href="{{url('/alumnos/detalles/80')}}"><i class="fa fa-search"></i></a></td>
                            </tr>
                            <tr>
                                <th scope="row">90</th>
                                <td>{{$ninety->count()}}  <a href="{{url('/alumnos/detalles/90')}}"><i class="fa fa-search"></i></a></td>
                            </tr>
                            <tr>
                                <th scope="row">100</th>
                                <td>{{$one_hundred->count()}}  <a href="{{url('/alumnos/detalles/100')}}"><i class="fa fa-search"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tareas <button class="btn btn-xs btn-success float-right" data-toggle="modal" data-target="#todoAdd">Agregar</button></h5>
                @include('todos.ajaxData')
            </div>
        </div>
    </div>
</div>
<!-- sales report area start -->
<div class="sales-report-area mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <div class="card-body">
            <h4>Seguimiento de prospectos</h4>
            <div class="table-responsive">
                <table class="table" id="students">
                    <thead>
                        <th>Nombre Completo</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Facebook</th>
                        <th>Diplomado de Interes</th>
                        <th>SEMAFORO</th>
                    </thead>
                </table>
            </div>
            </div>
            </div>
        </div>
        <hr>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-header">Comisiones pendientes de pago</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="commision_debt">
                            <thead>
                                <th>Comisión</th>
                                <th>Full Price</th>
                                <th>Fecha de creación</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-header">Comisiones pagadas</div>
                <div class="card-body">
                    <table class="table" id="commision_payment">
                        <thead>
                            <th>Comisión</th>
                            <th>Full Price</th>
                            <th>Fecha de creación</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- sales report area end -->
@include('todos.modal-create')
@section('js')
<script>
    $(document).ready(function () {
        Charge();
        commisionDebt();
        commisionPayment();
    });

    function Charge() {
        $('#students').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '/inicio/semaforo/vendedor',
            "order": [
                [5, "dsc"]
            ],
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'last_name',
                    name: 'last_name'
                },
                {
                    data: 'mother_last_name',
                    name: 'mother_last_name'
                },
                {
                    data: 'facebook',
                    name: 'facebook'
                },
                {
                    data: 'interested',
                    name: 'interested'
                },
                {
                    data: 'status',
                    "render": function (data, type, row) {
                        return data + ' %';
                    }
                }
            ]
        });
    }

    function commisionDebt() {
        $('#commision_debt').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '/inicio/comisiones/pendientes',
            columns: [{
                    data: 'commission',
                    name: 'commission'
                },
                {
                    data: 'full_price',
                    name: 'full_price'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                }
            ]
        });
    }

    function commisionPayment() {
        $('#commision_payment').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            ajax: '/inicio/comisiones/pagadas',
            columns: [{
                    data: 'commission',
                    name: 'commission'
                },
                {
                    data: 'full_price',
                    name: 'full_price'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                }
            ]
        });
    }

     $("#saveTodo").click(function () {
        var task_title = $("#task_title").val();
        var route = "/tareas/guardar"

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'json',
            data: {
                title: task_title
            },
            beforeSend: function () {
                $("#preloader").css("display", "block");
            },
            success: function () {
                $("#preloader").css("display", "none");
                $('#task_title').val('');
                $("#todoAdd").modal('toggle');
                $('#message-error').css('display', 'none');
                location.reload();
                // reload();
                swal("Bien hecho!", "Tarea creada!", "success");
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

    function task_done(id){
    $.get("/tareas/actualizar/"+id, function(data) {
        if(data=="OK"){
            location.reload();
            swal("Bien hecho!", "Tarea finalizada!", "success");
        }
    });
    }

</script>
@endsection
