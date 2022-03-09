<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Return Solution</title>
    <link rel="canonical" href="https://www.creative-tim.com/product/argon-dashboard-pro" />



    {{--    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">--}}

    <link rel="stylesheet" href="{{asset('argon/vendor/nucleo/css/nucleo.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('argon/vendor/%40fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('argon/vendor/quill/dist/quill.core.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('argon/css/argon.mine209.css?v=1.0.0')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('argon/css/colorpicker.css')}}" type="text/css">
    {{--    <link rel="stylesheet" href="https://unpkg.com/@shopify/polaris@4.13.1/styles.min.css"/>--}}

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
{{--    <link rel="stylesheet" href="{{asset('css/tagsinput/bootstrap-tagsinput.css')}}"/>--}}


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
        .display_none
        {
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
            box-shadow: 0 3px 9px rgba(50,50,9,0), 3px 4px 8px rgba(94,114,228,.1);
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
        .imgtext{
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
    <script>
        $( document ).ready(function() {
            $('.tabs_nav li').click(function(){
                $(this).addClass('active');
                $(this).siblings().removeClass('active');
                $('.tab_content').hide();
                $('#'+$(this).attr('data-tab')).show();
            });


            $('.clickable').click(function () {
                $('.clickable').css('border','0');
                $(this).css('border','1px solid');
                $('#theme').val($(this).prop('name'));
            });

            $('.color').ColorPicker({
                onSubmit: function(hsb, hex, rgb, el) {
                    $(el).val('#'+hex);
                    $(el).ColorPickerHide();
                },
                onBeforeShow: function () {
                    $(this).ColorPickerSetColor(this.value);
                }
            })
                .bind('keyup', function(){
                    $(this).ColorPickerSetColor(this.value);
                });



        });
    </script>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light" style="padding: 5px;background: #F6F6F7;">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('home')}}">Dashboard <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('settings.home')}}">Setting</a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="{{route('analytics')}}">Analytics</a>
            </li>


        </ul>

    </div>
</nav>


@yield('content')


<script src="{{asset('argon/vendor/js-cookie/js.cookie.js')}}"></script>
<script src="{{asset('argon/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
<script src="{{asset('argon/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
<script src="{{asset('argon/vendor/lavalamp/js/jquery.lavalamp.min.js')}}"></script>
<script src="{{asset('argon/vendor/chart.js/dist/Chart.min.js')}}"></script>
<script src="{{asset('argon/vendor/chart.js/dist/Chart.extension.js')}}"></script>
<script src="{{asset('argon/vendor/quill/dist/quill.min.js')}}"></script>
<script src="{{asset('argon/js/argon.mine209.js?v=1.0.0')}}"></script>
<script src="{{asset('argon/js/demo.min.js')}}"></script>
<script>
    $('#flash-overlay-modal').modal();

</script>
{{--<script src="{{asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>--}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.17.0/ui/trumbowyg.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.17.0/trumbowyg.min.js"></script>

{{--<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>--}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{asset('argon/js/colorpicker.js')}}"></script>
<script src="{{asset('js/custom-script.js')}}"></script>

<script>

    $(document).ready(function(){

        setTimeout(function(){
            $('.flash-notify').addClass('display_none');
        },3000);

        var ctx = document.getElementById('myChart').getContext('2d');
        var lables=$('#myChart').attr("data-label");
        var lables_data=$('#myChart').attr("data-value");
        var border_color=$('#myChart').attr("data-border");
        var bg_color=$('#myChart').attr("data-bg");

        lables=lables.split(",");
        lables_data=lables_data.split(",");
        border_color=border_color.split("-");
        bg_color=bg_color.split("-");


        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels:lables,
                datasets: [{
                    label: '# of Votes',
                    data: lables_data,
                    backgroundColor:bg_color,
                    borderColor: border_color,
                    borderWidth: 3
                }]
            },
            options: {

            }
        });



        var ctx = document.getElementById('myChart2').getContext('2d');
        var lables=$('#myChart2').attr("data-label");

        var lables_data=$('#myChart2').attr("data-value");
        var border_color=$('#myChart2').attr("data-border");
        var bg_color=$('#myChart2').attr("data-bg");

        lables=lables.split(",");


        lables_data=lables_data.split(",");
        border_color=border_color.split("-");
        bg_color=bg_color.split("-");


        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels:lables,
                datasets: [{
                    label: '# of Votes',
                    data: lables_data,
                    backgroundColor:bg_color,
                    borderColor: border_color,
                    borderWidth: 3
                }]
            },
            options: {

            }
        });

        var ctx = document.getElementById('myChart3').getContext('2d');
        var lables=$('#myChart3').attr("data-label");

        var lables_data=$('#myChart3').attr("data-value");
        var border_color=$('#myChart3').attr("data-border");
        var bg_color=$('#myChart3').attr("data-bg");

        lables=lables.split(",");
        lables_data=lables_data.split(",");

        border_color=border_color.split("-");
        bg_color=bg_color.split("-");


        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels:lables,
                datasets: [{
                    label: '# of Votes',
                    data: lables_data,
                    backgroundColor:bg_color,
                    borderColor: border_color,
                    borderWidth: 3
                }]
            },
            options: {

            }
        });


    });

    $('.edit-comment').click(function (e) {
        e.preventDefault();
        var id= $(this).prop('id');
        $('#comment_id').val(id);
        $('#comment_section').val($('.com_'+id).html());
        $('.com_'+id).html("");

    });

    $('#search_request').on('change',function () {
        var value= $(this).val();
        var shop=$(this).attr('data-shop');
        var data={};
        data.id=value;
        data.shop=shop;
        data.statics=$('.statics').attr('status');
        data.criteria=$('#criteria').val();
        // if(value.length >3){
            $.ajax({
                async: false,
                type:"GET",
                url:$(this).attr('href'),
                data:data,
                success:function (result) {
                    $('.sections').html(result);
                    // console.log(result);
                }

            })
        // }


    });

    // nav Item Show


    var title= $(".nav_title").val();
    $(".nav_sub_title").val();

    if( title != ""){

        switch(title){
            case "General":
                $("#navbar-dashboards").addClass('show');
                break;
            case "Portal":
                $("#portal").addClass('show');
                break;
            case "Order":
                $("#order").addClass('show');
                break;
            case "customization":
                $("#customization").addClass('show');
                break;
            case "Method":
                $("#return_method").addClass('show');
                break;
            case "Confirmation":
                $("#confirmation").addClass('show');
                break;
            case "Email":
                $("#navbar-email").addClass('show');
                break;
        }






    }




    // nav Item Show end







    $('.trumbowyg-demo').trumbowyg();


    $(".copy").click(function () {
        $(this).text("Copied");
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($("#clipboard").text()).select();
        // $("#clipboard").addClass("alert alert-success")
        document.execCommand("copy");
        $temp.remove();

    });


    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }


    $('.datespicker').daterangepicker({
        locale: {
            format: 'YYYY/MM/DD'
        }
    });

    $("#date_range").change(function () {
        var value= $(this).val();

        if(value == 0 ){

            $('#range_input').css('display','none');
            $('#range_input_custom').css('display','block');
        }else if( value != -2) {

            $('#range_input').css('display','block');
            $('#range_input_custom').css('display','none');
            $('.filter_type').val('non-custom');
            $('.filter_value').val(value);
            // console.log($('#filter_analytics').prop('action'));
            $('#filter_analytics').submit();

        }

    });

    $('#range_input_custom').change(function () {

        $('.filter_type').val('custom');
        var value=$('#range_input_custom').val();
        $('.filter_value').val(value);
        $('#filter_analytics').submit();


    });


    $('.download_image').click(function () {
        var a = document.createElement('a');
        a.href = $('.downloads').attr('href');
        a.download = "download.png";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    })

</script>
@yield('script')
<script src="https://unpkg.com/@shopify/app-bridge@1"></script>
<script type="text/javascript">
    var AppBridge = window['app-bridge'];
    var actions = AppBridge.actions;
    var TitleBar = actions.TitleBar;
    var Button = actions.Button;
    var Redirect = actions.Redirect;
    var titleBarOptions = {
        title: 'Welcome',
    };
    var myTitleBar = TitleBar.create(app, titleBarOptions);
</script>
</body>
</html>
