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
                                <img class="profile-user-img img-fluid img-circle"
                                    src="https://images.unsplash.com/photo-1554629947-334ff61d85dc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=376&q=80"
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
                <div class="col-md-9">
                    @forelse($inscriptions as $key => $value)
                    @php
                    $payment_1 = \DB::table('payments')
                    ->where('debt_id', '=', $value->debt_id)
                    ->where('number_payment', '=', '1')
                    ->first();

                    $payment_2 = \DB::table('payments')
                    ->where('debt_id', '=', $value->debt_id)
                    ->where('number_payment', '=', '2')
                    ->first();

                    $payment_3 = \DB::table('payments')
                    ->where('debt_id', '=', $value->debt_id)
                    ->where('number_payment', '=', '3')
                    ->first();

                    $payment_4 = \DB::table('payments')
                    ->where('debt_id', '=', $value->debt_id)
                    ->where('number_payment', '=', '4')
                    ->first();

                    $payment_5 = \DB::table('payments')
                    ->where('debt_id', '=', $value->debt_id)
                    ->where('number_payment', '=', '5')
                    ->first();

                    $payment_6 = \DB::table('payments')
                    ->where('debt_id', '=', $value->debt_id)
                    ->where('number_payment', '=', '6')
                    ->first();

                    $agreement_1 = \DB::table('agreements')
                    ->where('debt_id', '=', $value->debt_id)
                    ->where('num_pay', '=', '1')
                    ->first();

                    $agreement_2 = \DB::table('agreements')
                    ->where('debt_id', '=', $value->debt_id)
                    ->where('num_pay', '=', '2')
                    ->first();

                    $agreement_3 = \DB::table('agreements')
                    ->where('debt_id', '=', $value->debt_id)
                    ->where('num_pay', '=', '3')
                    ->first();

                    $agreement_4 = \DB::table('agreements')
                    ->where('debt_id', '=', $value->debt_id)
                    ->where('num_pay', '=', '4')
                    ->first();

                    $agreement_5 = \DB::table('agreements')
                    ->where('debt_id', '=', $value->debt_id)
                    ->where('num_pay', '=', '5')
                    ->first();

                    $agreement_6 = \DB::table('agreements')
                    ->where('debt_id', '=', $value->debt_id)
                    ->where('num_pay', '=', '6')
                    ->first();
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
                                                    <th>TOTAL PAGADO</th>
                                                    <th>TOTAL ADEUDO</th>
                                                    <th>COMPLETO PAGO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">${{number_format($value->final_cost,2)}}</th>
                                                    <td>${{number_format($value->final_cost - $value->amount,2)}}</td>
                                                    <td>${{number_format($value->amount,2)}}</td>
                                                    <td>@if ($value->amount == 0)
                                                        SI @else NO
                                                        @endif</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{-- <div class="timeline-footer">
                                    <a class="btn btn-primary btn-sm">Read more</a>
                                    <a class="btn btn-danger btn-sm">Delete</a>
                                </div> --}}
                            </div>
                        </div>
                        <!-- END timeline item -->
                        <!-- timeline item -->
                        <div>
                            <i class="fas fa-funnel-dollar bg-green"></i>
                            <div class="timeline-item">
                                <h3 class="timeline-header no-border"><a href="#">HOSTORIAL DE PAGOS</a> </h3>
                                <div class="timeline-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>PAGO (1)</th>
                                                    <th>PAGO (2)</th>
                                                    <th>PAGO (3)</th>
                                                    <th>PAGO (4)</th>
                                                    <th>PAGO (5)</th>
                                                    <th>PAGO (6)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        @if ($payment_1 AND $payment_1->status != 'PENDIENTE')
                                                        ${{number_format($payment_1->amount_paid,2)}}({{$payment_1->date}})<br>
                                                        @else
                                                        <div class="btn-group">
                                                            <button @if ($value->amount == 0)
                                                                disabled
                                                                @endif class="btn btn-success"><i
                                                                    class="fas fa-money-bill"></i>
                                                                PENDIENTE</button>
                                                        </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($payment_2 AND $payment_2->status != 'PENDIENTE')
                                                        ${{number_format($payment_2->amount_paid,2)}}({{$payment_2->date}})<br><button
                                                            data-toggle="modal" data-target="#modalEditarPago"
                                                            onclick="editarPago({{$student->debt_id}}, {{$student->total_debt}}, 2);"
                                                            class="btn btn-xs btn-info"><i class="fas fa-edit"></i>
                                                            Modificar</button>
                                                        @else
                                                        <div class="btn-group">
                                                            <button @if ($value->amount == 0)
                                                                disabled
                                                                @endif class="btn btn-success"><i
                                                                    class="fas fa-money-bill"></i>
                                                                PENDIENTE</button>
                                                        </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($payment_3 AND $payment_3->status != 'PENDIENTE')
                                                        ${{number_format($payment_3->amount_paid,2)}}({{$payment_3->date}})<br><button
                                                            data-toggle="modal" data-target="#modalEditarPago"
                                                            onclick="editarPago({{$student->debt_id}}, {{$student->total_debt}}, 3);"
                                                            class="btn btn-xs btn-info"><i class="fas fa-edit"></i>
                                                            Modificar</button>
                                                        @else
                                                        <div class="btn-group">
                                                            <button @if ($value->amount == 0)
                                                                disabled
                                                                @endif class="btn btn-success"><i
                                                                    class="fas fa-money-bill"></i>
                                                                PENDIENTE</button>
                                                        </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($payment_4 AND $payment_4->status != 'PENDIENTE')
                                                        ${{number_format($payment_4->amount_paid,2)}}({{$payment_1->date}})<br><button
                                                            data-toggle="modal" data-target="#modalEditarPago"
                                                            onclick="editarPago({{$student->debt_id}}, {{$student->total_debt}}, 4);"
                                                            class="btn btn-xs btn-info"><i class="fas fa-edit"></i>
                                                            Modificar</button>
                                                        @else
                                                        <div class="btn-group">
                                                            <button @if ($value->amount == 0)
                                                                disabled
                                                                @endif class="btn btn-success"><i
                                                                    class="fas fa-money-bill"></i>
                                                                PENDIENTE</button>
                                                        </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($payment_5 AND $payment_5->status != 'PENDIENTE')
                                                        ${{number_format($payment_5->amount_paid,2)}}({{$payment_1->date}})<br><button
                                                            data-toggle="modal" data-target="#modalEditarPago"
                                                            onclick="editarPago({{$student->debt_id}}, {{$student->total_debt}}, 5);"
                                                            class="btn btn-xs btn-info"><i class="fas fa-edit"></i>
                                                            Modificar</button>
                                                        @else
                                                        <div class="btn-group">
                                                            <button @if ($value->amount == 0)
                                                                disabled
                                                                @endif class="btn btn-success"><i
                                                                    class="fas fa-money-bill"></i>
                                                                PENDIENTE</button>
                                                        </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($payment_6 AND $payment_6->status != 'PENDIENTE')
                                                        ${{number_format($payment_6->amount_paid,2)}}({{$payment_1->date}})<br><button
                                                            data-toggle="modal" data-target="#modalEditarPago"
                                                            onclick="editarPago({{$student->debt_id}}, {{$student->total_debt}}, 6);"
                                                            class="btn btn-xs btn-info"><i class="fas fa-edit"></i>
                                                            Modificar</button>
                                                        @else
                                                        <div class="btn-group">
                                                            <button @if ($value->amount == 0)
                                                                disabled
                                                                @endif class="btn btn-success"><i
                                                                    class="fas fa-money-bill"></i>
                                                                PENDIENTE</button>
                                                        </div>
                                                        @endif
                                                    </td>
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
@endsection
