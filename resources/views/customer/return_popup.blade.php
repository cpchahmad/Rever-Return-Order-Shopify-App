@extends('layouts.customer')

@section('css')
    <link rel="stylesheet" href="{{asset('css/popup.css')}}">
    {{--    <link rel="stylesheet" href="{{asset('css/refund_page.css')}}">--}}
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

            body {
            background-image: url('{{asset('logos/'.$settings->background)}}') !important;

        }

        @media only screen and (max-width: 906px) and (min-width: 501px){
            .popup_img {

                margin: auto !important;
            }
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



        <div class="header">
            <div id="over" style="position:absolute;left: 50%;transform: translateX(-50%) ">
            <a href="https://{{$shop->name}}" style="text-decoration: none">
                @if($settings)
                    <img class="logo-img" src="{{asset('logos/'.$settings->logo)}}" style="width:135px;height: auto;" alt="logo">
                    <h5 style="color: white">Powered by Rever</h5>
                @else
                    <img src="{{asset('images/Group 26.svg')}}" alt="logo">

                @endif
            </a>
        </div>
        </div>
        <div class="main_section_popup main_section">
            <div class="overlay_section"></div>
            <div class="popUpmain">
                <div class="popupBody">
                    <div class="popup_under">
                        <div class="popup_img">
                            <div class="header_popup">
                                <div class="back">

                                </div>
                                <div class="cross">

                                    <a href="https://{{$shop->name}}/a/return/customer/login?shop={{$shop->name}}&order_name={{$order_name}}&email={{$order->email}}">
                                        <button type="button"><img src="{{asset('images/cross.svg')}}" alt="cross">
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <input type="hidden" id="image_value" value="@if(isset($line_item['image'])){{$line_item['image']}}@endif">
                            <input type="hidden" name="product_id" value="{{$line_item['product_id']}}">

                        </div>

                        <!-- popup first section text -->

                        <div class="popup_text one_popup">
                            <div class="header_popup">
                                <div class="back">

                                </div>
                                <div class="cross">

                                        <a href="https://{{$shop->name}}/a/return/customer/login?shop={{$shop->name}}&order_name={{$order_name}}&email={{$order->email}}">

                                        <button type="button"><img src="{{asset('images/cross.svg')}}" alt="cross">
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="popup_main_body">
                                <div class="heading_main">
                                    <span class="title">{{$line_item['title']}}</span>
                                </div>
                                <div class="variants_div">
                                    <ul>
                                        @foreach($line_item['options'] as $option)
                                            @if($option!==null)
                                                <li>{{$option}}</li>@endif
                                        @endforeach
                                    </ul>
                                    <span id="variant_total_price">${{$line_item['price']}}</span>
                                </div>
                                <div class="label_checkbox">
                                    @if(in_array('exchange',$allow_methods))
                                        <div class="Labels">
                                            <input type="radio" id="one" name="return_type" value="exchange">
                                            <label for="one" class="mina_oneeee type_check">
                                                <div class="label_under">
                                                    <div class="under_parent">
                                                        <div class="text_underParent">
                                                            <span>Exchange for new color / size</span>
                                                        </div>
                                                        <div class="icons">
                                                            <img src="{{asset('images/arrow_right.svg')}}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endif
                                    @if(in_array('payment_method',$allow_methods) || in_array('store_credit',$allow_methods))
                                        <div class="Labels">
                                            <input type="radio" id="two" name="return_type" value="return">
                                            <label for="one" class="type_check" data-lable="retuen">
                                                <div class="label_under">
                                                    <div class="under_parent">
                                                        <div class="text_underParent">
                                                            <span>Return Item</span>
                                                        </div>
                                                        <div class="icons">
                                                            <img src="{{asset('images/arrow_right.svg')}}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Second PopUp -->
                        <div class="popup_text two_popup">
                            <div class="header_popup">
                                <div class="back">
                                    <button type="button" class="back"><img src="{{asset('images/backArrow.svg')}}"
                                                                            alt=""></button>
                                </div>
                                <div class="cross">

                                        <a href="https://{{$shop->name}}/a/return/customer/login?shop={{$shop->name}}&order_name={{$order_name}}&email={{$order->email}}">

                                        <button type="button"><img src="{{asset('images/cross.svg')}}" alt="cross">
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="popup_main_body">
                                <div class="heading_main">
                                    <span class="title">{{$line_item['title']}}</span>
                                </div>
                                <div class="variants_div">
                                    <ul>
                                        @foreach($line_item['options'] as $option)

                                            @if($option!==null)
                                                <li>{{$option}}</li>@endif
                                        @endforeach
                                    </ul>
                                    <span id="variant_total_price">${{$line_item['price']}}</span>
                                </div>
                            </div>

                            <div class="all_images_main">
                                <div class="sizes_img_main">
                                    <div class="size_parent_bg">
                                        <div class="size_flex p-30">
                                            <div class="size_text">

                                                <span class="custom_span ">{{$product_options[0]->name}}</span>
                                            </div>
                                            <div class="Medium_text">
                                                <span class="custom_span option1"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="main_imae_flex p-30">
                                    @foreach($color_variants as $color_variant)
                                        <div class="img_Size_three">
                                            <div class="image_parentt">
                                                <input class="variant_check opt-1" name="option1" type="radio"
                                                       style="display: none"
                                                       value="{{$color_variant['color']}}">
                                                <img src="{{$color_variant['image']}}" alt=""
                                                     class="add_option1 img_responsive">
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            @if(isset($product_options[1]))
                                <div class="sizes_img_main">
                                    <div class="size_parent_bg">
                                        <div class="size_flex p-30">
                                            <div class="size_text">
                                                <span class="custom_span">{{$product_options[1]->name}}</span>
                                            </div>
                                            <div class="Medium_text">
                                                <span class="custom_span option2"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="radios_sizes">

                                        @foreach($product_options[1]->values as $value)
                                            <div class="size_flex p-30">
                                                <div class="size_text">
                                                    <input class="variant_check opt-2" type="radio" name="option2"
                                                           value="{{$value}}">
                                                    <label for="S">{{$value}}</label>
                                                </div>
                                                <div class="Medium_text">
                                                    <span></span>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            @endif
                            <div class="button_show_onSelect p-30">
                                <div class="main_continue_btn">
                                    <button type="button"  id="after_btn_checked" disabled>Continue</button>
                                </div>
                            </div>
                        </div>
                        <!-- popup third section text -->
                        <div class="popup_text three_popup">
                            <div class="header_popup">
                                <div class="back">
                                    <button type="button" class="back"><img src="{{asset('images/backArrow.svg')}}"
                                                                            alt=""></button>
                                </div>
                                <div class="cross">

                                        <a href="https://{{$shop->name}}/a/return/customer/login?shop={{$shop->name}}&order_name={{$order_name}}&email={{$order->email}}">

                                        <button type="button"><img src="{{asset('images/cross.svg')}}" alt="cross">
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="popup_main_body">
                                <div class="heading_main">
                                    <span class="title">Why are you exchanging?</span>
                                </div>
                                <div class="variants_div">
                                    <ul>
                                        @foreach($line_item['options'] as $option)
                                            @if($option!==null)
                                                <li>{{$option}}</li>@endif
                                        @endforeach
                                    </ul>
                                    <span id="variant_total_price">${{$line_item['price']}}</span>
                                </div>
                                <div class="label_checkbox">
                                    @foreach($exchange_reasons as $reason)
                                        <div class="Labels">
                                            <input type="radio" id="one" name="return_reason" value="{{$reason->id}}">
                                            <label for="one" class="mina_onee return_reason_check">
                                                <div class="label_under">
                                                    <div class="under_parent">
                                                        <div class="text_underParent">
                                                            <span>{{$reason->name}}</span>
                                                        </div>
                                                        <div class="icons">
                                                            <img src="{{asset('images/arrow_right.svg')}}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- popup four section text -->
                        <div class="popup_text four_popup">
                            <div class="header_popup">
                                <div class="back">

                                </div>
                                <div class="cross">

                                    <a href="https://{{$shop->name}}/a/return/customer/login?shop={{$shop->name}}&order_name={{$order_name}}&email={{$order->email}}">

                                    <button type="button"><img src="{{asset('images/cross.svg')}}" alt="cross">

                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="popup_main_body">
                                <div class="heading_main">
                                    <span class="title">Why are you returning?</span>
                                </div>
                                <div class="variants_div">
                                    <ul>
                                        @foreach($line_item['options'] as $option)
                                            @if($option!==null)
                                                <li>{{$option}}</li>@endif
                                        @endforeach
                                    </ul>
                                    <span id="variant_total_price">${{$line_item['price']}}</span>
                                </div>

                                <div class="label_checkbox">
                                    @foreach($refund_reasons as $reason)
                                        <div class="Labels">
                                            <input type="radio" id="one" name="return_reason" value="{{$reason->id}}">
                                            <label for="one" class="mina_onee return_reason_check_return">
                                                <div class="label_under">
                                                    <div class="under_parent">
                                                        <div class="text_underParent">
                                                            <span>{{$reason->name}}</span>
                                                        </div>
                                                        <div class="icons">
                                                            <img src="{{asset('images/arrow_right.svg')}}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="refund_section"></div>
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


            $('.return_reason_check_return').on('click', function (event) {
                $(this).prev('input').attr('checked', true);
                $.ajax({
                    method: "GET",
                    url: "{{(route('add_refund_method'))}}?amount={{$line_item['price']}}",
                    data:{
                        allow_methods:allowed_methods
                    },
                    success: function (response) {
                        $('.main_section').addClass('display_none');
                        $('.refund_section').html(response);
                    }
                });


            })
            $('input[name=option2]').on('change', function () {
                $('.opt-2').removeAttr('checked');
                $(this).attr('checked', 'checked');
                $('.option2').html($(this).val());
                check_exchange_option();

            });

            $('.return_reason_check').on('click', function (event) {
                if ($(this).prev('input').attr('checked', true))
                    $('#selection_form').submit();
            });
            $('.image_parentt').on('click', function (event) {
                $('.opt-1').removeAttr('checked');
                $('.image_parentt').removeClass('Custom_border');
                $(this).addClass('Custom_border');
                $('.popup_img').css('background', 'url(' + $(this).children('img').attr('src') + ')');
                $(this).children('input').attr('checked', 'checked');
                $('.option1').html($(this).children('input').val());
                check_exchange_option();
            });
            $('button .back').on('click', function () {
                $('.popup_img').css('background', 'url(' + $('#image_value').val() + ')');
            });


        });
        // $('.variant_check').on('input',function(){
        //     check_exchange_option();
        // });

        function check_exchange_option() {
            $('#after_btn_checked').attr('disabled', true);

            $('#after_btn_checked').html('<i class="fa fa-spinner fa-spin" style="font-family: FontAwesome !important;"></i>');
            // console.log($('input[name=option2]').val(),$('input[name=option1]').val())
            if ($('input[name=option2]').val() && $('input[name=option1]').val()) {
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
                        'product_id': "{{$line_item['product_id']}}",
                        'quantity': "{{$line_item['quantity']}}"
                    },
                    success: function (response) {
                        // console.log(response);
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
        }
    </script>
@endsection
