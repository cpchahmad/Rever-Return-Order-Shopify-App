<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>Ample Admin Template - The Ultimate Multipurpose admin template</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
{{--    <link href="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css')}}" rel="stylesheet">--}}
{{--    <link href="{{ asset('plugins/bower_components/toast-master/css/jquery.toast.css')}}" rel="stylesheet">--}}
{{--    <link href="{{ asset('plugins/bower_components/morrisjs/morris.css')}}" rel="stylesheet">--}}

{{--    <link href="{{ asset('plugins/bower_components/chartist-js/dist/chartist.min.css"')}}" rel="stylesheet">--}}
{{--    <link href="{{ asset('plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css')}}" rel="stylesheet">--}}

{{--    <link href="{{ asset('css/animate.css')}}" rel="stylesheet">--}}
{{--    <link href="{{ asset('css/style.css')}}" rel="stylesheet">--}}
    <link href="{{ asset('css/custom.css')}}" rel="stylesheet">
{{--    <link href="{{ asset('css/colors/default.css')}}" rel="stylesheet">--}}

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="fix-header">
{{--<div class="preloader">--}}
{{--    <svg class="circular" viewBox="25 25 50 50">--}}
{{--        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />--}}
{{--    </svg>--}}
{{--</div>--}}

@yield('content')

<script type="text/javascript" src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
{{--<script type="text/javascript" src="{{ asset('/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ asset('js/jquery.slimscroll.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ asset('js/waves.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ asset('plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ asset('plugins/bower_components/chartist-js/dist/chartist.min.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ asset('plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ asset('plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js') }}"></script>--}}

<script type="text/javascript" src="{{ asset('js/custom.min.js') }}"></script>

{{--<script type="text/javascript" src="{{ asset('js/dashboard1.js') }}"></script>--}}

{{--<script type="text/javascript" src="{{ asset('plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>--}}

</body>

</html>
