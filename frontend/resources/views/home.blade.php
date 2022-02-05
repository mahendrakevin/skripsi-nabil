
{{--@section('content')--}}
{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">{{ __('Dashboard') }}</div>--}}

{{--                <div class="card-body">--}}
{{--                    @if (session('status'))--}}
{{--                        <div class="alert alert-success" role="alert">--}}
{{--                            {{ session('status') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    {{ __('You are logged in!') }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endsection--}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
    <div class="card">
        <div class="container">
            <h2>Contextual Classes</h2>
            <p>Contextual classes can be used to color table rows or table cells. The classes that can be used are: .active, .success, .info, .warning, and .danger.</p>
            <table class="table table-hover table-striped table-responsive">
                <thead>
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Default</td>
                    <td>Defaultson</td>
                    <td>def@somemail.com</td>
                </tr>
                <tr class="success">
                    <td>Success</td>
                    <td>Doe</td>
                    <td>john@example.com</td>
                </tr>
                <tr class="danger">
                    <td>Danger</td>
                    <td>Moe</td>
                    <td>mary@example.com</td>
                </tr>
                <tr class="info">
                    <td>Info</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                </tr>
                <tr class="warning">
                    <td>Warning</td>
                    <td>Refs</td>
                    <td>bo@example.com</td>
                </tr>
                <tr class="active">
                    <td>Active</td>
                    <td>Activeson</td>
                    <td>act@example.com</td>
                </tr>
                </tbody>
            </table>
    </div>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
