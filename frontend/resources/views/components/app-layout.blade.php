@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
{{ $slot }}
@stop
