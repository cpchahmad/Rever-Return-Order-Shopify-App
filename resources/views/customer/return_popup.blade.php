@extends('layouts.customer')

@section('css')
    <link rel="stylesheet" href="{{asset('css/popup.css')}}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .display_none {
            display: none;
        }

        .popup_img {
            {{--background: url("{{$line_item['image']}}");--}}
            background: url(@if(isset($line_item['image']))"{{$line_item['image']}}" @else "" @endif);
            background-repeat: no-repeat !important;
            background-size: cover !important;
            background-position: center !important;
        }



        @media only screen and (max-width: 906px) and (min-width: 501px){
            .popup_img {

                margin: auto !important;
            }
        }

        .alert {
            padding: 10px;
            background-color: #f44336;
            color: white;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }

        .no_reasons{

            background: lightgrey;
            opacity: 0.5;


        }
        .popup_main_body {

            padding: unset !important;
        }

        .popup_text {

            width: unset !important;
        }

        .header_popup{
            background: unset !important;
        }

        .button_radio {
            float: left;
            margin: 0 5px 0 0;
            width: 85px;
            height: 40px;
            position: relative;
        }

        .button_radio label,
        .button_radio input {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .button_radio input[type="radio"] {
            opacity: 0.011;
            z-index: 100;
        }

        .button_radio input[type="radio"]:checked + label {
            background: #20b8be;
            border-radius: 4px;
        }

        .button_radio label {
            cursor: pointer;
            z-index: 90;
            line-height: 1.8em;
        }
        #heading_popup{
            font-weight: 700;
        }

        .four_popup{

         max-width: unset;

        }

        @media screen and (max-width: 916px) {
            .popup_text > .header_popup {
                display: block ;
            }
        }
        .button_show_onSelect {

            background: white;
        }
        .color{
            margin-top: 20px;
        }

        @media (max-width: 906px){
            .popup_text {

                max-width: unset;
            }
        }


        .plans {

            padding: 1px 82px;

        }

        .plans .plan input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .plans .plan {
            cursor: pointer;
            /*width: 48.5%;*/
            /*width: 50%;*/
        }

        .plans .plan .plan-content {
            /*display: -webkit-box;*/
            /*display: -ms-flexbox;*/
            /*display: flex;*/
            padding: 5px;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            border: 2px solid #e1e2e7;
            border-radius: 10px;
            -webkit-transition: -webkit-box-shadow 0.4s;
            transition: -webkit-box-shadow 0.4s;
            -o-transition: box-shadow 0.4s;
            transition: box-shadow 0.4s;
            transition: box-shadow 0.4s, -webkit-box-shadow 0.4s;
            /*position: relative;*/
        }

        .plans .plan .plan-content img {
            /*margin-right: 30px;*/
            /*height: 72px;*/
        }

        .plans .plan .plan-details span {
            margin-bottom: 10px;
            display: block;
            font-size: 20px;
            line-height: 24px;
            color: #252f42;
        }

        .container .title {
            font-size: 16px;
            font-weight: 500;
            -ms-flex-preferred-size: 100%;
            flex-basis: 100%;
            color: #252f42;
            margin-bottom: 20px;
        }

        .plans .plan .plan-details p {
            color: #646a79;
            font-size: 14px;
            line-height: 18px;
        }

        .plans .plan .plan-content:hover {
            -webkit-box-shadow: 0px 3px 5px 0px #e8e8e8;
            box-shadow: 0px 3px 5px 0px #e8e8e8;
        }

        .plans .plan input[type="radio"]:checked + .plan-content:after {
            /*content: "";*/
            position: absolute;
            height: 8px;
            width: 8px;
            background: #216fe0;
            right: 20px;
            top: 20px;
            border-radius: 100%;
            border: 3px solid #fff;
            -webkit-box-shadow: 0px 0px 0px 2px #0066ff;
            box-shadow: 0px 0px 0px 2px #0066ff;
        }

        .plans .plan input[type="radio"]:checked + .plan-content {
            border: 2px solid #216ee0;
            background: #eaf1fe;
            -webkit-transition: ease-in 0.3s;
            -o-transition: ease-in 0.3s;
            transition: ease-in 0.3s;
        }

        @media screen and (max-width: 991px) {
            .plans {
                margin: 0 40px;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                -webkit-box-align: start;
                -ms-flex-align: start;
                align-items: flex-start;
                padding: 0px 30px;
            }

            .plans .plan {
                /*width: 100%;*/
            }

            .plan.complete-plan {
                margin-top: 20px;
            }

            .plans .plan .plan-content .plan-details {
                width: 70%;
                display: inline-block;
            }

            .plans .plan input[type="radio"]:checked + .plan-content:after {
                top: 45%;
                -webkit-transform: translate(-50%);
                -ms-transform: translate(-50%);
                transform: translate(-50%);
            }
        }

        @media screen and (max-width: 767px) {
            .plans .plan .plan-content .plan-details {
                width: 60%;
                display: inline-block;
            }
        }

        @media screen and (max-width: 540px) {
            .plans .plan .plan-content img {
                /*margin-bottom: 20px;*/
                /*height: 56px;*/
                -webkit-transition: height 0.4s;
                -o-transition: height 0.4s;
                transition: height 0.4s;
            }

            .plans .plan input[type="radio"]:checked + .plan-content:after {
                top: 20px;
                right: 10px;
            }

            .plans .plan .plan-content .plan-details {
                width: 100%;
            }

            .plans .plan .plan-content {
                /*padding: 20px;*/
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                -webkit-box-align: baseline;
                -ms-flex-align: baseline;
                align-items: baseline;
            }
        }

        /* inspiration */
        .inspiration {
            font-size: 12px;
            margin-top: 50px;
            position: absolute;
            bottom: 10px;
            font-weight: 300;
        }

        .inspiration a {
            color: #666;
        }
        @media screen and (max-width: 767px) {
            /* inspiration */
            .inspiration {
                display: none;
            }
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }
        .btn-circle.btn-lg {
            width: 50px;
            height: 50px;
            padding: 13px 13px;
            font-size: 18px;
            line-height: 1.33;
            border-radius: 25px;
        }

        .colored-radio {
            vertical-align: bottom;
            -webkit-appearance:none;
            width:30px;
            height:30px;
            border:1px solid darkgray;
            border-radius:50%;
            outline:none;
            box-shadow:0 0 5px 0px gray inset;
            /*margin-right : 30px;*/
        }

        .Custom_border {
            border: 2px solid black;
            border-radius: 50%;
        }
        .colorflex {
            display: flex!important;
            /* justify-content: space-evenly; */
            flex-wrap: nowrap;
            flex-direction: row;
            column-gap: 20px;
            align-items: center;}

        .colors_get{

            padding:2px;
        }
    </style>
@endsection


@section('content')
    <?php
    $order_name = str_replace('#', '', $order->order_name);
    $merge_array = [];
    ?>


    <form class="container" id="selection_form"

          action="https://{{$shop->name}}/a/return/customer/order/{{$order->id}}/lineItem/{{$line_item['id']}}/selected/submit"
          method="POST">

        @csrf
    <div class="container" style="border: none;">
        <div class="main-card mx-auto pb-5">
            <div class="row">
                <div class="col-md-10 col-10">
            <h1 id="heading_popup">Why are you returning this item?</h1>
                </div>
                <div class="col-2 col-md-2" style="text-align: right">
            <div class="cross">

                <a href="https://{{$shop->name}}/a/return/customer/login?shop={{$shop->name}}&order_name={{$order_name}}&email={{$order->email}}">

                    <button style="background: none;border: none;" type="button"><img src="{{asset('images/cross.svg')}}" alt="cross">
                    </button>
                </a>
            </div>
                </div>

                <input type="hidden" id="image_value" value="@if(isset($line_item['image'])){{$line_item['image']}}@endif">
                <input type="hidden" name="product_id" value="{{$line_item['product_id']}}">
            </div>
            <div class="box-1 mx-auto">
                <div class="row">


                    <div class="col-md-2 col-2">
                        <div class="img">
                            <img style="width: 100%;margin-left: 15px" src="@if(isset($line_item['image'])){{$line_item['image']}} @endif" alt="">
                        </div>
                    </div>
                    <div class="col-md-10 col-10">
                        <h6 class="pt-1">{{$line_item['title']}}</h6>
                        <p class="">${{$line_item['price']}}</p>
                        <div class="radio-buttons d-flex gap-2">
                            <img class="red-button" src="{{asset('images/red.png')}}" alt="">
                            @foreach($line_item['options'] as $option)
                                @if($option!==null)

                            <p class="m">{{$option}}</p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


            <input type="hidden" id="return_type_define" name="return_type" value="">
            @if(in_array('exchange',$allow_methods))


            <div class="row">
                <div class=" input form-group mx-auto mt-4 col-9 col-md-9 position-relative one_popup ">


                    <input type="text" name="" class="form-control mina_oneeee" value="Exchange for new color / size" readonly style="@if($exchange_reason_count==0) pointer-events:none @endif ; cursor:pointer;">
                    <div class="icon position-absolute">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.02001 13.6798L5.23001 10.4698L7.20001 8.50976C8.03001 7.67976 8.03001 6.32976 7.20001 5.49976L2.02001 0.319763C1.34001 -0.360238 0.180012 0.129763 0.180011 1.07976L0.180011 6.68976L0.18001 12.9198C0.18001 13.8798 1.34001 14.3598 2.02001 13.6798Z" fill="#24446D"/>
                        </svg>

                    </div>
                </div>
            </div>
                @endif


            @if(in_array('payment_method',$allow_methods) || in_array('store_credit',$allow_methods))


            <div class="row">
                <div class=" input form-group mx-auto mt-4 col-9 col-md-9 position-relative one_popup ">


                    <input type="text" name="" class="form-control mina_twoooooo" value="Return Item" readonly style="@if($exchange_reason_count==0) pointer-events:none @endif ; cursor:pointer;">
                    <div class="icon position-absolute">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.02001 13.6798L5.23001 10.4698L7.20001 8.50976C8.03001 7.67976 8.03001 6.32976 7.20001 5.49976L2.02001 0.319763C1.34001 -0.360238 0.180012 0.129763 0.180011 1.07976L0.180011 6.68976L0.18001 12.9198C0.18001 13.8798 1.34001 14.3598 2.02001 13.6798Z" fill="#24446D"/>
                        </svg>

                    </div>
                </div>
            </div>

            @endif


        <!-- Second PopUp -->
            <div class="popup_text two_popup">
                <div class="header_popup">
                    <div class="back">
                        <button type="button" class="back"><img src="{{asset('images/backArrow.svg')}}"
                                                                alt=""></button>
                    </div>

                </div>

                <div class="col-md-12">
                <h4>Would you like to change the size or color?</h4>
                </div>
                @foreach($product_options as $index=>$productOption)

                    @if($productOption->name=='Color')
                        <div class="color">
                            <p>{{$productOption->name}}</p>

                            <div class="d-flex gap-4">
                            @foreach($color_variants as $loopindex=>$color_variant)
                                <div class="" >
{{--                                <input class=" opt-image" name="option{{$index+1}}" type="radio"--}}
{{--                                       style="display: none"--}}
{{--                                       value="{{$color_variant['color']}}">--}}
{{--                                <img src="{{$color_variant['image']}}" alt=""--}}
{{--                                     class="add_option1 img_responsive">--}}

{{--                                    <div class="button_radio">--}}
{{--                                        <input type="radio" style="background: {{$color_variant['color']}}"   value="{{$color_variant['color_options']}}" id="color-{{$loopindex}}"   class="add_option1 image_parentt opt-2" name="option{{$index+1}}" />--}}
{{--                                        <label class="btn " style="background: {{$color_variant['color']}}" for="color-{{$loopindex}}" ></label>--}}
{{--                                    </div>--}}



                                    <div id="content" class="image_parentt">
                                        <label for="dark"  class="colors_get" >
                                            <input type="radio" name="option{{$index+1}}" id="dark" class="colored-radio " value="{{$color_variant['color_options']}}"  style="background: {{$color_variant['color']}}">
                                        </label>
                                    </div>

                                </div>

                            @endforeach

                            </div>

                        </div>
                    @else

                <p class="mt-2" style="margin-left:100px">{{$productOption->name}}</p>
                <div class="size gap-4">
                    @foreach($productOption->values as $value)

                        <div class="button_radio">
                            <input type="radio"   value="{{$value}}" id="{{$value}}-{{$index}}"   class="variant_check opt-2" name="option{{$index+1}}" />
                            <label class="btn btn-light" for="{{$value}}-{{$index}}" >{{$value}}</label>
                        </div>

                    @endforeach

                </div>

                    @endif

                @endforeach




                <div class="button_show_onSelect p-30">
                    <div class="main_continue_btn">
                        <button type="button"  style="background: rgb(36 53 88) !important;" id="after_btn_checked" disabled>Confirm Exchange</button>
                    </div>
                </div>
            </div>
            <!-- popup third section text -->
            <div class="popup_text three_popup">
                <div class="header_popup">
                    <div class="back_exchange">
                        <button type="button" class="back_exchange"><img src="{{asset('images/backArrow.svg')}}"
                                                                alt=""></button>
                    </div>

                </div>






                <div class="popup_main_body">
                    <div class="heading_main">

                    </div>


                    <input type="radio" name="return_reason" id="exchange_reason_id" value="" style="display: none">
                    <div class="label_checkbox">

                            <div class="row">
                                @foreach($exchange_reasons as $reason)
                                <div class=" input form-group mx-auto mt-4 col-9 col-md-9 position-relative return_reason_check" data-id="{{$reason->id}}">

                                    <input type="text" name="" class="form-control " value="{{$reason->name}}" style="cursor: pointer" readonly >
                                    <div class="icon position-absolute">
                                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.02001 13.6798L5.23001 10.4698L7.20001 8.50976C8.03001 7.67976 8.03001 6.32976 7.20001 5.49976L2.02001 0.319763C1.34001 -0.360238 0.180012 0.129763 0.180011 1.07976L0.180011 6.68976L0.18001 12.9198C0.18001 13.8798 1.34001 14.3598 2.02001 13.6798Z" fill="#24446D"/>
                                        </svg>

                                    </div>
                                </div>
                                @endforeach
                            </div>


                    </div>
                </div>
            </div>


            <div class="popup_text four_popup">


                <div class="header_popup ">
                    <div class="back ">
                        <button type="button" class="back"><img src="{{asset('images/backArrow.svg')}}"
                                                                alt=""></button>
                    </div>

                </div>

                <div class="popup_main_body">

                    <input type="radio" id="return_reason_id" style="display: none" name="return_reason" value="">

                        <div class="row">
                            @foreach($refund_reasons as $reason)
                            <div class=" input form-group mx-auto mt-4 col-md-9 col-9 position-relative return_reason_check_return" data-id="{{$reason->id}}">

                                <input type="text" name="" class="form-control " value="{{$reason->name}}" style="cursor: pointer" readonly >
                                <div class="icon position-absolute">
                                    <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.02001 13.6798L5.23001 10.4698L7.20001 8.50976C8.03001 7.67976 8.03001 6.32976 7.20001 5.49976L2.02001 0.319763C1.34001 -0.360238 0.180012 0.129763 0.180011 1.07976L0.180011 6.68976L0.18001 12.9198C0.18001 13.8798 1.34001 14.3598 2.02001 13.6798Z" fill="#24446D"/>
                                    </svg>

                                </div>
                            </div>
                            @endforeach
                        </div>




                </div>
            </div>
            <div class="refund_section" style="display: none">


                <div class="option-heading row mt-2">
                    <h3 style="font-weight: 700">Select a refund option</h3>
                </div>

                @if(in_array('payment_method',$allow_methods))

                    <div class="container mt-4">
                        <div class="plans row">

                            <div class="col-md-6 col-12">
                            <label style="display: block" class="plan basic-plan" for="basic">
                                <input  type="radio" name="refund" value="payment_method" disabled id="basic" />
                                <div class="plan-content">

                                    <div class="instant-refund">
                                        <div class="row">
                                            <div class="col-md-10 col-10">
                                            <p><strong>Get an instant refund</strong></p>
                                            </div>
                                            <div class="col-md-2 col-2" style="text-align: right">
                                         <img style="padding: unset" src="{{asset('images/Vector(1).png')}}" alt="">
                                            </div>
                                            </div>
                                        <p><small>Description</small></p>
                                    </div>



                                </div>

                            </label>
                            </div>
                        </div>
                    </div>

                @endif

                <button type="submit" class="continue-btn"><strong>continue</strong></button>



            </div>
        </div>


    </div>


    </form>
@endsection

@section('script')
    <script>
        $(document).on('click', '.click_label', function () {

            if ($(this).prev('input').attr('checked', true))
                $('#selection_form').submit();
        });

        var allowed_methods="{{implode($allow_methods,',')}}";


        $(document).ready(function () {



            $('.type_check').on('click', function (event) {

                $(this).prev('input').attr('checked', true);
            });

            $('.return_reason_check').on('click', function (event) {
                if ($(this).prev('input').attr('checked', true))
                    var id=$(this).data('id');
                $('#exchange_reason_id').val(id);
                $('#exchange_reason_id').prop('checked','true');
                    $('#selection_form').submit();
            });


            $('.return_reason_check_return').on('click', function (event) {

                var id=$(this).data('id');
                $('#return_reason_id').val(id);
                $('#return_reason_id').prop('checked','true');
                $(this).prev('input').attr('checked', true);

                $('.four_popup').css('display','none');
                $('.two_popup').css('display','none');
                $('.three_popup').css('display','none');
                $('.one_popup').css('display','none');
                $('.refund_section').css('display','block');
                $('#basic').removeAttr('disabled');
                $('#basic').attr('checked','true');
                {{--$.ajax({--}}
                {{--    method: "GET",--}}
                {{--    url: "{{(route('add_refund_method'))}}?amount={{$line_item['price']}}",--}}
                {{--    data:{--}}
                {{--        allow_methods:allowed_methods--}}
                {{--    },--}}
                {{--    success: function (response) {--}}
                {{--        // $('.main_section').addClass('display_none');--}}
                {{--        $('.four_popup').css('display','none');--}}
                {{--        $('.two_popup').css('display','none');--}}
                {{--        $('.three_popup').css('display','none');--}}
                {{--        $('.one_popup').css('display','none');--}}
                {{--        $('.refund_section').html(response);--}}
                {{--    }--}}
                {{--});--}}


            })
            //by me
            // $('input[name=option2]').on('change', function () {
            //     $('.opt-2').removeAttr('checked');
            //     $(this).attr('checked', 'checked');
            //     $('.option2').html($(this).val());
            //     check_exchange_option();
            //
            // });
            $('.variant_check').on('change', function () {
                // alert(1);
                // $('.variant_check').removeAttr('checked');
                $(this).parents('.sizes_img_main').find('.variant_check').removeAttr('checked');
                $(this).attr('checked', 'checked');
                $(this).parents('.sizes_img_main').find('.other-option').html($(this).val());
                check_exchange_option();

            });


            $('.image_parentt').on('click', function (event) {


                $('.opt-image').removeAttr('checked');
                $('.image_parentt').removeClass('Custom_border');
                $(this).addClass('Custom_border');
                // $('.colored-radio').css('margin-right','0px');

                $('.popup_img').css('background', 'url(' + $(this).children('img').attr('src') + ')');
                $(this).children('input').attr('checked', 'checked');
                $('.option-image').html($(this).children('input').val());
                check_exchange_option();
            });
            $('button .back').on('click', function () {


                $('.popup_img').css('background', 'url(' + $('#image_value').val() + ')');
            });


        });


        function check_exchange_option() {
            $('#after_btn_checked').attr('disabled', true);

            $('#after_btn_checked').html('<i class="fa fa-spinner fa-spin" style="font-family: FontAwesome !important;"></i>');
            // console.log($('input[name=option2]').val(),$('input[name=option1]').val())

            if($('input[name=option3]').val()){

                if($('input[name=option1]').is(":checked") && $('input[name=option2]').is(":checked") && $('input[name=option3]').is(":checked") ){

                    ajaxFunction();
                    // alert('allchecked');
                }

            }




            else         if($('input[name=option2]').val()) {

                if ($('input[name=option2]').val() && $('input[name=option1]').val()) {

                    // alert($('input[name=option1]:checked').val());
                    if ($('input[name=option1]').is(":checked") && $('input[name=option2]').is(":checked")) {
                        ajaxFunction();
                        // alert('allchecked22');
                    }


                }
            }



            else{

                if($('input[name=option1]').is(":checked")){
                    ajaxFunction();

                }



            }


        }

        function ajaxFunction(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "POST",
                url: "{{(route('check.variant.stock'))}}",
                data: {
                    'option1': $('input[name=option1]:checked').val(),
                    'option2': $('input[name=option2]:checked').val(),
                    'option3': $('input[name=option3]:checked').val(),
                    'product_id': "{{$line_item['product_id']}}",
                    'quantity': "{{$line_item['quantity']}}"
                },
                success: function (response) {
                    console.log(response);
                    if (response.stat == 'found') {
                        $('#after_btn_checked').removeAttr('disabled');
                        $('#after_btn_checked').html('Confirm Exchange');
                        return true;
                    } else if (response.stat == 'out of stock') {
                        $('#after_btn_checked').html('Out of Stock');
                        return false;
                    }
                    //commentted by me
                    // $('#after_btn_checked').html('Continue');
                    $('#after_btn_checked').html('Not Available');
                },
                error:function(response)
                {
                    //commentted by me
                    // $('#after_btn_checked').html('Continue');
                    $('#after_btn_checked').html('Not Available1');

                }
            });
        }
    </script>
@endsection
