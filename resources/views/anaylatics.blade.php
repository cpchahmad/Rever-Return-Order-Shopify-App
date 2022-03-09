@extends('layouts.admin')


@section('content')
    <style>
        canvas {
            background-color: white;
            height: 300px !important;
            margin: 20px 0px;
        }

        .dropbtn {
            cursor: pointer;
        }
        .display_none
        {
            display: none;
        }
    </style>
    <div class="main-content" id="panel">
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-3">
                    </div>
                    {{--                    <div class="row justify-content-end" >--}}
                    {{--                        <div class="col-xl-3 col-md-3" >--}}
                    {{--                            <div class="card  bg-primary">--}}
                    {{--                                <input class="datespicker form-control pull-right" href="{{route('filter.analytics')}}" shop="{{ShopifyApp::shop()->shopify_domain}}">--}}

                    {{--                            </div>--}}

                    {{--                            <div class="form-group">--}}
                    {{--                                <label for="starting_date">Ending Date</label>--}}
                    {{--                                <input class="datepicker ">--}}
                    {{--                            </div>--}}
                    {{--                            <button class="btn btn-light filter"> Filter</button>--}}

                    {{--                        </div>--}}

                    {{--                    </div>--}}
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">


                                    <div class="row">
                                        <div class="col-2 border-right">
                                            <div class="d-flex justify-content-between">

                                                <i class="fa fa-building" aria-hidden="true"></i>
                                                <h5 class="ml-2"> Your Store glance</h5>
                                            </div>
                                            <div class="d-flex ">

                                                <div class="dropdown mr-1" id="custom-dropdown">
                                                    <a onclick="myFunction()" class="dropbtn">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </a>


                                                    <div id="myDropdown" class="dropdown-content p-2">
                                                        {{--                                                        <input class=" form-control pull-center " id="range_input"--}}
                                                        {{--                                                               value="{{date('Y-m-d')}}"--}}
                                                        {{--                                                               href="{{route('filter.analytics')}}">--}}
                                                        {{--                                                        <input class=" form-control pull-center datespicker"--}}
                                                        {{--                                                               style="display: none" id="range_input_custom"--}}
                                                        {{--                                                               href="{{route('filter.analytics')}}">--}}

                                                        <div class="form-group mt-3">
                                                            <label for="date_range"> Date Range</label>
                                                            <select class="form-control" id="date_range">
                                                                <option value="-2"> Select Range</option>
                                                                {{--                                                                <option value="0">Custom</option>--}}
                                                                <option value="1">Today</option>
                                                                <option value="-1"> Yesterday</option>
                                                                <option value="7">Last 7 Days</option>
                                                                <option value="30">Last 30 Days</option>
                                                                <option value="90">Last 90 Days</option>
                                                                {{--                                                                <option value="m">Last Month</option>--}}
                                                                <option value="y">Last Year</option>

                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                                <form method="get" action="{{route('filter.analytics')}}"
                                                      id="filter_analytics">
                                                    {{--                                                    @csrf--}}
                                                    {{--                                                           value="{{\Illuminate\Support\Facades\Auth::user()->name}}">--}}
                                                    <input type="hidden" name="type" class="filter_type">
                                                    <input type="hidden" name="values" class="filter_value">

                                                </form>

                                                <div class="text-right w-100 float-right">
                                                    @if(!empty($date))
                                                        <h5> {{$date}}</h5>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-2 border-right">
                                            <div class="text-center">
                                                <h4> Request</h4>
                                                <h4>
                                                    {{array_sum($datasets['exchange'])+array_sum($datasets['payment_method'])+array_sum($datasets['store_credit'])}}
                                                </h4>

                                            </div>
                                        </div>
                                        {{--                                        <div class="col-2 border-right">--}}
                                        {{--                                            <div class="text-center">--}}
                                        {{--                                                <h4> Returns Percentage</h4>--}}
                                        {{--                                                <h4>2.2%</h4>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}

                                        <div class="col-2 border-right">
                                            <div class="text-center">
                                                <h4> Value Requested</h4>
                                                <h4>
                                                    {{array_sum($datasets['exchange'])+array_sum($datasets['payment_method'])+array_sum($datasets['store_credit'])}}
                                                </h4>
                                            </div>
                                        </div>

                                        <div class="col-2 border-right">
                                            <div class="text-center">
                                                <h4>Exchange</h4>
                                                <h4>{{array_sum($datasets['exchange'])}}</h4>
                                            </div>
                                        </div>
                                        <div class="col-2 border-right">
                                            <div class="text-center">
                                                <h4>Payment Method</h4>
                                                <h4>{{array_sum($datasets['payment_method'])}}</h4>
                                            </div>
                                        </div>
                                        <div class="col-2 ">
                                            <div class="text-center">
                                                <h4>Store Credit </h4>
                                                <h4>{{array_sum($datasets['store_credit'])}}</h4>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="row text-center">
                                {{--                                <div class="col-md-12">--}}
                                {{--                                    <select id="interval" class="form-control float-right mb-1" name="interval">--}}
                                {{--                                        <option value="today">Today</option>--}}
                                {{--                                        <option value="week">This Week</option>--}}
                                {{--                                        <option value="month">This Month</option>--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}
                                <div class="col-md-6">
                                    <canvas id="exchange" style="width: 100%"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="payment_method" style="width: 100%"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="store_credit" style="width: 100%"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                    <form method="POST" action="{{route('create.export')}}">
                        @csrf
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="card new_export_section display_none">
                                    <div class="card-header">
                                        <h2>New Export</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input class="form-control" type="text" name="name" required >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Send to</label>
                                                    <input class="form-control" type="email" name="send_to" required >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date range</label>
                                                    <select name="date" class="form-control">
                                                        <option value="7">Last 7 days</option>
                                                        <option value="14">Last 14 days</option>
                                                        <option value="30">Last 30 days</option>
                                                        <option value="custom">Custom</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 date_range display_none">
                                                <div class="form-group">
                                                    <label>Start date</label>
                                                    <input type="date" name="start_date" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3 date_range display_none">
                                                <div class="form-group">
                                                    <label>End date</label>
                                                    <input type="date" name="end_date" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h2>Exports
                                            <button class="new_export_button btn btn-primary float-right">Create</button>
                                        </h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Start date</th>
                                                    <th>End date</th>
                                                    <th>Send to</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($exports as $export)
                                                    <tr>
                                                        <td>{{$export->name}}</td>
                                                        <td>{{$export->start_date}}</td>
                                                        <td>{{$export->end_date}}</td>
                                                        <td>{{$export->send_to}}</td>
                                                        <td><a href="{{asset($export->file)}}" class="font-weight-bold">Download</a> </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>




    <style>
        body {
            background: #5e72e4 !important;
        }
    </style>
    {{--    @dd($interval)--}}
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        var exchange = document.getElementById('exchange').getContext('2d');
        var payment = document.getElementById('payment_method').getContext('2d');
        var store = document.getElementById('store_credit').getContext('2d');


            @if(isset($datasets))
        var labels = "{{implode(',',array_keys($datasets['exchange']))}}";
        labels = labels.split(',');

        var exchange_data = "{{implode(',',$datasets['exchange'])}}";
        exchange_data = exchange_data.split(',');

        var payment_data = "{{implode(',',$datasets['payment_method'])}}";
        payment_data = payment_data.split(',');

        var store_data = "{{implode(',',$datasets['store_credit'])}}";
        store_data = store_data.split(',');
        var exchange = new Chart(exchange, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Exchange',
                        backgroundColor: 'rgb(54, 162, 235)',
                        borderColor: 'rgb(54, 162, 235)',
                        data: exchange_data,
                        fill: false,
                        lineTension: 0
                    }
                ]
            },

            // Configuration options go here
            options: {
                responsive: true,
                curve: false,
                lineTension: 0
            }
        });
        var payment = new Chart(payment, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: labels,
                datasets: [

                    {
                        label: 'Payment Method',
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: payment_data,
                        fill: false,
                        lineTension: 0
                    }
                ]
            },

            // Configuration options go here
            options: {
                responsive: true,
                curve: false
            }
        });
        store = new Chart(store, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Store Credit',
                        backgroundColor: 'rgb(255, 205, 86)',
                        borderColor: 'rgb(255, 205, 86)',
                        data: store_data,
                        fill: false,
                        lineTension: 0
                    }
                ]
            },

            // Configuration options go here
            options: {
                responsive: true,
                curve: false
            }
        });
        @endif
        $(document).ready(function(){
            $('select[name=date]').on('change',function(){
                if($(this).val()=='custom')
                {
                    $('.date_range').removeClass('display_none');
                }else
                {
                    $('.date_range').addClass('display_none');
                }
            });
            $('.new_export_button').on('click',function(){
                if($('.new_export_section').hasClass('display_none'))
                {
                    $('.new_export_section').slideDown();
                    $('.new_export_section').removeClass('display_none');
                }else
                {
                    $('.new_export_section').slideUp();
                    $('.new_export_section').addClass('display_none');
                }
            })
        });
    </script>
@endsection
