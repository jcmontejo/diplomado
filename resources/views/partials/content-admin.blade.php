@php
    $students_actives = DB::table('students')->
        join('debts', 'debts.student_id', '=', 'students.id')
        ->where('debts.status','=', 'ACTIVA');
    $docents = DB::table('teachers');
    $users = DB::table('users');
    $debt = DB::table('debts')
        ->where('status', '=', 'ACTIVA')->get();
    $expenses = DB::table('expenses')->get();
    $payment_receiveds = DB::table('payment_receiveds')->get();
@endphp
<!-- sales report area start -->
<div class="sales-report-area mt-5 mb-5">
    <div class="row">
        <div class="col-md-4">
            <div class="single-report mb-xs-30">
                <div class="s-report-inner pr--20 pt--30 mb-3">
                    <div class="icon"><i class="fa fa-users"></i></div>
                    <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">Estudiantes Activos</h4>
                    </div>
                    <div class="d-flex justify-content-between pb-2">
                    <h2>{{$students_actives->count()}}</h2>
                    </div>
                </div>
                <canvas id="coin_sales1" height="100"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="single-report mb-xs-30">
                <div class="s-report-inner pr--20 pt--30 mb-3">
                    <div class="icon"><i class="fa fa-user-secret"></i></div>
                    <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">Docentes</h4>
                    </div>
                    <div class="d-flex justify-content-between pb-2">
                        <h2>{{$docents->count()}}</h2>
                    </div>
                </div>
                <canvas id="coin_sales2" height="100"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="single-report">
                <div class="s-report-inner pr--20 pt--30 mb-3">
                    <div class="icon"><i class="fa fa-check-square"></i></div>
                    <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">Usuarios del sistema</h4>
                    </div>
                    <div class="d-flex justify-content-between pb-2">
                        <h2>{{$users->count()}}</h2>
                    </div>
                </div>
                <canvas id="coin_sales3" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
<!-- sales report area end -->
<!-- Incomes report  -->
<div class="sales-report-area mt-5 mb-5">
    <div class="row">
        <div class="col-md-4 mt-5 mb-3">
            <div class="card">
                <div class="seo-fact sbg1">
                    <div class="p-4 d-flex justify-content-between align-items-center">
                        <div class="seofct-icon"><i class="fa fa-money"></i>Pagos realizados</div>
                    <h2>${{number_format($payment_receiveds->sum('amount'),2)}}</h2>
                    </div>
                    <canvas id="seolinechart1" height="50"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-md-5 mb-3">
            <div class="card">
                <div class="seo-fact sbg2">
                    <div class="p-4 d-flex justify-content-between align-items-center">
                        <div class="seofct-icon"><i class="fa fa-money"></i>Pagos pendientes</div>
                        <h2>${{number_format($debt->sum('amount'),2)}}</h2>
                    </div>
                    <canvas id="seolinechart2" height="50"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-md-5 mb-3">
            <div class="card">
                <div class="seo-fact sbg3">
                    <div class="p-4 d-flex justify-content-between align-items-center">
                        <div class="seofct-icon"><i class="fa fa-money"></i>Gastos</div>
                        <h2>${{number_format($expenses->sum('amount'),2)}}
                        </h2>
                    </div>
                    <canvas id="seolinechart2" height="50"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
