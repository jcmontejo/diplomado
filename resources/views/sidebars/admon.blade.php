<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/admon/inicio')}}" class="brand-link">
        <img
            src="{{asset('/adminLTE/dist/img/AdminLTELogo.png')}}"
            alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: .8">
            <span class="brand-text font-weight-light">SERendipity</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img
                        src="{{asset('/adminLTE/dist/img/user2-160x160.jpg')}}"
                        class="img-circle elevation-2"
                        alt="User Image"></div>
                    <div class="info">
                        <a href="#" class="d-block">{{Auth::user()->name}}</a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul
                        class="nav nav-pills nav-sidebar flex-column"
                        data-widget="treeview"
                        role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any
                        other icon font library -->
                        <li class="nav-item">
                            <a href="{{url('/admon/inicio')}}" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Inicio
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/admon/perfil')}}" class="nav-link">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>
                                    Perfil
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/admon/cuentas')}}" class="nav-link">
                                <i class="nav-icon fas fa-piggy-bank"></i>
                                <p>
                                    Bancos
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cash-register"></i>
                                <p>
                                    Control Diario
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('/admon/CATpagosDocentes/listado')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pagos Docentes</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('/admon/CATegresos/listado')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Egresos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('#') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ingresos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/admon/CATclasificaciones/listado') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cat Clasificaciones</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/admon/CATreferencias/listado') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cat Referencias</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/admon/docentes/lista')}}" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Docentes
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/admon/diplomados/lista')}}" class="nav-link">
                                <i class="nav-icon fas fa-swatchbook"></i>
                                <p>
                                    Diplomados
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/admon/generaciones/lista')}}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Generaciones
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/admon/alumnos/lista')}}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Alumnos
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                                class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                                <p>Salir</p>
                                <form
                                    id="logout-form"
                                    action="{{ route('logout') }}"
                                    method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>