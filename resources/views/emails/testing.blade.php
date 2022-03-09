<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Return Solution</title>
    <link rel="canonical" href="https://www.creative-tim.com/product/argon-dashboard-pro"/>

    @if($settings!=null && $settings->logo!==null)
        <link rel="icon" href="{{asset('logos/'.$settings->logo)}}" type="image/png">
    @else
        <link rel="icon" href="{{asset('argon/img/brand/favicon.png')}}" type="image/png">
    @endif
    {{--    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">--}}

    <link rel="stylesheet" href="{{asset('argon/vendor/nucleo/css/nucleo.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('argon/vendor/%40fortawesome/fontawesome-free/css/all.min.css')}}"
          type="text/css">
    <link rel="stylesheet" href="{{asset('argon/vendor/quill/dist/quill.core.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('argon/css/argon.mine209.css?v=1.0.0')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('argon/css/colorpicker.css')}}" type="text/css">
    {{--    <link rel="stylesheet" href="https://unpkg.com/@shopify/polaris@4.13.1/styles.min.css"/>--}}

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>


    <script src="{{asset('argon/vendor/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('argon/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>


    <style>
        @media (max-width: 1199.98px) {
            .sidenav.fixed-left + .main-content {
                margin-left: 220px !important;
            }

            .sidenav {
                transform: translateX(0);
            }

            .navbar-vertical.navbar-expand-xs {
                max-width: 220px;
            }
        }

        .display_none {
            display: none;
        }

        .tabs_nav li {
            margin: 0;
            padding: 0;
            list-style: none;
            display: inline-block;
            padding: 5px 30px;
            cursor: pointer;
            border-bottom: 1px solid transparent;
        }

        .tabs_nav {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 30px;
        }

        .tabs_nav li.active {
            border-color: #5e72e4;
            box-shadow: 0 3px 9px rgba(50, 50, 9, 0), 3px 4px 8px rgba(94, 114, 228, .1);
        }

        .tab_content {
            display: none;
        }

        .tab_content p.card-text {
            font-size: 14px;
        }

        #them_desgin {
            display: flex;
            list-style: none;
            margin: 0;
            justify-content: center;
            padding: 0;
            flex-wrap: wrap;
            align-items: center;
        }

        .imgtext {
            padding-left: 25px;
        }

        .colorpicker-ex-block {
            height: 36px;
            border-radius: 3px;
        }

        .colorpicker-ex-block--text-example {
            border: 2px solid #ccc;
            padding: 10px;
        }
    </style>

</head>

<body>
<?php
$body='';
if ($status == 0) {
    $body = $settings->rq_customer_template;
} else if ($status == 1) {
    $body = $settings->ap_approval_template;
} elseif ($status == 2) {
    $body = $settings->rc_received_template;
} elseif ($status == 3) {
    $body = $settings->rf_product_template;
} elseif ($status == 4) {
    $body=$settings->rq_admin_template;
}
$body = str_replace('#{{return.number}}', '#' . '1', $body);
?>
<h1 style="text-align: center;font-weight: 600;font-size: 26px;">Order {{$name}} - Request No#1</h1>

{!! $body !!}
<style>
    body *
    {
        font-family: Oakes-Regular !important;
    }
</style>
<script src="{{asset('argon/vendor/js-cookie/js.cookie.js')}}"></script>
<script src="{{asset('argon/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
<script src="{{asset('argon/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
<script src="{{asset('argon/vendor/lavalamp/js/jquery.lavalamp.min.js')}}"></script>
<script src="{{asset('argon/vendor/chart.js/dist/Chart.min.js')}}"></script>
<script src="{{asset('argon/vendor/chart.js/dist/Chart.extension.js')}}"></script>
<script src="{{asset('argon/vendor/quill/dist/quill.min.js')}}"></script>
<script src="{{asset('argon/js/argon.mine209.js?v=1.0.0')}}"></script>
<script src="{{asset('argon/js/demo.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{asset('argon/js/colorpicker.js')}}"></script>
<script src="{{asset('js/custom-script.js')}}"></script>

</body>
</html>

