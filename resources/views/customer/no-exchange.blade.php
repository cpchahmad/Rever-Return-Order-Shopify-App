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

        body {
            background: url("{{asset('images/Rectangle.png')}}") !important;
            background-repeat: no-repeat;
        }
        .info__shoping_items_print *
        {
            color: #f5365c;
            text-align: center;
            margin-bottom: 1rem;
            font-weight: 900 !important;
        }
        .py-5
        {
            padding: 3rem 0rem;
        }
        .main__print__section *
        {
            color: red !important;
        }

        body {
            background-image: url('{{asset('logos/'.$settings->background)}}') !important;

        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="header">
            <div id="over" style="position:absolute;left: 50%;transform: translateX(-50%) ">
            <a href="https://{{$shop}}" style="text-decoration: none">
                @if($settings)
                    <img class="logo-img" src="{{asset('logos/'.$settings->logo)}}" style="width:135px;height: auto;" alt="logo">
                    <h5 style="color: white">Powered by Rever</h5>
                @else
                    <img src="{{asset('images/Group 26.svg')}}" alt="logo">

                @endif
            </a>
        </div>
        </div>
        <div class="main_products_all_section">
            <div class="heading_section">

            </div>
            <div class="main__print__section">
                <div class="prin_-two print_section py-5">
                    <div class="info__shoping_items_print">
                        <h3 ><i class="far fa-frown"></i> Return cannot be placed!</h3>
                        <h4>We apologize but an exchange order cannot be returned again.<br/>Email info@tetralogicx.com for questions. Thank you!</h4>
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
