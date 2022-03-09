<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Return Solution</title>


    <link rel="stylesheet" href="{{asset('argon/vendor/nucleo/css/nucleo.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('argon/vendor/%40fortawesome/fontawesome-free/css/all.min.css')}}"
          type="text/css">
    <link rel="stylesheet" href="{{asset('argon/vendor/quill/dist/quill.core.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('argon/css/argon.mine209.css?v=1.0.0')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('argon/css/colorpicker.css')}}" type="text/css">


    <script src="{{asset('argon/vendor/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>


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

{!! $settings->export_body !!}

<script src="{{asset('argon/vendor/quill/dist/quill.min.js')}}"></script>
<script src="{{asset('argon/js/argon.mine209.js?v=1.0.0')}}"></script>
<script src="{{asset('argon/js/demo.min.js')}}"></script>
<script src="{{asset('argon/js/colorpicker.js')}}"></script>
<script src="{{asset('js/custom-script.js')}}"></script>

</body>
</html>

