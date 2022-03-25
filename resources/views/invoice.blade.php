@extends('layouts.admin')
@section('content')
    <style>
        .table-borderless td, th {
            padding: 10px !important;
            font-size: 16px !important;
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-family: 'Poppins', sans-serif !important;
        }
        li small
        {
            font-weight: bold;
        }

        .LockOn {
            display: block;
            visibility: visible;
            position: fixed;
            z-index: 999;
            top: 0px;
            left: 0px;
            width: 105%;
            height: 105%;
            background-color:white;
            vertical-align:bottom;
            padding-top: 20%;
            filter: alpha(opacity=75);
            opacity: 0.75;
            font-size:large;
            color:blue;
            font-style:italic;
            font-weight:400;
            background-image: url("{{asset('images/loading.gif')}}");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }
    </style>
    <div class="main-content" id="panel">
        <div class="container-fluid">
            <div class="invoice_top_nav">
                <ul>
                    <li><a href="/dashboard">Returns</a></li>
                    <li class="arrow_icon"><i class="fa fa-angle-right"></i></li>
                    <li>
                        @if($request->status == 0)
                            <a href="{{route('dashboard',['type'=>'requested'])}}"> Requested </a>
                        @elseif($request->status == 1)
                            <a href="{{route('dashboard',['type'=>'approved'])}}"> Approved </a>
                        @elseif($request->status == 2)
                            <a href="{{route('dashboard',['type'=>'received'])}}"> Received</a>
                        @elseif($request->status == 3)
                            <a href="{{route('dashboard',['type'=>'refunded'])}}"> Completed</a>
                        @elseif($request->status == 4)
                            <a>Archive</a>
                        @endif
                    </li>
                    <li class="arrow_icon"><i class="fa fa-angle-right"></i></li>
                    <li>
                        #{{$request->id}}
                    </li>
                </ul>
            </div>
            <div class="progress_bar_Wrapper">
                <div class='row'>
                    <ul class="progressbar">
                        <li @if($request->status >= 0) class="active" @endif>
                            Requested <br>
                            <small> {{$request->created_at->format('m / d / Y')}}</small>
                        </li>

                        <li @if($request->status >= 1) class="active" @endif>
                            Approved <br>
                            {{--                            @foreach($request->has_statuses as $r_status)--}}
                            {{--                                @if($r_status->status == 1)--}}
                            @if($request->has_statuses()->where('status',1)->first())
                                <small> {{$request->has_statuses()->where('status',1)->first()->created_at->format('m / d / Y')}}</small>@endif
                            {{--                                @endif--}}
                            {{--                            @endforeach--}}
                        </li>
                        <li @if($request->status >= 2) class="active" @endif>
                            Received<br>
                            @if($request->has_statuses()->where('status',2)->first())
                                <small> {{$request->has_statuses()->where('status',2)->first()->created_at->format('m / d / Y')}}</small>@endif
                        </li>
                        <li @if($request->status >= 3) class="active" @endif>
                            COMPLETED<br>
                            @if($request->has_statuses()->where('status',3)->first())
                                <small> {{$request->has_statuses()->where('status',3)->first()->created_at->format('m / d / Y')}}</small>@endif
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-5">
                @if($request->status == 0)
                    <div class="alert alert-primary  fade show" role="alert">
                        <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-text">Your customer is waiting for approval!</span>
                        @if($request->status != 4)
                            <button class="btn button btn-sm btn-danger mx-3" style="float: right;"
                                    onclick="window.location.href='{{route('request.delete',$request->id)}}';">
                                Delete Request
                            </button>
                        @endif
                        <button type="button" class="btn btn-danger btn-sm" style="float: right;"
                                onclick="window.location.href='/requests/{{$request->id}}/status?type=approved';">
                            Approve the Request
                        </button>

                    </div>
                @endif

                @if($request->status == 1 || $request->status == 2)
                    <div class="alert alert-primary  fade show" role="alert">
                        <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-text">Customer is waiting?</span>
                        @if(count($request->request_products->where('return_type', 'exchange'))>0 && $request->request_Exchange===null)
                                <a href="{{route('request.manualExchange',$request->id)}}" class="btn btn-danger text-white float-right mx-2 btn-sm">Create Exchange Manually</a>
                        @endif
                        @if($request->status != 4)
                            <button class="btn button btn-sm btn-danger mx-3" style="float: right;"
                                    onclick="window.location.href='{{route('request.delete',$request->id)}}';">
                                Delete Request
                            </button>
                        @endif

                        <button type="button" class="btn btn-danger btn-sm mx-1" style="float: right;"
                                onclick="window.location.href='/requests/{{$request->id}}/status?type=refunded';">
                                Complete Request
                        </button>
                        @if(count($request->request_products->where('return_type', 'payment_method')) && count($request->request_refund)==0)
                            <a  href="{{route('request.refund',$request->id)}}" class="btn btn-danger text-white float-right mx-2 btn-sm">Create Refund of ${{$request->payment_method_products()->sum('price')}}</a>
                        @endif

                        @if(in_array($request->status,[1,2]) && isset($request->request_labels->status)   && count($request->request_products->where('return_type', 'store_credit'))>0 && $request->store_credited==false)
                            <a target="_blank" href="https://{{\Illuminate\Support\Facades\Auth::user()->name}}/admin/gift_cards/new" class="btn btn-danger text-white float-right mx-1 btn-sm">Create Gift Card of ${{$request->store_credit_products()->sum('price')}}</a>
                            <a href="{{route('mark.store.credited',$request->id)}}" class="btn btn-danger text-white float-right mx-1 btn-sm">Mark as store credited</a>
                        @endif
                    </div>
                @endif


            </div>
            @if($request->request_labels==null)
                <div class="content_wrapper mt-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h3>You can create a label by trying with Easypost</h3>
                                    <form method="GET"
                                          action="{{route('print.label',[$request->id,$request->order_id,$shop_id])}}">
                                        <button class="btn btn-primary btn-sm loader" type="submit">Create Label</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="content_wrapper mt-2">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6"><h5 class="h3 mb-0">Request Product</h5></div>
                                    <div class="col-md-6"><h5 class="h3 mb-0">Refund/Exchange/Store Credit</h5></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="products_list">
                                    @foreach(json_decode($request->items_json,true) as $item_json)


                                        <div class="row">

                                            <div class="col-md-2 align-middle p-0">
                                                <img style="width: 100%;height: auto;"
                                                     src="@if(isset($item_json['image'])){{$item_json['image']}} @endif">

                                            </div>
                                            <div class="col-md-4 align-middle">
                                                <b> {{$item_json['title'].'-'.implode(' / ',array_filter($item_json['options']))}} </b> x {{$item_json['quantity']}}
                                                <div class="row">
                                                    <div class="col-md-12 mt-2 font-weight-bold">
                                                        Price:
                                                        {{'$'.$item_json['price']}}
                                                    </div>



                                                    <div class="col-md-12 mt-2 font-weight-bold">
                                                        Reason:
                                                        {{\App\Models\Reason::find($item_json['return_reason'])->name}}
                                                    </div>
                                                    <div class="col-md-12 mt-2 font-weight-bold">
                                                        <br/>
                                                        <b><span class="badge badge-primary">{{ucwords(str_replace('_',' ',$item_json['return_type']))}}</span></b>
                                                    </div>
                                                </div>

                                            </div>


                                            @if($item_json['return_type']=='exchange')

                                                <?php $line_product = \App\Models\OrderLineProduct::where('product_id', $item_json['product_id'])->first();


                                                $line_product = json_decode($line_product->product_json);



                                                foreach ($line_product->variants as $s_variant) {


                                                    if ($s_variant->id == $item_json['exchange_variant_id'])

                                                        $sel_variant = $s_variant;
                                                }

                                                $ext_image = $item_json['image'];

                                                foreach ($line_product->images as $p_images) {
                                                    if ($p_images->id==$sel_variant->image_id) {
                                                        $ext_image = $p_images->src;
                                                    }
                                                }
                                                ?>
                                                <div class="col-md-2 align-middle p-0">

                                                    <img style="width: 100%;height: auto;"
                                                         src="{{$ext_image}}">

                                                </div>

                                                <div class="col-md-4 align-middle">

                                                    <b> {{$item_json['title'].'-'.$sel_variant->title}}</b>
                                                    x {{$item_json['quantity']}}
                                                    <div class="row">

                                                        <div class="col-md-12 mt-2 font-weight-bold">
                                                            Price:
                                                            {{'$'.$item_json['price']}}
                                                        </div>
                                                        @if($request->status==3)
                                                        <div class="col-md-12 mt-2 font-weight-bold">
                                                            <br/>
                                                            <b><span class="badge badge-success">Product Exchanged</span></b>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @elseif($item_json['return_type']=='payment_method')
                                                <div class="col-md-6 align-middle text-center text-warning py-5">
                                                    <b>{{'$'.$item_json['price']}} Amount will be Refunded<br/>against
                                                        this item</b>

                                                    @if($request->refunded==true || count($request->request_refund))
                                                        <br/>
                                                        <br/>
                                                        <br/>
                                                        <b><span class="badge badge-success">Payment Refunded</span></b>
                                                    @endif
                                                    <br/>
                                                    <b><a href="{{route('change.request_item.type',['id'=>$request->id,'item_id'=>$item_json['id']])}}" class="badge badge-info">Move to Store Credit</a></b>
                                                </div>
                                            @elseif($item_json['return_type']=='store_credit')
                                                <div class="col-md-6 align-middle text-center text-warning py-5">

                                                        <b>{{'$'.$item_json['price']}} Amount will be Credited<br/> by Store
                                                            against this item</b>

                                                    @if($request->store_credited)
                                                        <br/>
                                                        <br/>
                                                        <br/>
                                                        <br/>
                                                        <b><span class="badge badge-success">Gift Card Issued</span></b>
                                                    @endif
                                                    <br/>
                                                    <b><a href="{{route('change.request_item.type',['id'=>$request->id,'item_id'=>$item_json['id']])}}" class="badge badge-info">Move to Payment Method</a></b>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="h3 mb-0">Activity feed</h5>
                            </div>

                            <div class="card-body">
                                <div class="comments_for_all">
                                    @if(count($request->has_timelines) > 0)
                                        @foreach($request->has_timelines as $message)
                                            <div class="media media-comment">
                                                <div class="media-body">
                                                    <div class="media-comment-text d-flex justify-content-between"
                                                         style="padding-left: 1.25rem;">
                                                        <div>
                                                            <p class="text-sm lh-160 com_{{$message->id}}">{{$message->message}}</p>
                                                        </div>
                                                        <div>
                                                            <div class="row">
                                                                <p class="text-sm lh-160 mr-3 mb-0">{{$message->created_at}}</p>
                                                            </div>
                                                            <div class="row justify-content-end">
                                                                <div class="mr-3">
                                                                    <a href="#" id="{{$message->id}}"
                                                                       class="table-action edit-comment"
                                                                       data-toggle="tooltip" data-original-title="Edit">
                                                                        <i class="fas fa-user-edit"></i>
                                                                    </a>
                                                                    <a href="{{route('delete.comment',$message->id."-".$request->id)}}"
                                                                       class="table-action table-action-delete"
                                                                       data-toggle="tooltip"
                                                                       data-original-title="Delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>

                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <hr>
                                    @endif
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <form action="{{route('timeline.submit')}}" method="POST">
                                                {{csrf_field()}}
                                                <input type="hidden" name="comment_id" id="comment_id">
                                                <input type="hidden" name="request_id" value="{{$request->id}}">
                                                <textarea class="form-control" id="comment_section"
                                                          placeholder="Write your comment" rows="5"
                                                          name="message"></textarea>
                                                <button type="submit" class="btn btn-sm btn-primary mt-1">Submit
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        @if($request->request_labels)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tbody>
                                        <tr>
                                            <td colspan="2" class="text-center mb-2"><a href="{{route('resend.label',$request->id)}}" class="badge badge-primary">Resend Label</a></td>
                                        </tr>
                                        <tr>
                                            <td><b>Label Cost</b></td>
                                            <td>{{'$'.$request->request_labels->fees}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Carrier</b></td>
                                            <td>{{$request->request_labels->carrier}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Download</b></td>
                                            <td><a target="_blank" href="{{$request->request_labels->label}}"><img
                                                        width="20px" height="auto" src="{{asset('images/9.png')}}"></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Tracking Code</b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a target="_blank"
                                                               href="https://www.google.com/search?q={{$request->request_labels->tracking_code}}">{{$request->request_labels->tracking_code}}</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="">

                                    <table class="table table-borderless">
                                        {{--                                        <thead>--}}
                                        {{--                                        <tr>--}}
                                        {{--                                            <th colspan="2"><h3 class="h3 mb-0">Order Detail</h3></th>--}}
                                        {{--                                        </tr>--}}
                                        {{--                                        </thead>--}}
                                        <?php
                                        $order_data = json_decode($request->has_order->order_json, true);
                                        ?>
                                        <tbody>
                                        <tr>
                                            <td><b>Order No:</b></td>
                                            <td>{{str_replace('#','',$request->has_order->order_name)}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Customer:</b></td>
                                            <td>@if(isset($order_data['customer'])){{$order_data['customer']['first_name'].' '.$order_data['customer']['last_name']}}
                                                @endif</td>
                                        </tr>
                                        <tr>
                                            <td><b>Email:</b></td>
                                            <td>{{$request->has_order->email}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>SubTotal:</b></td>
                                            <td>{{'$'.$order_data['total_line_items_price']}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Discount:</b></td>
                                            <td>{{'$'.$order_data['total_discounts']}}</td>
                                        </tr>
                                        @if(isset($order_data['shipping_lines']['price']))
                                            <tr>
                                                <td><b>Shipping Cost:</b></td>
                                                <td>{{'$'.$order_data['shipping_lines']['price']}}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td><b>Total:</b></td>
                                            <td>{{'$'.$order_data['total_price']}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Status:</b></td>
                                            <td>{{ucwords($order_data['financial_status'])}}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .invoice_top_nav {
            padding: 50px 0;
            font-size: 22px;
        }

        .invoice_top_nav ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .invoice_top_nav ul li {
            display: inline-block;
            position: relative;
            margin: 0 25px;
        }

        .invoice_top_nav ul li:before {
            content: '';
        }

        .progressbar {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .progressbar li {
            list-style-type: none;
            width: 25%;
            float: left;
            font-size: 12px;
            position: relative;
            text-align: center;
            text-transform: uppercase;
            color: #7d7d7d;
            font-size: 16px;
        }

        .progressbar li:before {
            width: 30px;
            height: 30px;
            content: '';
            counter-increment: step;
            line-height: 27px;
            border: 3px solid #e0e0e0;
            display: block;
            text-align: center;
            margin: 0 auto 10px auto;
            border-radius: 50%;
            background-color: white;
        }

        .progressbar li:after {
            width: 100%;
            height: 3px;
            content: '';
            position: absolute;
            background-color: #e0e0e0;
            top: 14px;
            left: -50%;
            z-index: -1;
        }

        .progressbar li:first-child:after {
            content: none;
        }

        .progressbar li.active {

        }

        .progressbar li.active:before {
            border-color: #5e72e4;
            background: #5e72e4;
        }

        .progressbar li.active + li:after {
            background-color: #5e72e4;
        }

        .invoice_top_nav ul li.arrow_icon {
            margin: 0 -15px;
        }

        .products_list > .row {
            margin-bottom: 10px;
            border-bottom: 1px solid rgba(0, 0, 0, .05);
            padding-bottom: 10px;
        }

        .comments_for_all .media-comment:first-child {
            margin-top: 0;
        }

        .products_list > .row:last-child {
            border-bottom: 0;
            padding-bottom: 0;
            margin-bottom: 0;
        }
    </style>

    <script>
        function change_to_approve() {
            alert('aa');
        }


        $(document).ready(function(){

            $('.loader').click(function(){

                $('#panel').append('<div id="coverScreen"  class="LockOn"> </div>');
            });

        });
    </script>
@endsection
