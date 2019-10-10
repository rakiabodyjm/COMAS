<!doctype html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
<html lang="en">

@php($request = $_SERVER['REQUEST_URI'])

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/chartist.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pe-icon-7-stroke.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/demo.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pogi.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/light-bootstrap-dashboard.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-grid.css') }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">

    <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('js/chartist.min.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('js/chartist.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-notify.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/typeahead.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/light-bootstrap-dashboard.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/demo.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pogi.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.tablesorter.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('js/canvasjs.min.js') }}"></script> --}}


    {{-- <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"> --}}
    {{-- <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'> --}}

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{config('app.name','LSAPP')}}</title>

    <!-- Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css"> --}}

    <!-- Styles -->


</head>

<body>
    <div class="wrapper">
        @include('inc.sidebar')
        <div class="main-panel">
            @include('inc.navbar')
            @include('inc.messages')
            @yield('content')


        </div>

    </div>


</body>

</html>