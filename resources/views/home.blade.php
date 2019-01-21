@extends('layouts.master')
@section('title')
Inicio
@endsection
@section('content')
@section('header-2')
Panel Principal
@endsection
@if (Auth::user()->hasRole('Vendedor'))
@include('partials.content-vendedor')
@elseif(Auth::user()->hasRole('Administracion'))
@include('partials.content-administracion')
@else
@include('partials.content-admin')
@endif
@endsection

