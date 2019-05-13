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
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu1">Adeudan Pago #1</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu2">Adeudan Pago #2</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu3">Adeudan Pago #3</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu4">Adeudan Pago #4</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu5">Adeudan Pago #5</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu6">Adeudan Pago #6</a>
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
                                    <th>PAGO (1)</th>
                                    <th>PAGO (2)</th>
                                    <th>PAGO (3)</th>
                                    <th>PAGO (4)</th>
                                    <th>PAGO (5)</th>
                                    <th>PAGO (6)</th>
                                    <th>COSTO DIPLOMADO</th>
                                    <th>PAGO TOTAL</th>
                                    <th>ADEUDO</th>
                                    <th>ACCIONES</th>
                                </thead>
                                <tbody>
                                    @foreach ($students as $indexKey => $student)
                                    @php
                                    $payment_1 = \DB::table('payments')
                                    ->where('debt_id', '=', $student->debt_id)
                                    ->where('number_payment', '=', '1')
                                    ->first();

                                    $payment_2 = \DB::table('payments')
                                    ->where('debt_id', '=', $student->debt_id)
                                    ->where('number_payment', '=', '2')
                                    ->first();

                                    $payment_3 = \DB::table('payments')
                                    ->where('debt_id', '=', $student->debt_id)
                                    ->where('number_payment', '=', '3')
                                    ->first();

                                    $payment_4 = \DB::table('payments')
                                    ->where('debt_id', '=', $student->debt_id)
                                    ->where('number_payment', '=', '4')
                                    ->first();

                                    $payment_5 = \DB::table('payments')
                                    ->where('debt_id', '=', $student->debt_id)
                                    ->where('number_payment', '=', '5')
                                    ->first();

                                    $payment_6 = \DB::table('payments')
                                    ->where('debt_id', '=', $student->debt_id)
                                    ->where('number_payment', '=', '6')
                                    ->first();
                                    @endphp
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
                                        <td>
                                            @if ($payment_1 AND $payment_1->status != 'PENDIENTE')
                                            ${{number_format($payment_1->amount_paid,2)}}({{$payment_1->date}})
                                            @else
                                            <span style="color:red;">
                                                <button @if ($student->total_debt == 0)
                                                    disabled
                                                @endif class="btn btn-success btn-xs" onclick="modalPay(1,{{$student->debt_id}});" data-toggle="modal" data-target="#modalPay"><i class="fa fa-money"></i> Pagar</button>
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($payment_2 AND $payment_2->status != 'PENDIENTE')
                                            ${{number_format($payment_2->amount_paid,2)}}({{$payment_1->date}})
                                            @else
                                            <span style="color:red;">
                                                <button @if ($student->total_debt == 0)
                                                    disabled
                                                @endif class="btn btn-success btn-xs" onclick="modalPay(2,{{$student->debt_id}});" data-toggle="modal" data-target="#modalPay"><i class="fa fa-money"></i> Pagar</button>
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($payment_3 AND $payment_3->status != 'PENDIENTE')
                                            ${{number_format($payment_3->amount_paid,2)}}({{$payment_1->date}})
                                            @else
                                            <span style="color:red;">
                                                <button @if ($student->total_debt == 0)
                                                    disabled
                                                @endif class="btn btn-success btn-xs" onclick="modalPay(3,{{$student->debt_id}});" data-toggle="modal" data-target="#modalPay"><i class="fa fa-money"></i> Pagar</button>
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($payment_4 AND $payment_4->status != 'PENDIENTE')
                                            ${{number_format($payment_4->amount_paid,2)}}({{$payment_1->date}})
                                            @else
                                            <span style="color:red;">
                                                <button @if ($student->total_debt == 0)
                                                    disabled
                                                @endif class="btn btn-success btn-xs" onclick="modalPay(4,{{$student->debt_id}});" data-toggle="modal" data-target="#modalPay"><i class="fa fa-money"></i> Pagar</button>
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($payment_5 AND $payment_5->status != 'PENDIENTE')
                                            ${{number_format($payment_5->amount_paid,2)}}({{$payment_1->date}})
                                            @else
                                            <span style="color:red;">
                                                <button @if ($student->total_debt == 0)
                                                    disabled
                                                @endif class="btn btn-success btn-xs" onclick="modalPay(5,{{$student->debt_id}});" data-toggle="modal" data-target="#modalPay"><i class="fa fa-money"></i> Pagar</button>
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($payment_6 AND $payment_6->status != 'PENDIENTE')
                                            ${{number_format($payment_6->amount_paid,2)}}({{$payment_1->date}})
                                            @else
                                            <span style="color:red;">
                                                <button @if ($student->total_debt == 0)
                                                    disabled
                                                @endif class="btn btn-success btn-xs" onclick="modalPay(6,{{$student->debt_id}});" data-toggle="modal" data-target="#modalPay"><i class="fa fa-money"></i> Pagar</button>
                                            </span>
                                            @endif
                                        </td>
                                        <td>${{number_format($student->final_cost,2)}}</td>
                                        <td>${{number_format($student->final_cost - $student->total_debt,2)}}</td>
                                        <td>${{number_format($student->total_debt,2 )}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button value="{{$student->id_inscription}}" OnClick="Show(this);"
                                                    class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal"
                                                    data-target="#modalShow"><i class="fa fa-eye"></i>
                                                    Detalles</button>
                                                @if ($student->status === 'Alta')
                                                <button value="{{$student->id_inscription}}" OnClick="Down(this);"
                                                    class="btn btn-rounded btn-xs btn-danger mb-3" data-toggle="modal"
                                                    data-target="#modalDown"><i class="fa fa-thumbs-down"></i>
                                                    Dar de Baja</button>
                                                @else
                                                <button value="{{$student->id_inscription}}" OnClick="Up(this);" class="btn btn-rounded btn-xs btn-success mb-3"
                                                    data-toggle="modal" data-target="#modalUp"><i class="fa fa-thumbs-up"></i>
                                                    Activar</button>
                                                <button value="{{$student->id_inscription}}" OnClick="DetailsDown(this);"
                                                    class="btn btn-rounded btn-xs btn-primary mb-3" data-toggle="modal"
                                                    data-target="#modalDetails"><i class="fa fa-info"></i>
                                                    Detalles de Baja</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                
                                <tfoot>
                                    <tr>
                                        <td colspan="16"></td>
                                        <td style="text-align: center;">
                                            <h4 class="float-left">TOTALES</h4>
                                        </td>
                                        <td>
                                            <h5>${{number_format($cost,2)}}</h5>
                                        </td>
                                        <td>
                                            <h5>${{number_format($cost - $debt_global,2)}}</h5>
                                        </td>
                                        <td>
                                            <h5>${{number_format($debt_global,2)}}</h5>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="menu1">
                        <h4 class="header-title">NOMBRE DEL DIPLOMADO: {{$generation->name_diplomat}}</h4>
                        <h3 class="header-title">GENERACIÓN: {{$generation->number_generation}}</h3>
                        <div class="table-responsive">
                            <table class="table display" id="students1">
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
                                    <th>PAGO (1)</th>
                                    <th>COSTO DIPLOMADO</th>
                                    <th>PAGO TOTAL</th>
                                    <th>ADEUDO</th>
                                    <th>ACCIONES</th>
                                </thead>
                                <tbody>
                                    @foreach ($students as $indexKey => $student)
                                    @php
                                    $payment_1 = \DB::table('payments')
                                    ->where('debt_id', '=', $student->debt_id)
                                    ->where('number_payment', '=', '1')
                                    ->where('status', '=', 'PENDIENTE')
                                    ->first();
                                    @endphp
                                    @if ($payment_1)
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
                                        <td>
                                            @if ($payment_1 AND $payment_1->status != 'PENDIENTE')
                                            ${{number_format($payment_1->amount_paid,2)}}({{$payment_1->date}})
                                            @else
                                            <span style="color:red;">-------</span>
                                            @endif
                                        </td>
                                        <td>${{number_format($student->final_cost,2)}}</td>
                                        <td>${{number_format($student->final_cost - $student->total_debt,2)}}</td>
                                        <td>${{number_format($student->total_debt,2 )}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button value="{{$student->id_inscription}}" OnClick="Show(this);"
                                                    class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal"
                                                    data-target="#modalShow"><i class="fa fa-eye"></i>
                                                    Detalles</button>
                                                @if ($student->status === 'Alta')
                                                <button value="{{$student->id_inscription}}" OnClick="Down(this);"
                                                    class="btn btn-rounded btn-xs btn-danger mb-3" data-toggle="modal"
                                                    data-target="#modalDown"><i class="fa fa-thumbs-down"></i>
                                                    Dar de Baja</button>
                                                @else
                                                <button value="{{$student->id_inscription}}" OnClick="Up(this);" class="btn btn-rounded btn-xs btn-success mb-3"
                                                    data-toggle="modal" data-target="#modalUp"><i class="fa fa-thumbs-up"></i>
                                                    Activar</button>
                                                <button value="{{$student->id_inscription}}" OnClick="DetailsDown(this);"
                                                    class="btn btn-rounded btn-xs btn-primary mb-3" data-toggle="modal"
                                                    data-target="#modalDetails"><i class="fa fa-info"></i>
                                                    Detalles de Baja</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <td colspan="9"></td>
                                        <td style="text-align: center;">
                                            <h4 class="float-left">TOTALES</h4>
                                        </td>
                                        <td>
                                            <h5>${{number_format($cost,2)}}</h5>
                                        </td>
                                        <td>
                                            <h5>${{number_format($cost - $debt_global,2)}}</h5>
                                        </td>
                                        <td>
                                            <h5>${{number_format($debt_global,2)}}</h5>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot> --}}
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="menu2">
                        <h4 class="header-title">NOMBRE DEL DIPLOMADO: {{$generation->name_diplomat}}</h4>
                        <h3 class="header-title">GENERACIÓN: {{$generation->number_generation}}</h3>
                        <div class="table-responsive">
                            <table class="table display" id="students1">
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
                                    <th>PAGO (2)</th>
                                    <th>COSTO DIPLOMADO</th>
                                    <th>PAGO TOTAL</th>
                                    <th>ADEUDO</th>
                                    <th>ACCIONES</th>
                                </thead>
                                <tbody>
                                    @foreach ($students as $indexKey => $student)
                                    @php
                                    $payment_2 = \DB::table('payments')
                                    ->where('debt_id', '=', $student->debt_id)
                                    ->where('number_payment', '=', '2')
                                    ->where('status', '=', 'PENDIENTE')
                                    ->first();
                                    @endphp
                                    @if ($payment_2)
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
                                        <td>
                                            @if ($payment_2 AND $payment_2->status != 'PENDIENTE')
                                            ${{number_format($payment_2->amount_paid,2)}}({{$payment_2->date}})
                                            @else
                                            <span style="color:red;">-------</span>
                                            @endif
                                        </td>
                                        <td>${{number_format($student->final_cost,2)}}</td>
                                        <td>${{number_format($student->final_cost - $student->total_debt,2)}}</td>
                                        <td>${{number_format($student->total_debt,2 )}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button value="{{$student->id_inscription}}" OnClick="Show(this);"
                                                    class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal"
                                                    data-target="#modalShow"><i class="fa fa-eye"></i>
                                                    Detalles</button>
                                                @if ($student->status === 'Alta')
                                                <button value="{{$student->id_inscription}}" OnClick="Down(this);"
                                                    class="btn btn-rounded btn-xs btn-danger mb-3" data-toggle="modal"
                                                    data-target="#modalDown"><i class="fa fa-thumbs-down"></i>
                                                    Dar de Baja</button>
                                                @else
                                                <button value="{{$student->id_inscription}}" OnClick="Up(this);" class="btn btn-rounded btn-xs btn-success mb-3"
                                                    data-toggle="modal" data-target="#modalUp"><i class="fa fa-thumbs-up"></i>
                                                    Activar</button>
                                                <button value="{{$student->id_inscription}}" OnClick="DetailsDown(this);"
                                                    class="btn btn-rounded btn-xs btn-primary mb-3" data-toggle="modal"
                                                    data-target="#modalDetails"><i class="fa fa-info"></i>
                                                    Detalles de Baja</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <td colspan="9"></td>
                                        <td style="text-align: center;">
                                            <h4 class="float-left">TOTALES</h4>
                                        </td>
                                        <td>
                                            <h5>${{number_format($cost,2)}}</h5>
                                        </td>
                                        <td>
                                            <h5>${{number_format($cost - $debt_global,2)}}</h5>
                                        </td>
                                        <td>
                                            <h5>${{number_format($debt_global,2)}}</h5>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot> --}}
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="menu3">
                        <h4 class="header-title">NOMBRE DEL DIPLOMADO: {{$generation->name_diplomat}}</h4>
                        <h3 class="header-title">GENERACIÓN: {{$generation->number_generation}}</h3>
                        <div class="table-responsive">
                            <table class="table display" id="students1">
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
                                    <th>PAGO (3)</th>
                                    <th>COSTO DIPLOMADO</th>
                                    <th>PAGO TOTAL</th>
                                    <th>ADEUDO</th>
                                    <th>ACCIONES</th>
                                </thead>
                                <tbody>
                                    @foreach ($students as $indexKey => $student)
                                    @php
                                    $payment_3 = \DB::table('payments')
                                    ->where('debt_id', '=', $student->debt_id)
                                    ->where('number_payment', '=', '3')
                                    ->where('status', '=', 'PENDIENTE')
                                    ->first();
                                    @endphp
                                    @if ($payment_3)
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
                                        <td>
                                            @if ($payment_3 AND $payment_3->status != 'PENDIENTE')
                                            ${{number_format($payment_3->amount_paid,2)}}({{$payment_3->date}})
                                            @else
                                            <span style="color:red;">-------</span>
                                            @endif
                                        </td>
                                        <td>${{number_format($student->final_cost,2)}}</td>
                                        <td>${{number_format($student->final_cost - $student->total_debt,2)}}</td>
                                        <td>${{number_format($student->total_debt,2 )}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button value="{{$student->id_inscription}}" OnClick="Show(this);"
                                                    class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal"
                                                    data-target="#modalShow"><i class="fa fa-eye"></i>
                                                    Detalles</button>
                                                @if ($student->status === 'Alta')
                                                <button value="{{$student->id_inscription}}" OnClick="Down(this);"
                                                    class="btn btn-rounded btn-xs btn-danger mb-3" data-toggle="modal"
                                                    data-target="#modalDown"><i class="fa fa-thumbs-down"></i>
                                                    Dar de Baja</button>
                                                @else
                                                <button value="{{$student->id_inscription}}" OnClick="Up(this);" class="btn btn-rounded btn-xs btn-success mb-3"
                                                    data-toggle="modal" data-target="#modalUp"><i class="fa fa-thumbs-up"></i>
                                                    Activar</button>
                                                <button value="{{$student->id_inscription}}" OnClick="DetailsDown(this);"
                                                    class="btn btn-rounded btn-xs btn-primary mb-3" data-toggle="modal"
                                                    data-target="#modalDetails"><i class="fa fa-info"></i>
                                                    Detalles de Baja</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <td colspan="9"></td>
                                        <td style="text-align: center;">
                                            <h4 class="float-left">TOTALES</h4>
                                        </td>
                                        <td>
                                            <h5>${{number_format($cost,2)}}</h5>
                                        </td>
                                        <td>
                                            <h5>${{number_format($cost - $debt_global,2)}}</h5>
                                        </td>
                                        <td>
                                            <h5>${{number_format($debt_global,2)}}</h5>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot> --}}
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="menu4">
                        <h4 class="header-title">NOMBRE DEL DIPLOMADO: {{$generation->name_diplomat}}</h4>
                        <h3 class="header-title">GENERACIÓN: {{$generation->number_generation}}</h3>
                        <div class="table-responsive">
                            <table class="table display" id="students1">
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
                                    <th>PAGO (4)</th>
                                    <th>COSTO DIPLOMADO</th>
                                    <th>PAGO TOTAL</th>
                                    <th>ADEUDO</th>
                                    <th>ACCIONES</th>
                                </thead>
                                <tbody>
                                    @foreach ($students as $indexKey => $student)
                                    @php
                                    $payment_4 = \DB::table('payments')
                                    ->where('debt_id', '=', $student->debt_id)
                                    ->where('number_payment', '=', '4')
                                    ->where('status', '=', 'PENDIENTE')
                                    ->first();
                                    @endphp
                                    @if ($payment_4)
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
                                        <td>
                                            @if ($payment_4 AND $payment_4->status != 'PENDIENTE')
                                            ${{number_format($payment_4->amount_paid,2)}}({{$payment_4->date}})
                                            @else
                                            <span style="color:red;">-------</span>
                                            @endif
                                        </td>
                                        <td>${{number_format($student->final_cost,2)}}</td>
                                        <td>${{number_format($student->final_cost - $student->total_debt,2)}}</td>
                                        <td>${{number_format($student->total_debt,2 )}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button value="{{$student->id_inscription}}" OnClick="Show(this);"
                                                    class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal"
                                                    data-target="#modalShow"><i class="fa fa-eye"></i>
                                                    Detalles</button>
                                                @if ($student->status === 'Alta')
                                                <button value="{{$student->id_inscription}}" OnClick="Down(this);"
                                                    class="btn btn-rounded btn-xs btn-danger mb-3" data-toggle="modal"
                                                    data-target="#modalDown"><i class="fa fa-thumbs-down"></i>
                                                    Dar de Baja</button>
                                                @else
                                                <button value="{{$student->id_inscription}}" OnClick="Up(this);" class="btn btn-rounded btn-xs btn-success mb-3"
                                                    data-toggle="modal" data-target="#modalUp"><i class="fa fa-thumbs-up"></i>
                                                    Activar</button>
                                                <button value="{{$student->id_inscription}}" OnClick="DetailsDown(this);"
                                                    class="btn btn-rounded btn-xs btn-primary mb-3" data-toggle="modal"
                                                    data-target="#modalDetails"><i class="fa fa-info"></i>
                                                    Detalles de Baja</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <td colspan="9"></td>
                                        <td style="text-align: center;">
                                            <h4 class="float-left">TOTALES</h4>
                                        </td>
                                        <td>
                                            <h5>${{number_format($cost,2)}}</h5>
                                        </td>
                                        <td>
                                            <h5>${{number_format($cost - $debt_global,2)}}</h5>
                                        </td>
                                        <td>
                                            <h5>${{number_format($debt_global,2)}}</h5>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot> --}}
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="menu5">
                        <h4 class="header-title">NOMBRE DEL DIPLOMADO: {{$generation->name_diplomat}}</h4>
                        <h3 class="header-title">GENERACIÓN: {{$generation->number_generation}}</h3>
                        <div class="table-responsive">
                            <table class="table display" id="students1">
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
                                    <th>PAGO (5)</th>
                                    <th>COSTO DIPLOMADO</th>
                                    <th>PAGO TOTAL</th>
                                    <th>ADEUDO</th>
                                    <th>ACCIONES</th>
                                </thead>
                                <tbody>
                                    @foreach ($students as $indexKey => $student)
                                    @php
                                    $payment_5 = \DB::table('payments')
                                    ->where('debt_id', '=', $student->debt_id)
                                    ->where('number_payment', '=', '5')
                                    ->where('status', '=', 'PENDIENTE')
                                    ->first();
                                    @endphp
                                    @if ($payment_5)
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
                                        <td>
                                            @if ($payment_5 AND $payment_5->status != 'PENDIENTE')
                                            ${{number_format($payment_5->amount_paid,2)}}({{$payment_5->date}})
                                            @else
                                            <span style="color:red;">-------</span>
                                            @endif
                                        </td>
                                        <td>${{number_format($student->final_cost,2)}}</td>
                                        <td>${{number_format($student->final_cost - $student->total_debt,2)}}</td>
                                        <td>${{number_format($student->total_debt,2 )}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button value="{{$student->id_inscription}}" OnClick="Show(this);"
                                                    class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal"
                                                    data-target="#modalShow"><i class="fa fa-eye"></i>
                                                    Detalles</button>
                                                @if ($student->status === 'Alta')
                                                <button value="{{$student->id_inscription}}" OnClick="Down(this);"
                                                    class="btn btn-rounded btn-xs btn-danger mb-3" data-toggle="modal"
                                                    data-target="#modalDown"><i class="fa fa-thumbs-down"></i>
                                                    Dar de Baja</button>
                                                @else
                                                <button value="{{$student->id_inscription}}" OnClick="Up(this);" class="btn btn-rounded btn-xs btn-success mb-3"
                                                    data-toggle="modal" data-target="#modalUp"><i class="fa fa-thumbs-up"></i>
                                                    Activar</button>
                                                <button value="{{$student->id_inscription}}" OnClick="DetailsDown(this);"
                                                    class="btn btn-rounded btn-xs btn-primary mb-3" data-toggle="modal"
                                                    data-target="#modalDetails"><i class="fa fa-info"></i>
                                                    Detalles de Baja</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <td colspan="9"></td>
                                        <td style="text-align: center;">
                                            <h4 class="float-left">TOTALES</h4>
                                        </td>
                                        <td>
                                            <h5>${{number_format($cost,2)}}</h5>
                                        </td>
                                        <td>
                                            <h5>${{number_format($cost - $debt_global,2)}}</h5>
                                        </td>
                                        <td>
                                            <h5>${{number_format($debt_global,2)}}</h5>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot> --}}
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="menu6">
                        <h4 class="header-title">NOMBRE DEL DIPLOMADO: {{$generation->name_diplomat}}</h4>
                        <h3 class="header-title">GENERACIÓN: {{$generation->number_generation}}</h3>
                        <div class="table-responsive">
                            <table class="table display" id="students1">
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
                                    <th>PAGO (6)</th>
                                    <th>COSTO DIPLOMADO</th>
                                    <th>PAGO TOTAL</th>
                                    <th>ADEUDO</th>
                                    <th>ACCIONES</th>
                                </thead>
                                <tbody>
                                    @foreach ($students as $indexKey => $student)
                                    @php
                                    $payment_6 = \DB::table('payments')
                                    ->where('debt_id', '=', $student->debt_id)
                                    ->where('number_payment', '=', '6')
                                    ->where('status', '=', 'PENDIENTE')
                                    ->first();
                                    @endphp
                                    @if ($payment_6)
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
                                        <td>
                                            @if ($payment_6 AND $payment_6->status != 'PENDIENTE')
                                            ${{number_format($payment_6->amount_paid,2)}}({{$payment_6->date}})
                                            @else
                                            <span style="color:red;">-------</span>
                                            @endif
                                        </td>
                                        <td>${{number_format($student->final_cost,2)}}</td>
                                        <td>${{number_format($student->final_cost - $student->total_debt,2)}}</td>
                                        <td>${{number_format($student->total_debt,2 )}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button value="{{$student->id_inscription}}" OnClick="Show(this);"
                                                    class="btn btn-rounded btn-xs btn-info mb-3" data-toggle="modal"
                                                    data-target="#modalShow"><i class="fa fa-eye"></i>
                                                    Detalles</button>
                                                @if ($student->status === 'Alta')
                                                <button value="{{$student->id_inscription}}" OnClick="Down(this);"
                                                    class="btn btn-rounded btn-xs btn-danger mb-3" data-toggle="modal"
                                                    data-target="#modalDown"><i class="fa fa-thumbs-down"></i>
                                                    Dar de Baja</button>
                                                @else
                                                <button value="{{$student->id_inscription}}" OnClick="Up(this);" class="btn btn-rounded btn-xs btn-success mb-3"
                                                    data-toggle="modal" data-target="#modalUp"><i class="fa fa-thumbs-up"></i>
                                                    Activar</button>
                                                <button value="{{$student->id_inscription}}" OnClick="DetailsDown(this);"
                                                    class="btn btn-rounded btn-xs btn-primary mb-3" data-toggle="modal"
                                                    data-target="#modalDetails"><i class="fa fa-info"></i>
                                                    Detalles de Baja</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <td colspan="9"></td>
                                        <td style="text-align: center;">
                                            <h4 class="float-left">TOTALES</h4>
                                        </td>
                                        <td>
                                            <h5>${{number_format($cost,2)}}</h5>
                                        </td>
                                        <td>
                                            <h5>${{number_format($cost - $debt_global,2)}}</h5>
                                        </td>
                                        <td>
                                            <h5>${{number_format($debt_global,2)}}</h5>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot> --}}
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
