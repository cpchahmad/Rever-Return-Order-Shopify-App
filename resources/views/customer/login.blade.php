@extends('layouts.customer')

@section('css')
{{--    <link rel="stylesheet" href="{{asset('css/login.css')}}">--}}

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
{{--            @if(isset($settings->background) && $settings->background!="")--}}
{{--            background-image: url('{{asset('logos/'.$settings->background)}}') !important;--}}
{{--            @else--}}
{{--background-image: url('{{asset('images/dashbord.svg')}}') !important ;--}}
{{--            @endif--}}
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 450px;
        }

        .form-control{

            /*padding: 1.375rem 0.75rem !important;*/
            padding: 1rem 0.75rem !important;
        }


        .row{
            display: block !important;
        }

        .button:after, .shopify-challenge__button:after, .customer button:after, .shopify-payment-button__button--unbranded:after {

            position: unset !important;
        }
        .position-relative{

            margin-top: 13%;
        }
        .login_background{
            width: 100%;
            border-radius:unset ;
            padding: unset;
            max-height: 455px;

        }
        img.nike-image {
        margin-top: -530px;
            height: auto;
        }

        .welcome-heading{

            margin-top: -250px;
        }
        .welcome-text P {
            margin: -10px 0px 61px 64px;
        }

        @media only screen and (max-width: 450px) and (min-width: 320px)  {
            .background-main {

                height: unset;
            }
            .main_div{
                height: 200px;
            }
            .login_background {
                width: 104%;
                height: 100%;
            }

            img.nike-image {
                margin-top: -324px;
                width: 70.97px;
                margin-left: 30px;
            }
            .welcome-heading {
                margin-top: -180px;
            }
            .heading-main{
                font-size: 16px !important;
                padding: 24px 0px 24px 35px !important;
                line-height: 26px;
            }

            .welcome-text{
                padding-top: 0px;
            }
            .welcome-text P {
                margin: -22px 0px 61px 32px;
            font-size: 12px;
            }

        }


        @media only screen and (max-width: 768px) and (min-width: 500px)  {
            .background-main{

                height: 270px !important;
            }
            .welcome-heading{
                margin-top: -215px !important;
            }

            img.nike-image {

                margin-top: -460px !important;
            }

        }

    </style>
@endsection

@section('content')


        <div class="background-main">
            <div class="main_div">
                @if(isset($settings->background) && $settings->background!="")
            <img src="{{asset('logos/'.$settings->background)}}" alt="vector" class="login_background">

                    @else
                    <img src="{{asset('images/dashbord.svg')}}" alt="vector" class="login_background">
                @endif
            </div>
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
        <div class="input-order-number row">
            <div class="mb-3 position-relative offset-md-0 col-10 offset-1 col-md-12">
                <input type="text" name="order_name" class="form-control" placeholder="Order Number" id="inputOrder" style="font-size: 13px">
                <div class="position-absolute lable">Order Number</div>
            </div>
        </div>
        <div class="input-email row">
            <div class=" position-relative offset-md-0 col-10 offset-1 col-md-12">
                <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" style="font-size: 13px">
                <div class="position-absolute email">E-mail</div>
            </div>
        </div>

        <!-- <button type="submit" class="btn rounded-pill"><strong>Get Started</strong></button> -->
        <div class="my-3 row">
            <div class="col-1"></div>
            <div class="col-md-12 offset-md-0 offset-1 col-10">
        <button type="submit"  value="START RETURN" class="button"><strong>Get Started</strong></button>
        </div>

        </div>
    </form>
    <div class="row">
        <div class="col-md-12 offset-md-0 offset-1 col-11">
    <a href="#" style="font-size: 14px" class="hover">By continuing, you agree to the Terms and Privacy Policy</a>
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
</div>



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
