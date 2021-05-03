@extends('layouts.adminLTESales')
@section('title')
@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div id="block-table" style="display: block;">
            <div class="card shadow-lg">
                <div class="card-header bg-header-card">
                    {{ $grupo->nombre }}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="cats" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Seminario</th>
                                    <th>Grupo</th>
                                    <th>Matricula estudiante</th>
                                    <th>Estudiante</th>
                                    <th>Costo seminario</th>
                                    <th>Descuento</th>
                                    <th>Primer pago</th>
                                    <th>Falta por pagar</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($estudiantes as $estudiante)
                                    <tr @if ($estudiante->deuda <= 0)
                                        class="bg-success-custom"
                                    @endif>
                                        <td>{{ $estudiante->seminario }}</td>
                                        <td>{{ $estudiante->grupo }}</td>
                                        <td>{{ $estudiante->matricula }}</td>
                                        <td>{{ $estudiante->estudiante }}</td>
                                        <td>{{ $estudiante->costo_final }}</td>
                                        <td>{{ $estudiante->descuento }}</td>
                                        <td>{{ $estudiante->primer_pago }}</td>
                                        <td>{{ $estudiante->deuda }}</td>
                                        <td>
                                            @if ($estudiante->deuda <= 0)
                                                PAGADO
                                            @else
                                                PENDIENTE
                                            @endif
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            reload();
        });

        function reload() {
            $('#cats').each(function() {
                dt = $(this).dataTable({
                    dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
        ]
                });
                dt.fnDraw();
            })
        }
    </script>
@endsection
