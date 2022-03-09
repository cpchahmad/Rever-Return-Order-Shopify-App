@extends('layouts.admin')
@section('content')
    <style>
        .input-group
        {
            -webkit-tap-highlight-color: transparent;
            color: #484848;
            font-family: Montserrat,"Open Sans","Helvetica Neue",Arial,Helvetica,Verdana,sans-serif!important;
            -webkit-font-smoothing: antialiased;
            box-sizing: border-box;
            position: relative;
            display: table;
            border-collapse: separate;
        }
        .input-group >input
        {
            -webkit-tap-highlight-color: transparent;
            -webkit-font-smoothing: antialiased;
            border-collapse: separate;
            box-sizing: border-box;
            font: inherit;
            margin: 0;
            font-family: inherit;
            background-color: #fff;
            line-height: 1.42857143;
            color: #555;
            height: calc(2.50rem + 2px);
            padding: 6px 12px;
            background-image: none;
            border: 1px solid #ccc;
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
            box-shadow: none!important;
            border-radius: 3px;
            font-size: 11px;
            position: relative;
            z-index: 2;
            float: left;
            width: 100%;
            margin-bottom: 0;
            display: table-cell;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .input-group >span
        {
            -webkit-tap-highlight-color: transparent;
            font-family: Montserrat,"Open Sans","Helvetica Neue",Arial,Helvetica,Verdana,sans-serif!important;
            -webkit-font-smoothing: antialiased;
            border-collapse: separate;
            box-sizing: border-box;
            padding: 6px 12px;
            font-weight: 400;
            text-align: center;
            display: table-cell;
            width: 1%;
            white-space: nowrap;
            vertical-align: middle;
            font-size: 14px;
            line-height: 1;
            color: #555;
            background-color: #eee;
            border: 1px solid #ccc;
            border-radius: 4px;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-left: 0;
        }
    </style>
    @include('inc.settings-nav')
    <div class="main-content" id="panel">
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('settings.home')}}">Settings</a></li>
                                    <li class="breadcrumb-item active text-white" >General - Request Policy</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt--6">
            <div class="row card-wrapper">
                <div class="col-lg-12">
                    <!-- Pricing -->
                    <div class="card card-pricing border-0 text-center mb-4">
                        <div class="card-body text-left">
                            <div class="reasons_list">
                                <p class="card-text mb-2 text-left">
                                    Please specify your policy rules.
                                </p>
                            </div>

                            <form action="{{route('request.policy.update')}}" method="POST">
                                {{csrf_field()}}

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h4>Return Policy Notice.</h4>
                                        <input type="text" class="form-control" name="return_able_text"
                                               @if($r_settings!==null && $r_settings->return_able_text)  value="{{$r_settings->return_able_text}}"@endif
                                        />
                                    </div>
                                    <div class="form-group">
                                        <h4>Order Returnable Within.</h4>
{{--                                        <select class="form-control w-25" name="valid_return_date">--}}
                                        <div class="input-group w-25">

                                            <input type="number" min="1" @if($r_settings!==null && $r_settings->valid_return_date) value="{{$r_settings->valid_return_date}}" @endif class="" name="valid_return_date">
{{--                                        </select>--}}
                                            <span>Days</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h4>Display non returnable products.</h4>
                                        <label class="custom-toggle ">
                                            <input name="noreturn_enabled" id="noreturn_enabled-enabled" type="checkbox" value="1" @if($r_settings->display_block_product==true) checked="checked" @endif>
                                            <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label  for="block_tags">Add order names to exclude them from policy e.g (US1001):</label>
                                        <input type="text" class="form-control" data-role="tagsinput" id="block_tags" @if($r_settings != null && $r_settings->special_orders != null ) value="{{$r_settings->special_orders}}" @endif name="special_orders" >
                                    </div>
                                    <div class="form-group">
                                        <label  for="exclude_orders">Add order names to exclude them from return process e.g (US1001):</label>
                                        <input type="text" class="form-control" data-role="tagsinput" id="exclude_orders" @if($r_settings != null && $r_settings->exclude_orders != null ) value="{{$r_settings->exclude_orders}}" @endif name="exclude_orders" >
                                    </div>
                                    <div class="form-group">
                                        <label  for="exchange_orders">Add exchanged order names to add them in return process e.g (US1001):</label>
                                        <input type="text" class="form-control" data-role="tagsinput" id="exchange_orders" @if($r_settings != null && $r_settings->exchange_orders != null ) value="{{$r_settings->exchange_orders}}" @endif name="exchange_orders" >
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-sm" type="submit">Save</button>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
