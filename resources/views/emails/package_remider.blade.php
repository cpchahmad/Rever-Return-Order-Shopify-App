<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Centric Return</title>


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
        .print_btn {
            width: 100% !important;
            text-decoration: none !important;
            margin: 0 auto !important;
            display: block !important;
            padding: 20px !important;
            width: 300px !important;
            border-radius: 31px !important;
            border-width: initial !important;
            border-style: none !important;
            border-color: initial !important;
            background: black !important;
            color: rgb(255, 255, 255) !important;
            cursor: pointer !important;
            font-size: 16px !important;
            outline: none !important;
            font-family: Oakes-Regular !important;
        }

        .print_btn .fa {
            margin: 0px 20px 0px 0px;
            padding: 0px;
            font-family: FontAwesome;
            font-weight: normal;
            font-stretch: normal;
            font-size: inherit;
            color:white !important;
        }
    </style>

</head>

<body>
<?php
$label_link='';
$label_message=$settings->package_reminder_body;
$created_at=\Carbon\Carbon::createFromTimeString($data->request_created_at);
$expire_at=\Carbon\Carbon::today();

$created_at = $created_at->englishMonth . ' ' . $created_at->day . ', ' . $created_at->year;
$expire_at = $expire_at->englishMonth . ' ' . $expire_at->day . ', ' . $expire_at->year;

$label_message=str_replace('#{{created_at}}',$created_at,$label_message);
$label_message=str_replace('#{{expired_at}}',$expire_at,$label_message);


//$label_link = '<a href="https://www.google.com/search?q=' . $label->tracking_code . '">' . $label->tracking_code . '</a>';
if(isset($requests)){
    $label_link = '<a href="https://tracking.sendcloud.sc/forward?carrier=' . $requests->request_labels->carrier . '&code='. $requests->request_labels->tracking_code .'&destination=' . $requests->request_labels->destination .'&lang=en-us&source=' . $easypost->state.'&type=letter&verification=' . $requests->request_labels->zip.'&servicepoint_verification=&created_at=' . Carbon\Carbon::parse($requests->request_labels->created_at)->toDateString().'">' . $label->tracking_code . '</a>';
}
$label_print = '<a type="button" class="print_btn" href="'.$label->label.'">Print Return Label</a>';
$label_message = str_replace("#{{tracking_code}}", $label_link, $label_message);
$label_message = str_replace("#{{print}}", $label_print, $label_message);

?>
<h1 style="text-align: center;font-weight: 600;font-size: 26px;">Order {{$data->order_name}} - Request No#{{$data->request_id}}</h1>
{!! $label_message !!}

<script src="{{asset('argon/vendor/quill/dist/quill.min.js')}}"></script>
<script src="{{asset('argon/js/argon.mine209.js?v=1.0.0')}}"></script>
<script src="{{asset('argon/js/demo.min.js')}}"></script>
<script src="{{asset('argon/js/colorpicker.js')}}"></script>
<script src="{{asset('js/custom-script.js')}}"></script>


</body>
</html>

