
@extends('layouts.admin')

@section('content')

    <div class="row" style="margin-right: 0px;margin-left: 0px;">
        <div class="col">
            <div class="tabs_wrapper mt-4">
                <div class="tabs_nav" style="text-align: center">
                    <li class="active" data-tab="tab1">Requested</li>
                    <li data-tab="tab2">Approved</li>
                    <li data-tab="tab3">Received</li>
                    <li data-tab="tab4">Completed</li>
                    <li data-tab="tab5">Declined</li>
                </div>

                <div class="tabs_content">
                    <div class="tab_content" id="tab1" style="display: block;">
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
                            <div class="row" style="margin-left: 0px;margin-right: 0px">
                                <div class="col-12" id="append">
                                    @if(count($requests1) > 0 )

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

                                            @foreach($requests1 as $key=>$request)
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
                                                                                        href="https://tracking.sendcloud.sc/forward?carrier={{$request->request_labels->carrier}}&code={{$request->request_labels->tracking_code}}&destination={{$request->request_labels->destination}}&lang=en-us&source={{$easypost->state}}&type=letter&verification={{$request->request_labels->zip}}&servicepoint_verification=&created_at={{Carbon\Carbon::parse($request->request_labels->created_at)->toDateString()}}">Status</a> @endif
                                                    </td>
                                                    <td>
                                                        <a href="/requests/{{$request->id}}">Open</a>
                                                        @if($request->status==3 && $r_settings->finish_status==false)
                                                            <a class="ml-1 text-danger" href="{{route('delete.request',$request->id)}}">Delete</a>
                                                        @endif
                                                        @if($request->status==4 && $r_settings->decline_status==false)
                                                            <a class="ml-1 text-danger" href="{{route('delete.request',$request->id)}}">Delete</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                        <div class="text-right float-right">
                                            {{$requests1->links()}}
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
                    <div class="tab_content" id="tab2">
                        <div class="row mt-3 mb-3 justify-content-center">
                            <div class="col-5">
                                <div class="input-group md-form form-sm form-1 pl-0">
                                    <div class="input-group-prepend">
                              <span class="input-group-text purple lighten-3 border-right-0" id="basic-text1">
                                  <i class="fa fa-search text-dark" aria-hidden="true"></i></span>
                                    </div>
                                    <input class="form-control my-0 py-1 border-left-0" id="search_request1" type="text"
                                           placeholder="Search and Scan for orders here." href="{{route('search.request')}}"
                                           data-shop="{{\Illuminate\Support\Facades\Auth::user()->name}}" aria-label="Search">
                                </div>

                            </div>

                        </div>
                        <div class="sections1">
                            <div class="row" style="margin-left: 0px;margin-right: 0px">
                                <div class="col-12" id="append1">
                                    @if(count($requests2) > 0 )

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

                                            @foreach($requests2 as $key=>$request)
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
                                                                                        href="https://tracking.sendcloud.sc/forward?carrier={{$request->request_labels->carrier}}&code={{$request->request_labels->tracking_code}}&destination={{$request->request_labels->destination}}&lang=en-us&source={{$easypost->state}}&type=letter&verification={{$request->request_labels->zip}}&servicepoint_verification=&created_at={{Carbon\Carbon::parse($request->request_labels->created_at)->toDateString()}}">Status</a> @endif
                                                    </td>
                                                    <td>
                                                        <a href="/requests/{{$request->id}}">Open</a>
                                                        @if($request->status==3 && $r_settings->finish_status==false)
                                                            <a class="ml-1 text-danger" href="{{route('delete.request',$request->id)}}">Delete</a>
                                                        @endif
                                                        @if($request->status==4 && $r_settings->decline_status==false)
                                                            <a class="ml-1 text-danger" href="{{route('delete.request',$request->id)}}">Delete</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                        <div class="text-right float-right">
                                            {{$requests2->links()}}
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
                    <div class="tab_content" id="tab3">
                        <div class="row mt-3 mb-3 justify-content-center">
                            <div class="col-5">
                                <div class="input-group md-form form-sm form-1 pl-0">
                                    <div class="input-group-prepend">
                              <span class="input-group-text purple lighten-3 border-right-0" id="basic-text1">
                                  <i class="fa fa-search text-dark" aria-hidden="true"></i></span>
                                    </div>
                                    <input class="form-control my-0 py-1 border-left-0" id="search_request2" type="text"
                                           placeholder="Search and Scan for orders here." href="{{route('search.request')}}"
                                           data-shop="{{\Illuminate\Support\Facades\Auth::user()->name}}" aria-label="Search">
                                </div>

                            </div>

                        </div>

                        <div class="sections2">
                            <div class="row" style="margin-left: 0px;margin-right: 0px">
                                <div class="col-12" id="append2">
                                    @if(count($requests3) > 0 )

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

                                            @foreach($requests3 as $key=>$request)
                                                <tr>

                                                    <td><a href="/requests/{{$request->id}}">{{$request->has_order->order_name}}</a>
                                                    </td>
                                                    <td>{{$request->has_order->email}}</td>
                                                    <td>{{$request->created_at->format('m/d/Y')}}</td>


                                                    <?php $request_products = json_decode($request->product);
                                                    $payments = json_decode($request->payment_id);?>

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
                                                                                        href="https://tracking.sendcloud.sc/forward?carrier={{$request->request_labels->carrier}}&code={{$request->request_labels->tracking_code}}&destination={{$request->request_labels->destination}}&lang=en-us&source={{$easypost->state}}&type=letter&verification={{$request->request_labels->zip}}&servicepoint_verification=&created_at={{Carbon\Carbon::parse($request->request_labels->created_at)->toDateString()}}">Status</a> @endif
                                                    </td>
                                                    <td>
                                                        <a href="/requests/{{$request->id}}">Open</a>
                                                        @if($request->status==3 && $r_settings->finish_status==false)
                                                            <a class="ml-1 text-danger" href="{{route('delete.request',$request->id)}}">Delete</a>
                                                        @endif
                                                        @if($request->status==4 && $r_settings->decline_status==false)
                                                            <a class="ml-1 text-danger" href="{{route('delete.request',$request->id)}}">Delete</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                        <div class="text-right float-right">
                                            {{$requests3->links()}}
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
                    <div class="tab_content" id="tab4">
                        <div class="row mt-3 mb-3 justify-content-center">
                            <div class="col-5">
                                <div class="input-group md-form form-sm form-1 pl-0">
                                    <div class="input-group-prepend">
                              <span class="input-group-text purple lighten-3 border-right-0" id="basic-text1">
                                  <i class="fa fa-search text-dark" aria-hidden="true"></i></span>
                                    </div>
                                    <input class="form-control my-0 py-1 border-left-0" id="search_request3" type="text"
                                           placeholder="Search and Scan for orders here." href="{{route('search.request')}}"
                                           data-shop="{{\Illuminate\Support\Facades\Auth::user()->name}}" aria-label="Search">
                                </div>

                            </div>

                        </div>

                        <div class="sections3">


                            <div class="row" style="margin-left: 0px;margin-right: 0px">
                                <div class="col-12" id="append3">
                                    @if(count($requests4) > 0 )

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

                                            @foreach($requests4 as $key=>$request)
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
                                                                                        href="https://tracking.sendcloud.sc/forward?carrier={{$request->request_labels->carrier}}&code={{$request->request_labels->tracking_code}}&destination={{$request->request_labels->destination}}&lang=en-us&source={{$easypost->state}}&type=letter&verification={{$request->request_labels->zip}}&servicepoint_verification=&created_at={{Carbon\Carbon::parse($request->request_labels->created_at)->toDateString()}}">Status</a> @endif
                                                    </td>
                                                    <td>
                                                        <a href="/requests/{{$request->id}}">Open</a>
                                                        @if($request->status==3 && $r_settings->finish_status==false)
                                                            <a class="ml-1 text-danger" href="{{route('delete.request',$request->id)}}">Delete</a>
                                                        @endif
                                                        @if($request->status==4 && $r_settings->decline_status==false)
                                                            <a class="ml-1 text-danger" href="{{route('delete.request',$request->id)}}">Delete</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                        <div class="text-right float-right">
                                            {{$requests4->links()}}
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


                    <div class="tab_content" id="tab5">
                        <div class="row mt-3 mb-3 justify-content-center">
                            <div class="col-5">
                                <div class="input-group md-form form-sm form-1 pl-0">
                                    <div class="input-group-prepend">
                              <span class="input-group-text purple lighten-3 border-right-0" id="basic-text1">
                                  <i class="fa fa-search text-dark" aria-hidden="true"></i></span>
                                    </div>
                                    <input class="form-control my-0 py-1 border-left-0" id="search_request4" type="text"
                                           placeholder="Search and Scan for orders here." href="{{route('search.request')}}"
                                           data-shop="{{\Illuminate\Support\Facades\Auth::user()->name}}" aria-label="Search">
                                </div>

                            </div>

                        </div>
                        <div class="sections4">

                            <div class="row" style="margin-left: 0px;margin-right: 0px">
                                <div class="col-12" id="append4">
                                    @if(count($requests5) > 0 )

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

                                            @foreach($requests5 as $key=>$request)
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
                                                                                        href="https://tracking.sendcloud.sc/forward?carrier={{$request->request_labels->carrier}}&code={{$request->request_labels->tracking_code}}&destination={{$request->request_labels->destination}}&lang=en-us&source={{$easypost->state}}&type=letter&verification={{$request->request_labels->zip}}&servicepoint_verification=&created_at={{Carbon\Carbon::parse($request->request_labels->created_at)->toDateString()}}">Status</a> @endif
                                                    </td>
                                                    <td>
                                                        <a href="/requests/{{$request->id}}">Open</a>
                                                        @if($request->status==3 && $r_settings->finish_status==false)
                                                            <a class="ml-1 text-danger" href="{{route('delete.request',$request->id)}}">Delete</a>
                                                        @endif
                                                        @if($request->status==4 && $r_settings->decline_status==false)
                                                            <a class="ml-1 text-danger" href="{{route('delete.request',$request->id)}}">Delete</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                        <div class="text-right float-right">
                                            {{$requests5->links()}}
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
                </div>
            </div>
        </div>
    </div>



@endsection
