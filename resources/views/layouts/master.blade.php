<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SERendipity® - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/icon/icono_ser.png')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/metisMenu.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/slicknav.min.css')}}">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="{{asset('assets/css/typography.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/default-css.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    <!-- modernizr css -->
    <script src="{{asset('assets/js/vendor/modernizr-2.8.3.min.js')}}"></script>
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{asset('/css/sweetalert2.min.css')}}">
    {{-- Datatables --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('/datatables/buttons.dataTables.css')}}">
    <style>
        /* Styles for wrapping the search box */

.main {
    width: 50%;
    margin: 50px auto;
}

/* Bootstrap 4 text input with search icon */

.has-search .form-control {
    padding-left: 2.375rem;
}

.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
}
        #invoice{
    padding: 30px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #3989c6
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,.invoice table th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #3989c6
}

.invoice table .unit {
    background: #ddd
}

.invoice table .total {
    background: #3989c6;
    color: #fff
}

.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}

.invoice table tfoot tr:last-child td {
    color: #3989c6;
    font-size: 1.4em;
    border-top: 1px solid #3989c6
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}
        .table-wrapper-scroll-y {
display: block;
max-height: 200px;
overflow-y: auto;
-ms-overflow-style: -ms-autohiding-scrollbar;
}
        /* Preloader */
#preloader{
	display: none;
	background: rgba(39, 60, 117,.5);
	position: fixed;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	z-index: 1100 !important;
}
    #preloader > .bar {
  display: inline-block;
  padding: 0px;
  text-align: left;
  left: 50%;
  top: 50%;
  position: absolute;
  width: 150px;
  height: 20px;
  border: 1px solid #2980b9;
  background-size: 28px 28px;
}
    </style>
    @yield('css')
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div id="preloader">
        <div class="bar">
            <i class="fa fa-spinner fa-spin" style="font-size:100px"></i>
        </div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="{{url('/home')}}"><img src="{{asset('assets/images/icon/logo_ser.png')}}" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li class="active">
                                @can('modulo-inicio')
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Inicio</span></a>
                                <ul class="collapse">
                                    <li class="{{ Request::url()== url('/home') ? 'active' : '' }}"><a href="{{url('/home')}}">Panel
                                            Principal</a></li>
                                </ul>
                                @endcan
                            </li>
                            <li>
                                @can('modulo-perfil')
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-user"></i><span>Perfil</span></a>
                                <ul class="collapse {{ Request::url()== url('/perfil') ? 'in' : '' }}">
                                    <li class="{{ Request::url()== url('/perfil') ? 'active' : '' }}"><a href="{{url('/perfil')}}">Actualizar
                                            Perfil</a></li>
                                </ul>
                                @endcan
                            </li>
                            <li>
                                @can('modulo-alumnos')
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-id-badge"></i><span>Alumnos</span></a>
                                <ul class="collapse {{ Request::url()== url('/alumnos') ? 'in' : '' }}">
                                    @if (Auth::user()->hasRole('Control Escolar'))
                                    <li class="{{ Request::url()== url('/alumnos') ? 'active' : '' }}"><a href="{{url('/alumnos')}}">Estudiantes</a></li>
                                    @else
                                    <li class="{{ Request::url()== url('/alumnos') ? 'active' : '' }}"><a href="{{url('/alumnos')}}">Estudiantes</a></li>
                                    <li class="{{ Request::url()== url('/alumnos/prospectos') ? 'active' : '' }}"><a
                                            href="{{url('/alumnos/prospectos')}}">Seguimiento de Prospectos</a></li>
                                    @endif
                                </ul>
                                @endcan
                            </li>
                            <li>
                                @can('modulo-docentes')
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-blackboard"></i><span>Docentes</span></a>
                                <ul class="collapse {{ Request::url()== url('/docentes') ? 'in' : '' }}">
                                    <li class="{{ Request::url()== url('/docentes') ? 'active' : '' }}"><a href="{{url('/docentes')}}">Todos
                                            los Docentes</a></li>
                                </ul>
                                @endcan
                            </li>
                            <li>
                                @can('modulo-control-escolar')
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-agenda"></i><span>Control
                                        Escolar</span></a>
                                <ul class="collapse {{ Request::url()== url('/diplomados') ? 'in' : '' }}">
                                    <li class="{{ Request::url()== url('/diplomados') ? 'active' : '' }}"><a href="{{url('diplomados')}}">Diplomados</a></li>
                                    <li class="{{ Request::url()== url('/generaciones') ? 'active' : '' }}"><a href="{{url('/generaciones')}}">Generaciones</a></li>
                                </ul>
                                @endcan
                            </li>
                            <li>
                                @can('modulo-cuentas-bancarias')
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-bank"></i>
                                    <span>Cuentas Bancarias</span></a>
                                <ul class="collapse {{ Request::url()== url('/cuentas') ? 'in' : '' }}">
                                    <li class="{{ Request::url()== url('/cuentas') ? 'active' : '' }}"><a href="{{url('/cuentas')}}">Todas
                                            las Cuentas</a></li>
                                </ul>
                                @endcan
                            </li>
                            <li>
                                @can('modulo-transacciones')
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-money"></i>
                                    <span>Transacciones</span></a>
                                <ul class="collapse">
                                    <li><a href="{{url('/pagos/ingresos')}}">Ingresos</a></li>
                                    <li><a href="{{url('/gastos')}}">Egresos</a></li>
                                    <li><a href="{{url('/comisiones')}}">Comisiones</a></li>
                                    <li><a href="{{url('/metodos-de-pago')}}">Metodos de Pago</a></li>
                                </ul>
                                @endcan
                            </li>
                            <li>
                                @can('modulo-transacciones')
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-key"></i>
                                    <span>Movimientos</span></a>
                                <ul class="collapse">
                                    <li><a href="{{url('/pagos/ingresos/modificar')}}">Modificar Pagos</a></li>
                                </ul>
                                @endcan
                            </li>
                            <li>
                                @can('modulo-cuotas-de-estudiantes')
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-credit-card"></i>
                                    <span>Cuotas de Estudiantes</span></a>
                                <ul class="collapse">
                                    <li><a href="{{url('/cuotas')}}">Tipos de Cuotas</a></li>
                                    <li><a href="{{url('/pagos/procesar')}}">Recibir Pago</a></li>
                                    {{-- <li><a href="#">Historico de Pagos</a></li> --}}
                                </ul>
                                @endcan
                            </li>
                            <li>
                                @can('modulo-emails')
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-envelope"></i>
                                    <span>Email</span></a>
                                <ul class="collapse">
                                    <li><a href="{{url('/mensajeria/crear')}}">Enviar</a></li>
                                    <li><a href="#">Mensajes Enviados</a></li>
                                </ul>
                                @endcan
                            </li>
                            <li>
                                @can('modulo-reportes')
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-line-chart"></i>
                                    <span>Reportes</span></a>
                                <ul class="collapse">
                                    @if (Auth::user()->hasRole('Vendedor'))
                                    <li><a href="{{url('/inicio/reporte/prospectos')}}">Reporte de Prospectos (Área de
                                            ventas)</a></li>
                                    @else
                                    <li><a href="{{url('/pagos/ingresos')}}">Reporte de Ingresos</a></li>
                                    <li><a href="{{url('/gastos')}}">Reporte de Egresos</a></li>
                                    <li><a href="{{url('/reportes/adeudos')}}">Reporte de Adeudos</a></li>
                                    <li><a href="{{url('/reportes/no-documentos')}}">Reporte de Estudiantes Faltantes
                                            de Documentación</a></li>
                                    @endif
                                </ul>
                                @endcan
                            </li>
                            {{-- <li class="{{ Request::url()== url('/usuarios') ? 'active' : '' }}"><a href="{{url('/usuarios')}}"><i
                                        class="fa fa-users"></i> <span>Gestión de Usuarios</span></a></li> --}}
                            <li>
                                @can('modulo-administracion')
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-cogs"></i> <span>Administración</span></a>
                                <ul class="collapse">
                                    <li class="{{ Request::url()== url('/usuarios') ? 'active' : '' }}"><a href="{{url('/usuarios')}}">Gestión
                                            de Usuarios</a></li>
                                    <li><a href="{{url('/admin/roles')}}">Roles de Usuario</a></li>
                                    {{-- <li><a href="#">Permisos de Usuario</a></li>
                                    <li><a href="#">copia de seguridad de base de datos</a></li> --}}
                                </ul>
                                @endcan
                            </li>
                            {{-- <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user-md"></i> <span>Historia
                                        Clinica</span></a>
                                <ul class="collapse">
                                    <li><a href="#">Consultorios</a></li>
                                    <li><a href="#">Médicos</a></li>
                                    <li><a href="#">Pacientes</a></li>
                                    <li><a href="#">Citas</a></li>
                                </ul>
                            </li> --}}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        {{-- <div class="search-box pull-left">
                            <form action="#">
                                <input type="text" name="search" placeholder="Buscar..." required>
                                <i class="ti-search"></i>
                            </form>
                        </div> --}}
                    </div>
                    <!-- profile info & task notification -->
                    {{-- <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                            <li class="dropdown">
                                <i class="ti-bell dropdown-toggle" data-toggle="dropdown">
                                    <span>2</span>
                                </i>
                                <div class="dropdown-menu bell-notify-box notify-box">
                                    <span class="notify-title">You have 3 new notifications <a href="#">view all</a></span>
                                    <div class="nofity-list">
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb"><i class="ti-key btn-danger"></i></div>
                                            <div class="notify-text">
                                                <p>You have Changed Your Password</p>
                                                <span>Just Now</span>
                                            </div>
                                        </a>
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb"><i class="ti-comments-smiley btn-info"></i></div>
                                            <div class="notify-text">
                                                <p>New Commetns On Post</p>
                                                <span>30 Seconds ago</span>
                                            </div>
                                        </a>
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb"><i class="ti-key btn-primary"></i></div>
                                            <div class="notify-text">
                                                <p>Some special like you</p>
                                                <span>Just Now</span>
                                            </div>
                                        </a>
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb"><i class="ti-comments-smiley btn-info"></i></div>
                                            <div class="notify-text">
                                                <p>New Commetns On Post</p>
                                                <span>30 Seconds ago</span>
                                            </div>
                                        </a>
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb"><i class="ti-key btn-primary"></i></div>
                                            <div class="notify-text">
                                                <p>Some special like you</p>
                                                <span>Just Now</span>
                                            </div>
                                        </a>
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb"><i class="ti-key btn-danger"></i></div>
                                            <div class="notify-text">
                                                <p>You have Changed Your Password</p>
                                                <span>Just Now</span>
                                            </div>
                                        </a>
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb"><i class="ti-key btn-danger"></i></div>
                                            <div class="notify-text">
                                                <p>You have Changed Your Password</p>
                                                <span>Just Now</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown">
                                <i class="fa fa-envelope-o dropdown-toggle" data-toggle="dropdown"><span>3</span></i>
                                <div class="dropdown-menu notify-box nt-enveloper-box">
                                    <span class="notify-title">You have 3 new notifications <a href="#">view all</a></span>
                                    <div class="nofity-list">
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb">
                                                <img src="{{asset('assets/images/author/author-img1.jpg')}}" alt="image">
                                            </div>
                                            <div class="notify-text">
                                                <p>Aglae Mayer</p>
                                                <span class="msg">Hey I am waiting for you...</span>
                                                <span>3:15 PM</span>
                                            </div>
                                        </a>
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb">
                                                <img src="{{asset('assets/images/author/author-img2.jpg')}}" alt="image">
                                            </div>
                                            <div class="notify-text">
                                                <p>Aglae Mayer</p>
                                                <span class="msg">When you can connect with me...</span>
                                                <span>3:15 PM</span>
                                            </div>
                                        </a>
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb">
                                                <img src="{{asset('assets/images/author/author-img3.jpg')}}" alt="image">
                                            </div>
                                            <div class="notify-text">
                                                <p>Aglae Mayer</p>
                                                <span class="msg">I missed you so much...</span>
                                                <span>3:15 PM</span>
                                            </div>
                                        </a>
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb">
                                                <img src="{{asset('assets/images/author/author-img4.jpg')}}" alt="image">
                                            </div>
                                            <div class="notify-text">
                                                <p>Aglae Mayer</p>
                                                <span class="msg">Your product is completely Ready...</span>
                                                <span>3:15 PM</span>
                                            </div>
                                        </a>
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb">
                                                <img src="{{asset('assets/images/author/author-img2.jpg')}}" alt="image">
                                            </div>
                                            <div class="notify-text">
                                                <p>Aglae Mayer</p>
                                                <span class="msg">Hey I am waiting for you...</span>
                                                <span>3:15 PM</span>
                                            </div>
                                        </a>
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb">
                                                <img src="{{asset('assets/images/author/author-img1.jpg')}}" alt="image">
                                            </div>
                                            <div class="notify-text">
                                                <p>Aglae Mayer</p>
                                                <span class="msg">Hey I am waiting for you...</span>
                                                <span>3:15 PM</span>
                                            </div>
                                        </a>
                                        <a href="#" class="notify-item">
                                            <div class="notify-thumb">
                                                <img src="{{asset('assets/images/author/author-img3.jpg')}}" alt="image">
                                            </div>
                                            <div class="notify-text">
                                                <p>Aglae Mayer</p>
                                                <span class="msg">Hey I am waiting for you...</span>
                                                <span>3:15 PM</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div> --}}
                </div>
            </div>
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">@yield('header-1')</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="{{url('/home')}}">Inicio</a></li>
                                <li><span>@yield('header-2')</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="{{asset('/images/user.png')}}" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"> {{ Auth::user()->name }} <i
                                    class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Cerrar
                                    Sesión</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                @yield('content')
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <footer>
            <div class="footer-area">
                <p>© Copyright 2018. Todos los Derechos son Reservados. Sistema web desarrollado por <a href="https://www.linkedin.com/in/jcmontejo/"
                        target=”_blank”>Juan
                        Carlos Montejo</a>.</p>
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <!-- jquery latest version -->
    <script src="{{asset('assets/js/vendor/jquery-2.2.4.min.js')}}"></script>
    <!-- bootstrap 4 js -->
    <script src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.slicknav.min.js')}}"></script>

    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
        zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
        ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];

    </script>
    <!-- all line chart activation -->
    <script src="{{asset('assets/js/line-chart.js')}}"></script>
    <!-- all pie chart -->
    <script src="{{asset('assets/js/pie-chart.js')}}"></script>
    <!-- others plugins -->
    <script src="{{asset('assets/js/plugins.js')}}"></script>
    <script src="{{asset('assets/js/scripts.js')}}"></script>
    {{-- SweetAlert --}}
    <script src="{{asset('/js/sweetalert2.min.js')}}"></script>
    {{-- Datatables --}}
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('/datatables/buttons.server-side.js')}}"></script>
    <script src="{{asset('/datatables/dataTables.buttons.js')}}"></script>

    {{-- SummerNote --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.js"></script>
    @yield('js')
</body>

</html>
