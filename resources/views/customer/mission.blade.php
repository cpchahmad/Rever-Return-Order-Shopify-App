@extends('layouts.customer')

@section('css')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/design-app.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css"/>


    <style>
        .refund-btn, .exchange-btn, .refund-instead-btn, .continue-btn {

            padding-top: 10px;
        }

        .btn:hover {

            background-color: rgb(36 53 88);
            color: white;
        }
    </style>

@endsection


@section('content')
    <div class="container-fluid">

        <div class="row mt-4">

            <div class="col-md-4 offset-md-4">
                <h2>Mission Accompolished!</h2>
            </div>
        </div>


        <div class="row mt-3">

            <div class="col-md-2  col-8 offset-2 offset-md-5">

                <img style="width: 100%" src="{{asset('images/Subtract.png')}}">
            </div>
        </div>

        <div class="row">

            <div class="col-md-4 offset-md-4">

                <a href="https://{{$domain}}/a/return/order" style="margin-left: unset"   type="button" class="btn refund-btn"><strong>Close</strong></a>
            </div>


        </div>
    </div>
@endsection
