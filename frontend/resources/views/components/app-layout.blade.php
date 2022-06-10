@extends('adminlte::page')

@section('title', $title.' | RA Alfalah Wahyurejo')

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
{{ $slot }}
@stop

@push('js')
    <script type="text/javascript">
        function confirm_delete() {
            return confirm('Apakah anda yakin untuk menghapus?');
        }
    </script>
@endpush

