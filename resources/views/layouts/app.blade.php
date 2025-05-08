<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Elektron žurnal') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('icon.png')}}" />
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{ asset('bootstrap/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"defer></script>
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    <!-- jQuery -->
    <script src="{{ asset('bootstrap/js/jquery/jquery.min.js')}}"></script>

    <!-- Scripts -->
</body>
</html>
