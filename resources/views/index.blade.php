@extends('layouts.admin')

@section('content')
    {{--        @include('inc.settings-nav')--}}
    <div class="main-content" id="panel">
        <nav class="navbar navbar-default bg-primary" id="top_nav_fixed">
            <div class="navbar-header">
                <div class="decline-item pt-2">
                    <a href="{{route('decline.request')}}">
                        <i class="fa fa-trash text-dark display-4 mt-3" aria-hidden="true"></i>
                    </a>

                </div>
                <div class="main-menu-overall">
                    <ul class="nav navbar-top-links statics" status="{{$current_status}}">
                        <li @if($current_status == 0) class="active" @endif><a class="profile-pic"
                                                                               href="{{route('home')}}?type=requested"> <b
                                    class="hidden-xs">Requested</b></a></li>
                        <li @if($current_status == 1) class="active" @endif><a class="profile-pic"
                                                                               href="{{route('home')}}?type=approved"> <b
                                    class="hidden-xs">Approved</b></a></li>
                        <li @if($current_status == 2) class="active" @endif><a class="profile-pic"
                                                                               href="{{route('home')}}?type=received"> <b
                                    class="hidden-xs">Received</b></a></li>
                        <li @if($current_status == 3) class="active" @endif ><a class="profile-pic"
                                                                                href="{{route('home')}}?type=refunded"> <b
                                    class="hidden-xs">Completed</b></a></li>
                        <li @if($current_status == 4) class="active" @endif ><a class="profile-pic"
                                                                                href="{{route('home')}}?type=declined"> <b
                                    class="hidden-xs">Declined</b></a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="card">
                <div class="row mt-3 mb-3 justify-content-center">
                    <div class="col-5">
                        <div class="input-group md-form form-sm form-1 pl-0">
                            <div class="input-group-prepend">
                              <span class="input-group-text purple lighten-3 border-right-0" id="basic-text1">
                                  <i class="fa fa-search text-dark" aria-hidden="true"></i></span>
                            </div>
                            <input class="form-control my-0 py-1 border-left-0" id="search_request" type="text"
                                   placeholder="Search and Scan for orders here." href="{{route('search.request')}}"
                                   data-shop="{{\Illuminate\Support\Facades\Auth::user()->name}}" aria-label="Search">
                        </div>

                    </div>

                </div>

                <div class="sections">
                    @if(count($requests) > 0 )

                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>

                                <th>Order</th>
                                <th>Customer</th>
                                <th>Requested</th>
                                <th>
                                    <div class="dropdown">
                                        <h5 style="font-size: 14px;color: #8898aa;" class="m-0 dropdown-toggle"
                                            type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            Method
                                        </h5>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if(count($methods)>0)
                                                @foreach($methods as $method)
                                                    <a class="dropdown-item"
                                                       href="{{route('filtration').'?method='.$method->id.'&status='.$current_status}}"> {{$method->name}}</a>

                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                </th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Code</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="list">

                            @foreach($requests as $key=>$request)
                                <tr>

                                    <td><a href="/requests/{{$request->id}}">{{$request->has_order->order_name}}</a>
                                    </td>
                                    <td>{{$request->has_order->email}}</td>
                                    <td>{{$request->created_at->format('m/d/Y')}}</td>
                                    <?php $request_products = json_decode($request->product);
                                    $payments = json_decode($request->payment_id);?>
                                    {{--                                    <td>{{$request->return_payment_method}}</td>--}}
                                    <td>@if(count($request->returnMethods()))
                                            @foreach($request->returnMethods() as $method)
                                                <span class="badge badge-sm badge-success">{{$method}}</span><br/>
                                            @endforeach
                                        @endif</td>
                                    <td>@if($request->request_labels && isset($request->request_labels->status))
                                            {{ucwords(str_replace('_',' ',$request->request_labels->status))}} @endif
                                    </td>
                                    <td>
                                        @if(count($request->request_products->where('return_type', 'payment_method'))>0)
                                            @if($request->refunded==true)
                                                <span class="badge badge-success">Payment Refunded</span>
                                            @else
                                                <span class="badge badge-info">Payment Not Refunded</span>
                                            @endif
                                            <br/>
                                        @endif
                                        @if(count($request->request_products->where('return_type', 'store_credit'))>0)
                                            @if($request->store_credited==true)
                                                <span class="badge badge-success">Gift Card Created</span>
                                            @else
                                                <span class="badge badge-info">Gift Card Not Created</span>
                                            @endif
                                        @endif
                                        @if(count($request->request_products->where('return_type', 'exchange'))>0)

                                            @if(isset($request->request_Exchange) && $request->request_Exchange!==null)
                                                
                                                <span class="d-block badge badge-success">Exchange Order Created</span>
                                            @else
                                                <span class="d-block badge badge-info">Exchange Not Created</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>@if($request->request_labels)<a target="_blank"
                                                                        href="https://www.google.com/search?q={{$request->request_labels->tracking_code}}">Status</a> @endif
                                    </td>
                                    <td>
                                        <a href="/requests/{{$request->id}}">Open</a>
                                        @if($request->status==3 && $r_settings->finish_status==false)
                                            <a class="ml-1 text-danger" href="{{route('request.delete',$request->id)}}">Delete</a>
                                        @endif
                                        @if($request->status==4 && $r_settings->decline_status==false)
                                            <a class="ml-1 text-danger" href="{{route('request.delete',$request->id)}}">Delete</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="text-right float-right">
                            {{$requests->links()}}
                        </div>
                    @else
                        <div class="card-body text-center pb-6 pt-6 pl-4 pr-4">
                            <i class="fa fa-sign-language" style="font-size: 60px;"></i>
                            <p class="mt-2">Great job, there are no return requsest at the moment.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>


    <style>
        nav#top_nav_fixed {
            padding: 0;
            text-align: center;
        }

        #top_nav_fixed ul.nav {
            display: block;
            text-align: center;
            width: 100%;
        }

        #top_nav_fixed li {
            display: inline-block;
            margin: 0 15px;
        }

        #top_nav_fixed .navbar-header {
            margin: auto;
        }

        #top_nav_fixed li a {
            padding: 15px;
            display: block;
            color: white;
        }

        #top_nav_fixed li.active {
            background: white;
        }

        #top_nav_fixed li.active a {
            color: #5e72e4;
        }

        .card .table td, .card .table th {
            font-size: 14px;
        }
    </style>
@endsection
