<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="prueba Banca">
    <meta name="author" content="johanm mauricio carrillo dev ">

    <title>Banca - @yield('title') </title>

    <!-- Bootstrap core CSS -->

    <link href="{!! asset('css/bootstrap.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! asset('css/style.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! asset('css/animate.css') !!}" rel="stylesheet" type="text/css" />
    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">


</head>
<body class="gray-bg">

<!-- Main view  -->
@yield('content')

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"type="text/javascript"></script>
<script src="{!! asset('js/jquery-2.1.1.js') !!}" type="text/javascript"></script>
<!-- Input Mask-->
<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>

@section('scripts')

@show

</body>
</html>
