@extends('layouts.customer')

@section('css')
{{--    <link rel="stylesheet" href="{{asset('css/login.css')}}">--}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/design-app.css')}}">
    <style>
        .text-danger
        {
            color: #F5365C;
        }
        h4.incorrect
        {
            color: #F5365C;
            text-align: center;
            margin-bottom: 23px
        }



        .background-main {
            @if(isset($settings->background) && $settings->background!="")
            background-image: url('{{asset('logos/'.$settings->background)}}') !important;
            @else
background-image: url('{{asset('images/dashbord.svg')}}') !important ;
            @endif
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 450px;
        }

        .form-control{

            padding: 1.375rem 0.75rem !important;
        }

        .button:after, .shopify-challenge__button:after, .customer button:after, .shopify-payment-button__button--unbranded:after {

            position: unset !important;
        }
        .position-relative{

            margin-top: 13%;
        }
    </style>
@endsection

@section('content')

{{--    <div class="container">--}}

{{--        <div class="header">--}}


{{--            <div id="over" style="position:absolute;left: 50%;transform: translateX(-50%) ">--}}
{{--            <a href="https://{{$domain}}" id="policy" style="text-decoration: none;">--}}
{{--                @if(isset($settings->logo))--}}
{{--                <img class="logo-img" src="{{asset('logos/'.$settings->logo)}}" style="width:135px;height: auto;" alt="logo">--}}

{{--                    <h5 style="color: white">Powered by Rever</h5>--}}
{{--                    @else--}}
{{--                                    <img src="{{asset('logos/Logo REVER.png')}}" style="width:135px;height: auto;" alt="logo">--}}
{{--                    <h5 style="color: white">Powered by Rever</h5>--}}

{{--                @endif--}}
{{--            </a>--}}
{{--        </div>--}}
{{--    </div>--}}

        <div class="background-main">
            <img src="{{asset('images/Vector.png')}}" alt="vector" class="nike-image">
            <div class="welcome-heading">
                <h1 class="heading-main">Welcome to your order <br> return journy</h1>
            </div>
            <div class="welcome-text">
                @if(isset($settings->login_page_text))

                    <p>{{$settings->login_page_text}}</p>
                @else
                <p>Enter your details to begin your return or exchange</p>
                @endif

            </div>
        </div>


{{--        <form role="form" action="https://{{(($domain.'/a/return/customer/login'))}}?shop={{$domain}}" method="get" id="loginform">--}}
{{--            <input type="hidden" name="shop" value="{{$domain}}">--}}
{{--            <div class="main_section_login">--}}
{{--                <div class="login_section">--}}
{{--                    <div class="heading_parent">--}}
{{--                        <h2>Returns & Exchanges</h2>--}}
{{--                    </div>--}}
{{--                    <div class="heading_parent">--}}
{{--                        <div class="field_text">--}}


{{--                            @if(isset($settings->login_page_text))--}}

{{--                                <p>{{$settings->login_page_text}}</p>--}}
{{--                                 @else--}}
{{--                                <p>We offer a hassle-free 30-day exchange/ return policy. To be eligible for an exchange/ a refund, all returned items must be unworn, unwashed, and undamaged with tags still attached. " then in another line "To find your order number, check your order confirmation email or login to your account. Sample order number format: US1001</p>--}}

{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}


{{--                    @if(isset($error))--}}



{{--                        <h4 class="incorrect">{{$error}}</h4>--}}
{{--                    @endif--}}

{{--                    @if(isset($error1))--}}

{{--                        <h4 class="incorrect">{{$error1}}</h4>--}}
{{--                    @endif--}}
{{--                    <div class="field_parent">--}}
{{--                        <input type="text" name="order_name" class="input_field" placeholder="Order Number">--}}
{{--                    </div>--}}
{{--                    <div class="field_parent">--}}
{{--                        <input type="text" name="email" class="input_field" placeholder="Email">--}}
{{--                    </div>--}}
{{--                    <div class="field_parent">--}}
{{--                        <input type="submit" style="cursor: pointer;" class="input_field formsubmit" id="formsubmit" value="START RETURN" placeholder="Order Number">--}}
{{--                    </div>--}}
{{--                    @if(isset($msg))--}}
{{--                        <div class="field_parent msg_class">--}}
{{--                            <p class="text-danger">{{$msg}}</p>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    <div class="field_policy">--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}

<div class="dashboard-form"></div>
<div class="form mx-auto">
    <form role="form" action="https://{{(($domain.'/a/return/customer/login'))}}?shop={{$domain}}" method="get" id="loginform">
                <input type="hidden" name="shop" value="{{$domain}}">

                            @if(isset($error))



                                <h4 class="incorrect">{{$error}}</h4>
                            @endif

                            @if(isset($error1))

                                <h4 class="incorrect">{{$error1}}</h4>
                            @endif
        <div class="input-order-number">
            <div class="mb-3 position-relative">
                <input type="text" name="order_name" class="form-control" placeholder="Order Number" id="inputOrder" style="font-size: 13px">
                <div class="position-absolute lable">Order Number</div>
            </div>
        </div>
        <div class="input-email">
            <div class=" position-relative">
                <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" style="font-size: 13px">
                <div class="position-absolute email">E-mail</div>
            </div>
        </div>
        <div class="my-3 icon text-center">
            <a href="#">
                @if(isset($settings->logo))
                    <img src="{{asset('logos/'.$settings->logo)}}" style="width: 100px;height: auto" alt="">Powered by Rever</a>

                    @else
                <img src="{{asset('images/erro.png')}}" alt="">Powered by Rever</a>

            @endif
        </div>
        <!-- <button type="submit" class="btn rounded-pill"><strong>Get Started</strong></button> -->
        <button type="submit"  value="START RETURN" class="button"><strong>Get Started</strong></button>
    </form>
    <a href="#" style="font-size: 14px" class="hover">By continuing, you agree to the Terms and Privacy Policy</a>
</div>



{{--    </div>--}}

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"></script>
    <script>
    $(document).ready(function(){

        if($('.msg_class').length)
        {
            setTimeout(function(){
                $('.msg_class').remove();
            },3000);
        }
        var url = window.location.href;
        if(url.match('#policy').length>0)
        {
            $('.policy_section').slideDown(500);
        }
        $('#policy').on('click',function(){
            if($('.policy_section').css('display')=='block')
            {
                $('.policy_section').slideUp(500);
            }else
            {
                $('.policy_section').slideDown(500);
            }
        });

    });
    </script>
@endsection
