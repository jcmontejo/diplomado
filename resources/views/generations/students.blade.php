@extends('layouts.master')
@section('title')
Generaciones
@endsection
@section('header-1')
{{$generation->name_diplomat}}
@endsection
@section('header-2')
Lista de Alumnos
@endsection
@section('css')

@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Lista De Alumnos Inscritos</h4>
                <table class="table" id="students">
                    <thead>
                        <th>Nombre Alumno</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Fecha-Hora de Inscripción</th>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        <tr>
                            <td>{{$student->name}}</td>
                            <td>{{$student->last_name}}</td>
                            <td>{{$student->mother_last_name}}</td>
                            {{-- <td>${{number_format($student->debt,2)}}</td> --}}
                            <td><span class="badge badge-pill badge-primary">{{$student->date}}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        $('#students').DataTable();
    });

</script>
@endsection
