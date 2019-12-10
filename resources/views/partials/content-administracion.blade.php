
@php
$todos = DB::table('todos')->where([
    ['status', '=', '0'],
    ['user_id', '=', Auth::user()->id],
])->get();

@endphp
{{-- Count --}}
<hr>
<div class="row">
 <div class="container">
        <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Estudiantes Inscritos Recientemente</h5>
                <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="recent_inscriptions">
                            <thead>
                                <th>Diplomado</th>
                                <th>Generación</th>
                                <th>Nombre Estudiante</th>
                                <th>Matricula</th>
                                <th>CURP</th>
                                <th>Fecha-Hora de Inscripción</th>
                                <th>Acciones</th>
                            </thead>
                        </table>
                    </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tareas <button class="btn btn-xs btn-success float-right" data-toggle="modal" data-target="#todoAdd">Agregar</button></h5>
                @include('todos.ajaxData')
            </div>
        </div>
    </div>
 </div>
</div>
