<!-- data table start -->
<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
            <div class="col-sm-5 form-group">
                <div class="input-group">
                    <input class="form-control" id="search" value="{{ request()->session()->get('search') }}"
                        onkeyup="if (event.keyCode == 13) ajaxLoad('{{url('generaciones/alumnos/inscritos/'.$generation->id.'/')}}?search='+this.value)"
                        placeholder="Buscar nombre" name="search" type="text" id="search" />
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-success"
                            onclick="ajaxLoad('{{url('generaciones/alumnos/inscritos/'.$generation->id.'/')}}?search='+$('#search').val())">
                            Buscar
                        </button>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs" style="background-color:#7986cb;">
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
                                <th>COMPLETO PAGO</th>
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

                                $agreement_1 = \DB::table('agreements')
                                ->where('debt_id', '=', $student->debt_id)
                                ->where('num_pay', '=', '1')
                                ->first();

                                $agreement_2 = \DB::table('agreements')
                                ->where('debt_id', '=', $student->debt_id)
                                ->where('num_pay', '=', '2')
                                ->first();

                                $agreement_3 = \DB::table('agreements')
                                ->where('debt_id', '=', $student->debt_id)
                                ->where('num_pay', '=', '3')
                                ->first();

                                $agreement_4 = \DB::table('agreements')
                                ->where('debt_id', '=', $student->debt_id)
                                ->where('num_pay', '=', '4')
                                ->first();

                                $agreement_5 = \DB::table('agreements')
                                ->where('debt_id', '=', $student->debt_id)
                                ->where('num_pay', '=', '5')
                                ->first();

                                $agreement_6 = \DB::table('agreements')
                                ->where('debt_id', '=', $student->debt_id)
                                ->where('num_pay', '=', '6')
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
                                        <div class="btn-group">
                                            <button @if ($student->total_debt == 0)
                                                disabled
                                                @endif class="btn btn-success btn-xs"
                                                onclick="modalPay(1,{{$student->debt_id}});"
                                                data-toggle="modal"
                                                data-target="#modalPay"><i class="fa fa-money"></i>
                                                Pagar</button>
                                            <button @if ($agreement_1 OR $student->total_debt == 0)
                                                class="btn btn-warning btn-xs"
                                                disabled
                                                @endif class="btn btn-primary btn-xs"
                                                onclick="modalConvenio(1,{{$student->debt_id}});"
                                                data-toggle="modal"
                                                data-target="#modalConvenio"><i class="fa fa-calendar"></i>
                                                Convenio </button>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($payment_2 AND $payment_2->status != 'PENDIENTE')
                                        ${{number_format($payment_2->amount_paid,2)}}({{$payment_1->date}})
                                        @else
                                        <div class="btn-group">
                                            <button @if ($student->total_debt == 0)
                                                disabled
                                                @endif class="btn btn-success btn-xs"
                                                onclick="modalPay(2,{{$student->debt_id}});"
                                                data-toggle="modal"
                                                data-target="#modalPay"><i class="fa fa-money"></i>
                                                Pagar</button>
                                            <button @if ($agreement_2 OR $student->total_debt == 0)
                                                class="btn btn-warning btn-xs"
                                                disabled
                                                @endif class="btn btn-primary btn-xs"
                                                onclick="modalConvenio(2,{{$student->debt_id}});"
                                                data-toggle="modal"
                                                data-target="#modalConvenio"><i class="fa fa-calendar"></i>
                                                Convenio </button>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($payment_3 AND $payment_3->status != 'PENDIENTE')
                                        ${{number_format($payment_3->amount_paid,2)}}({{$payment_1->date}})
                                        @else
                                        <div class="btn-group">
                                            <button @if ($student->total_debt == 0)
                                                disabled
                                                @endif class="btn btn-success btn-xs"
                                                onclick="modalPay(3,{{$student->debt_id}});"
                                                data-toggle="modal"
                                                data-target="#modalPay"><i class="fa fa-money"></i>
                                                Pagar</button>
                                            <button @if ($agreement_3 OR $student->total_debt == 0)
                                                class="btn btn-warning btn-xs"
                                                disabled
                                                @endif class="btn btn-primary btn-xs"
                                                onclick="modalConvenio(3,{{$student->debt_id}});"
                                                data-toggle="modal"
                                                data-target="#modalConvenio"><i class="fa fa-calendar"></i>
                                                Convenio </button>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($payment_4 AND $payment_4->status != 'PENDIENTE')
                                        ${{number_format($payment_4->amount_paid,2)}}({{$payment_1->date}})
                                        @else
                                        <div class="btn-group">
                                            <button @if ($student->total_debt == 0)
                                                disabled
                                                @endif class="btn btn-success btn-xs"
                                                onclick="modalPay(4,{{$student->debt_id}});"
                                                data-toggle="modal"
                                                data-target="#modalPay"><i class="fa fa-money"></i>
                                                Pagar</button>
                                            <button @if ($agreement_4 OR $student->total_debt == 0)
                                                class="btn btn-warning btn-xs"
                                                disabled
                                                @endif class="btn btn-primary btn-xs"
                                                onclick="modalConvenio(4,{{$student->debt_id}});"
                                                data-toggle="modal"
                                                data-target="#modalConvenio"><i class="fa fa-calendar"></i>
                                                Convenio </button>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($payment_5 AND $payment_5->status != 'PENDIENTE')
                                        ${{number_format($payment_5->amount_paid,2)}}({{$payment_1->date}})
                                        @else
                                        <div class="btn-group">
                                            <button @if ($student->total_debt == 0)
                                                disabled
                                                @endif class="btn btn-success btn-xs"
                                                onclick="modalPay(5,{{$student->debt_id}});"
                                                data-toggle="modal"
                                                data-target="#modalPay"><i class="fa fa-money"></i>
                                                Pagar</button>
                                            <button @if ($agreement_5 OR $student->total_debt == 0)
                                                class="btn btn-warning btn-xs"
                                                disabled
                                                @endif class="btn btn-primary btn-xs"
                                                onclick="modalConvenio(5,{{$student->debt_id}});"
                                                data-toggle="modal"
                                                data-target="#modalConvenio"><i class="fa fa-calendar"></i>
                                                Convenio </button>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($payment_6 AND $payment_6->status != 'PENDIENTE')
                                        ${{number_format($payment_6->amount_paid,2)}}({{$payment_1->date}})
                                        @else
                                        <div class="btn-group">
                                            <button @if ($student->total_debt == 0)
                                                disabled
                                                @endif class="btn btn-success btn-xs"
                                                onclick="modalPay(6,{{$student->debt_id}});"
                                                data-toggle="modal"
                                                data-target="#modalPay"><i class="fa fa-money"></i>
                                                Pagar</button>
                                            <button @if ($agreement_6 OR $student->total_debt == 0)
                                                class="btn btn-warning btn-xs"
                                                disabled
                                                @endif class="btn btn-primary btn-xs"
                                                onclick="modalConvenio(6,{{$student->debt_id}});"
                                                data-toggle="modal"
                                                data-target="#modalConvenio"><i class="fa fa-calendar"></i>
                                                Convenio </button>
                                        </div>
                                        @endif
                                    </td>
                                    <td>${{number_format($student->final_cost,2)}}</td>
                                    <td>${{number_format($student->final_cost - $student->total_debt,2)}}</td>
                                    <td>${{number_format($student->total_debt,2 )}}</td>
                                    <td>@if ($student->total_debt == 0)
                                        SI @else NO
                                        @endif</td>
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
                                            <button value="{{$student->id_inscription}}" OnClick="Up(this);"
                                                class="btn btn-rounded btn-xs btn-success mb-3" data-toggle="modal"
                                                data-target="#modalUp"><i class="fa fa-thumbs-up"></i>
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
                                            <button value="{{$student->id_inscription}}" OnClick="Up(this);"
                                                class="btn btn-rounded btn-xs btn-success mb-3" data-toggle="modal"
                                                data-target="#modalUp"><i class="fa fa-thumbs-up"></i>
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
                                            <button value="{{$student->id_inscription}}" OnClick="Up(this);"
                                                class="btn btn-rounded btn-xs btn-success mb-3" data-toggle="modal"
                                                data-target="#modalUp"><i class="fa fa-thumbs-up"></i>
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
                                            <button value="{{$student->id_inscription}}" OnClick="Up(this);"
                                                class="btn btn-rounded btn-xs btn-success mb-3" data-toggle="modal"
                                                data-target="#modalUp"><i class="fa fa-thumbs-up"></i>
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
                                            <button value="{{$student->id_inscription}}" OnClick="Up(this);"
                                                class="btn btn-rounded btn-xs btn-success mb-3" data-toggle="modal"
                                                data-target="#modalUp"><i class="fa fa-thumbs-up"></i>
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
                                            <button value="{{$student->id_inscription}}" OnClick="Up(this);"
                                                class="btn btn-rounded btn-xs btn-success mb-3" data-toggle="modal"
                                                data-target="#modalUp"><i class="fa fa-thumbs-up"></i>
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
                                            <button value="{{$student->id_inscription}}" OnClick="Up(this);"
                                                class="btn btn-rounded btn-xs btn-success mb-3" data-toggle="modal"
                                                data-target="#modalUp"><i class="fa fa-thumbs-up"></i>
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
