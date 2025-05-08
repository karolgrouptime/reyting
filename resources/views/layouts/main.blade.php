<!-- CSRF Token -->
<head>
<title>Elektron žurnal - @yield('title')</title>

<meta charset="utf-8">
<!-- Custom Fonts -->
<link href="{{ asset('bootstrap/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

<link rel="shortcut icon" type="image/x-icon" href="{{asset('icon.png')}}" />
<!-- Bootstrap Core CSS -->
<link href="{{asset('bootstrap/css/bootstrap.css')}}" rel="stylesheet">
<!-- Bootstrap Core CSS -->

<!-- Bootstrap Core CSS -->
<link href="{{asset('css/style.css')}}" rel="stylesheet">
<link href="{{asset('css/style1.css')}}" rel="stylesheet">
<link href="{{asset('css/responsive.css')}}" rel="stylesheet">
<link href="{{asset('css/_courses.css')}}" rel="stylesheet">
<link href="{{asset('css/swiper.css')}}" rel="stylesheet">
</head>

<body >
<!--================Header Menu Area =================-->
@include('partitions.site.navbar')
<!--================Header Menu Area =================-->

@yield('content')

<!--================ start footer Area  =================-->
@include('partitions.site.footer')

</body>
<!-- /#wrapper -->



<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('js/stellar.js')}}"></script>
<script src="{{ asset('js/theme.js')}}"></script>
<script src="{{ asset('js/popper.js')}}"></script>
<script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>

