@extends('layouts.customer')

@section('css')
    <link rel="stylesheet" href="{{asset('css/print.css')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <style>
        .banner {
            background-image: none !important;
            height: 100%;
        }

        {{--body {--}}
        {{--    background: url("{{asset('images/Rectangle.png')}}") !important;--}}
        {{--    background-repeat: no-repeat;--}}
        {{--}--}}
        .info__shoping_items_print *
        {
            line-height: 30px;
            font-size: 19px;
            color: #f5365c;
            text-align: center;
            margin-bottom: 1rem;
            font-weight: 900 !important;
        }
        .py-5
        {
            padding: 3rem 0rem;
        }
        .info__shoping_items_print a
        {
            color: #0da5c0 !important;
        }

        body {
            background-image: url('{{asset('logos/'.$settings->background)}}') !important;

        }
    </style>
@endsection
@section('content')
    <div class="container">
{{--        <div class="header">--}}
{{--            <a href="https://{{$shop}}">--}}
{{--                @if($settings)--}}
{{--                    <img src="{{asset('logos/'.$settings->logo)}}" style="width: 200px" alt="logo">--}}

{{--                @else--}}
{{--                    <img src="{{asset('images/Group 26.svg')}}" alt="logo">--}}

{{--                @endif--}}
{{--            </a>--}}
{{--        </div>--}}

        <div class="header">
            <div id="over" style="position:absolute; ">
            <a href="https://{{$shop}}" style="text-decoration: none;">
                @if($settings)
                    <img class="logo-img" src="{{asset('logos/'.$settings->logo)}}" style="width:12%;margin: 0 auto;" alt="logo">
                    <h5 style="color: white">Powered by Rever</h5>
                @else
                    <img src="{{asset('images/Group 26.svg')}}" alt="logo">

                @endif
            </a>
        </div>
        </div>
        <div class="main_products_all_section">
            <div class="heading_section">
                <h2>Our return app has been upgraded to a new system!</h2>
            </div>
            <div class="main__print__section">
                <div class="prin_-two print_section py-5">
                    <div class="info__shoping_items_print">
                        <h4>Our records indicate that you initiated return process before 01/07/2021 date on our previous return app.
                            To check status of your return, please click this link and enter your information
                            <br/><a href="https://us.centricwear.com/a/returns">https://us.centricwear.com/a/returns</a>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .timeline_custom_step {
            background: white;
            border: 1px solid #5e72e4;
            width: 25px;
            height: 25px;
        }
        .timeline_custom_step i {
            line-height: 0;
            font-size: 0;
        }
        .timeline.timeline-one-side {
            float: right;
            width: 25%;
        }
        .timeline_custom_step + .timeline-content {
            font-size: 14px;
        }
        .active .timeline_custom_step {
            background: #5e72e4;
        }
        .timeline-content {
            margin-left: 40px;
        }
    </style>
@endsection
