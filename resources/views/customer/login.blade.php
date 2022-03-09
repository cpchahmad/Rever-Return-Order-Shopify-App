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
            <a href="https://us.centricwear.com" id="policy">
                <img src="{{asset('images/Group 26.svg')}}" alt="logo">
            </a>
        </div>
        <form role="form" action="{{proxy(route('customer.login.post'))}}?shop={{$domain}}" method="get" id="loginform">
            <input type="hidden" name="shop" value="{{$domain}}">
            <div class="main_section_login">
                <div class="login_section">
                    <div class="heading_parent">
                        <h2>Returns & Exchanges</h2>
                    </div>
                    <div class="heading_parent">
                        <div class="field_text">
                            <p>We offer a hassle-free 30-day exchange/ return policy. To be eligible for an exchange/ a refund, all returned items must be unworn, unwashed, and undamaged with tags still attached. " then in another line "To find your order number, check your order confirmation email or login to your account. Sample order number format: US1001</p>
                        </div>
                    </div>
                    @if(isset($error))
                        <h4 class="incorrect">Incorrect Order Number or Email</h4>
                    @endif
                    <div class="field_parent">
                        <input type="text" name="order_name" class="input_field" placeholder="Order Number">
                    </div>
                    <div class="field_parent">
                        <input type="text" name="email" class="input_field" placeholder="Email">
                    </div>
                    <div class="field_parent">
                        <input type="submit" class="input_field" value="START RETURN" placeholder="Order Number">
                    </div>
                    @if(isset($msg))
                        <div class="field_parent msg_class">
                            <p class="text-danger">{{$msg}}</p>
                        </div>
                    @endif
                    <div class="field_policy">
                        <a href="https://us.centricwear.com/pages/return-policy">View Policy</a>
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
