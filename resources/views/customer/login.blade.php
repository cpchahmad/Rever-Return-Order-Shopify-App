@extends('layouts.customer')

@section('css')
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <style>
        .text-danger
        {
            color: #F5365C;
        }
        h4.incorrect
        {
            color: #F5365C;
            text-align: center;
            margin-bottom: 10px
        }





    </style>
@endsection

@section('content')

    <div class="container">

        <div class="header">


            <div id="over" style="position:absolute;left: 50%;transform: translateX(-50%) ">
            <a href="https://{{$domain}}" id="policy" style="text-decoration: none;">
                @if(isset($settings->logo))
                <img class="logo-img" src="{{asset('logos/'.$settings->logo)}}" style="width:135px;height: auto;" alt="logo">

                    <h5 style="color: white">Powered by Rever</h5>
                    @else
                                    <img src="{{asset('logos/Logo REVER.png')}}" style="width:135px;height: auto;" alt="logo">
                    <h5 style="color: white">Powered by Rever</h5>

                @endif
            </a>
        </div>
    </div>


        <form role="form" action="https://{{(($domain.'/a/return/customer/login'))}}?shop={{$domain}}" method="get" id="loginform">
            <input type="hidden" name="shop" value="{{$domain}}">
            <div class="main_section_login">
                <div class="login_section">
                    <div class="heading_parent">
                        <h2>Returns & Exchanges</h2>
                    </div>
                    <div class="heading_parent">
                        <div class="field_text">


                            @if(isset($settings->login_page_text))

                                <p>{{$settings->login_page_text}}</p>
                       @else
                                <p>We offer a hassle-free 30-day exchange/ return policy. To be eligible for an exchange/ a refund, all returned items must be unworn, unwashed, and undamaged with tags still attached. " then in another line "To find your order number, check your order confirmation email or login to your account. Sample order number format: US1001</p>

                            @endif
                        </div>
                    </div>


                    @if(isset($error))



                        <h4 class="incorrect">{{$error}}</h4>
                    @endif

                    @if(isset($error1))

                        <h4 class="incorrect">{{$error1}}</h4>
                    @endif
                    <div class="field_parent">
                        <input type="text" name="order_name" class="input_field" placeholder="Order Number">
                    </div>
                    <div class="field_parent">
                        <input type="text" name="email" class="input_field" placeholder="Email">
                    </div>
                    <div class="field_parent">
                        <input type="submit" style="cursor: pointer;" class="input_field formsubmit" id="formsubmit" value="START RETURN" placeholder="Order Number">
                    </div>
                    @if(isset($msg))
                        <div class="field_parent msg_class">
                            <p class="text-danger">{{$msg}}</p>
                        </div>
                    @endif
                    <div class="field_policy">

                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('script')
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
