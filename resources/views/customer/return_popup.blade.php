@extends('layouts.customer')

@section('css')
    <link rel="stylesheet" href="{{asset('css/popup.css')}}">
    <link rel="stylesheet" href="{{asset('css/design-app.css')}}">
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
            width: 50px;
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
            <div style="display: flex">
            <h1 style="display: inline-block">Why are you returning this item?</h1>
            <div class="cross" style="float: right">

                <a href="https://{{$shop->name}}/a/return/customer/login?shop={{$shop->name}}&order_name={{$order_name}}&email={{$order->email}}">

                    <button style="background: none;border: none;" type="button"><img src="{{asset('images/cross.svg')}}" alt="cross">
                    </button>
                </a>
            </div>

                <input type="hidden" id="image_value" value="@if(isset($line_item['image'])){{$line_item['image']}}@endif">
                <input type="hidden" name="product_id" value="{{$line_item['product_id']}}">
            </div>
            <div class="box-1 mx-auto">
                <div class="row">


                    <div class="col-md-2">
                        <div class="img">
                            <img style="width: 100%;margin-left: 15px" src="@if(isset($line_item['image'])){{$line_item['image']}} @endif" alt="">
                        </div>
                    </div>
                    <div class="col-md-10">
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
                <div class=" input form-group mx-auto mt-4 col-md-9 position-relative one_popup ">


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
                <div class=" input form-group mx-auto mt-4 col-md-9 position-relative one_popup ">


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

                <h4>Would you like to change the size or color?</h4>

                @foreach($product_options as $index=>$productOption)

                    @if($productOption->name=='Color')
                        <div class="color">
                            <p>{{$productOption->name}}</p>

                            <div class="d-flex">
                            @foreach($color_variants as $color_variant)
                                <div class="image_parentt" style="width: 100px">
                                <input class=" opt-image" name="option{{$index+1}}" type="radio"
                                       style="display: none"
                                       value="{{$color_variant['color']}}">
                                <img src="{{$color_variant['image']}}" alt=""
                                     class="add_option1 img_responsive">
                                </div>

                            @endforeach

                            </div>

                        </div>
                    @else

                <p style="margin-left:100px">{{$productOption->name}}</p>
                <div class="size gap-4">
                    @foreach($productOption->values as $value)

                        <div class="button_radio">
                            <input type="radio"   value="{{$value}}" id="{{$value}}-{{$index}}"   class="variant_check opt-2" name="option{{$index+1}}" />
                            <label class="btn btn-light" for="{{$value}}-{{$index}}" >{{$value}}</label>
                        </div>
{{--                        <input class="variant_check opt-2" type="radio" name="option{{$index+1}}"--}}
{{--                               value="{{$value}}">--}}
{{--                        <label for="S">{{$value}}</label>--}}
{{--                    <button class="variant_check" value="{{$value}}">{{$value}}</button>--}}
                    @endforeach

                </div>

                    @endif

                @endforeach




                <div class="button_show_onSelect p-30">
                    <div class="main_continue_btn">
                        <button type="button"  id="after_btn_checked" disabled>Continue</button>
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
{{--                    <div class="cross">--}}

{{--                        <a href="https://{{$shop->name}}/a/return/customer/login?shop={{$shop->name}}&order_name={{$order_name}}&email={{$order->email}}">--}}

{{--                            <button type="button"><img src="{{asset('images/cross.svg')}}" alt="cross">--}}
{{--                            </button>--}}
{{--                        </a>--}}
{{--                    </div>--}}
                </div>






                <div class="popup_main_body">
                    <div class="heading_main">

{{--                        @if(isset($settings) && $settings->exchange_text)--}}
{{--                            <span class="title">{{$settings->exchange_text}}</span>--}}
{{--                        @else--}}
{{--                            <span class="title">Why are you exchanging?</span>--}}
{{--                        @endif--}}


                    </div>
{{--                    <div class="variants_div">--}}
{{--                        <ul>--}}
{{--                            @foreach($line_item['options'] as $option)--}}
{{--                                @if($option!==null)--}}
{{--                                    <li>{{$option}}</li>@endif--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                        <span id="variant_total_price">${{$line_item['price']}}</span>--}}
{{--                    </div>--}}

                    <input type="radio" name="return_reason" id="exchange_reason_id" value="" style="display: none">
                    <div class="label_checkbox">
                        @foreach($exchange_reasons as $reason)

                            <div class="row">
                                <div class=" input form-group mx-auto mt-4 col-md-9 position-relative return_reason_check" data-id="{{$reason->id}}">

                                    <input type="text" name="" class="form-control " value="{{$reason->name}}" style="cursor: pointer" readonly >
                                    <div class="icon position-absolute">
                                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.02001 13.6798L5.23001 10.4698L7.20001 8.50976C8.03001 7.67976 8.03001 6.32976 7.20001 5.49976L2.02001 0.319763C1.34001 -0.360238 0.180012 0.129763 0.180011 1.07976L0.180011 6.68976L0.18001 12.9198C0.18001 13.8798 1.34001 14.3598 2.02001 13.6798Z" fill="#24446D"/>
                                        </svg>

                                    </div>
                                </div>
                            </div>

{{--                            <div class="Labels">--}}
{{--                                <input type="radio" id="one" name="return_reason" value="{{$reason->id}}">--}}
{{--                                <label for="one" class="mina_onee return_reason_check">--}}
{{--                                    <div class="label_under">--}}
{{--                                        <div class="under_parent">--}}
{{--                                            <div class="text_underParent">--}}
{{--                                                <span>{{$reason->name}}</span>--}}
{{--                                            </div>--}}
{{--                                            <div class="icons">--}}
{{--                                                <img src="{{asset('images/arrow_right.svg')}}" alt="">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </label>--}}
{{--                            </div>--}}
                        @endforeach
                    </div>
                </div>
            </div>


            <div class="popup_text four_popup">
                <div class="header_popup">
                    <div class="back">
                        <button type="button" class="back"><img src="{{asset('images/backArrow.svg')}}"
                                                                alt=""></button>
                    </div>

                </div>
                <div class="popup_main_body">

                    <input type="radio" id="return_reason_id" style="display: none" name="return_reason" value="">
                        @foreach($refund_reasons as $reason)
                        <div class="row">
                            <div class=" input form-group mx-auto mt-4 col-md-9 position-relative return_reason_check_return" data-id="{{$reason->id}}">

                                <input type="text" name="" class="form-control " value="{{$reason->name}}" style="cursor: pointer" readonly >
                                <div class="icon position-absolute">
                                    <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.02001 13.6798L5.23001 10.4698L7.20001 8.50976C8.03001 7.67976 8.03001 6.32976 7.20001 5.49976L2.02001 0.319763C1.34001 -0.360238 0.180012 0.129763 0.180011 1.07976L0.180011 6.68976L0.18001 12.9198C0.18001 13.8798 1.34001 14.3598 2.02001 13.6798Z" fill="#24446D"/>
                                    </svg>

                                </div>
                            </div>
                        </div>

                        @endforeach


                </div>
            </div>
            <div class="refund_section"></div>
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
                $.ajax({
                    method: "GET",
                    url: "{{(route('add_refund_method'))}}?amount={{$line_item['price']}}",
                    data:{
                        allow_methods:allowed_methods
                    },
                    success: function (response) {
                        // $('.main_section').addClass('display_none');
                        $('.four_popup').css('display','none');
                        $('.two_popup').css('display','none');
                        $('.three_popup').css('display','none');
                        $('.one_popup').css('display','none');
                        $('.refund_section').html(response);
                    }
                });


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
                $('.popup_img').css('background', 'url(' + $(this).children('img').attr('src') + ')');
                $(this).children('input').attr('checked', 'checked');
                $('.option-image').html($(this).children('input').val());
                check_exchange_option();
            });
            $('button .back').on('click', function () {


                $('.popup_img').css('background', 'url(' + $('#image_value').val() + ')');
            });


        });
        // $('.variant_check').on('input',function(){
        //     check_exchange_option();
        // });

        // function check_exchange_option1() {
        //     console.log($('input[name=option3]').val());
        // }

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
                        $('#after_btn_checked').html('Continue');
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
