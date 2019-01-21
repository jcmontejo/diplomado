@extends('layouts.master')
@section('title')
Roles de Usuario
@endsection
@section('header-1')
Roles de Usuario
@endsection
@section('header-2')
Roles de Usuario
@endsection
@section('content')
@if(session()->has('message'))
<div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('message') }}
</div>
@endif
<!-- Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
    <div class="modal-dialog" role="document">
        {!! Form::open(['method' => 'post']) !!}

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="roleModalLabel">Rol</h4>
            </div>
            <div class="modal-body">
                <!-- name Form Input -->
                <div class="form-group @if ($errors->has('name')) has-error @endif">
                    {!! Form::label('name', 'Nombre') !!} {!! Form::text('name', null, ['class' => 'form-control
                    input-lg', 'placeholder' => 'Nombre del rol']) !!} @if ($errors->has('name'))
                    <p class="help-block">{{ $errors->first('name') }}</p> @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <!-- Submit Form Button -->
                {!! Form::submit('Crear', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <p class="card-description float-right">
            <a href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#roleModal">
                <i class="fa fa-plus"></i>
                Agregar Nuevo Rol</a>
        </p>
    </div>
    <!-- /.box-header -->
    <div class="card-body">
        @forelse ($roles as $role)
        {!! Form::model($role, ['method' => 'PUT', 'route' => ['roles.update', $role->id ], 'class' => 'm-b']) !!}

        @if($role->name === 'Admin')
        @include('shared._permissions', [
        'title' => $role->name .' Permisos',
        'options' => ['disabled'] ])
        @else
        @include('shared._permissions', [
        'title' => $role->name .' Permisos',
        'model' => $role ])
        {{-- @can('editar_roles') --}}
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        {{-- @endcan --}}
        @endif
        <hr>
        {!! Form::close() !!}
        @empty
        <p>No hay roles definidos, por favor contacte al <code>Administrador del sistema</code> para resolver el
            detalle.</p>
        @endforelse
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
@endsection 
@section('js')
<script type="text/javascript">
    $(document).ready(function () {
        $('#roles').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false
            }, ],
            order: [
                [0, "asc"]
            ],
        });
    });
</script>
@endsection
