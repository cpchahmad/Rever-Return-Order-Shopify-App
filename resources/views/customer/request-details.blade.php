@extends('layouts.customer')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/design-app.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css"/>
    <link rel="stylesheet" href="{{asset('css/modal.css')}}"/>
    <style>
        .porduct {
            cursor: pointer;
        }

        .modal {
            max-width: 75%;
            z-index: 1000;

        }

        .z-index0 {
            z-index: 0;
        }

        .delete_item {
            z-index: 1;
        }


        .alert {
            padding: 20px;
            background-color: #f44336;
            color: white;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }


        .img_main{
            height: 100px;
            margin-left: 15px;
        }

        .row{
            margin-bottom: 0px !important;
            padding-bottom: 0px !important;
        }

    </style>
@endsection


@section('content')




    <?php

    $active_items = [];

    if ($customsession) {


        foreach ($customsession as $items) {
            array_push($active_items, $items['id']);
        }
        $session_items = $customsession;


    }



    $order_name = str_replace('#', '', $order->order_name);

    $request_items = [];
    $has_blocked_items=false;
    foreach ($line_items as $it) {


        if ($it['unavailable'] == true) {
            array_push($request_items, $it);
        }
        if($it['blocked']==true)
        {
            $has_blocked_items=true;
        }
    }

    ?>








    <form method="GET" action="https://{{$domain}}/a/return/customer/order/selected/submit">
        <input type="hidden" name="shop" value="{{\App\Models\User::find($order->shop_id)->name}}">
        <input type="hidden" name="order_name" value="{{$order_name}}">
        <input type="hidden" name="email" value="{{$order->email}}">
        <input type="hidden" name="sessiondata" value="{{json_encode($customsession)}}">

    <div class="container" style="border: none;">
        <div class="main-card mx-auto">
            <h1>Which items would you like to return or exchange?</h1>
            <div class="mx-auto active-details d-flex justify-content-between">
                <p>{{$order->order_name}}</p>
                <p>{{$date}}</p>
            </div>

            @if(!$returnable)
                @foreach($line_items as $line_item)
            <div class="box-1 mx-auto">
                <div class="row">
                    <div class="col-md-2">
                        <div class="img">
                            <img src="@if(isset($line_item['image'])){{$line_item['image']}} @endif" alt="">
                        </div>
                    </div>
                    <div class="col-md-10">
                        <h6 class="pt-1">{{$line_item['title']}}</h6>
                        <p class="">${{$line_item['price']}}</p>
                        <div class="radio-buttons d-flex gap-2">
                            <img class="red-button" src="{{asset('images/red.png')}}" alt="">
{{--                            <p class="m">@if(isset($line_item['options']))--}}
{{--                                @foreach($line_item['options'] as $option)--}}
{{--                                    @if($option)--}}
{{--                                        {{$option}}@endif--}}
{{--                                        @endforeach--}}

{{--                                        @endif</p>--}}
                            @if(isset($line_item['options']))
                                @foreach($line_item['options'] as $option)
                                    @if($option)
                                        <p class="m">
                                            {{$option}}</p>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

                @endforeach
            @else
                @foreach($line_items as $line_item)

               @if($line_item['blocked']==false && $line_item['unavailable']==false)
                        @if(!in_array($line_item['id'],$active_items))
                            <a style="text-decoration: none"

                               @if($line_item['fulfillment_status']==null)  href="#" @else href="https://{{$domain}}/a/return/customer/order/{{$order->id}}/lineItem/{{$line_item['id']}}/selected" @endif>
                            @endif

                        <div class="box-1 mx-auto mt-3">
                <div class="row mt-2">

                    @if(in_array($line_item['id'],$active_items))
                        <div class="img_background delete_item " style="text-align: right;cursor: pointer"

                             data-href="https://{{$domain}}/a/return/customer/{{$order->id}}/item/{{$line_item['id']}}/remove?customsession={{json_encode($customsession)}}&line_item_id={{$line_item['id']}}">
                            <img style="background: black" src="{{asset('images/x.svg')}}" alt="false" id="cross">
                            <img  src="{{asset('images/true.svg')}}" alt="tick" id="tick">


                        </div>
                    @endif
                    <div class="col-md-2">
                        <div class="img img_main">
                            <img style="width: 100%;" src="@if(isset($line_item['image'])){{$line_item['image']}} @endif" alt="">
                        </div>

                    </div>
                    <div class="col-md-7 px-4 py-2 ">
                        <h7 style="font-size: 14px" class="pt-1">{{$line_item['title']}}</h7>

                        @if(in_array($line_item['id'],$active_items))
                            <?php
                            $li = $session_items->where('id', $line_item['id'])->first();
                            ?>
                            @if($li['return_type']=='exchange' &&isset($li['exchange_options']))
                                <p class="mt-2" style="font-size: 14px;display: block">Exchange for {{implode(' / ',$li['exchange_options'])}}</p>
                            @elseif($li['return_type']=='payment_method' || $li['return_type']=='store_credit')
                                <p class="mt-2" style="font-size: 14px;display: block">Return this item</p>
                            @endif
                        @else
                        <p style="font-size: 14px" class="mt-2">${{$line_item['price']}}</p>
                        @endif
                        <div class="radio-buttons d-flex gap-2 ">
                            <img class="red-button" src="{{asset('images/red.png')}}" alt="">
                            @if(isset($line_item['options']))
                                @foreach($line_item['options'] as $option)
                                    @if($option)
                                    <p class="m">
                                        {{$option}}</p>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @if($line_item['fulfillment_status']==null)
                    <div class="col-md-3 exchange" >
                    <span class="notfulfilled">Not fulfilled</span>
                    </div>
                        @endif
                </div>
            </div>

                            @if(!in_array($line_item['id'],$active_items))</a>  @endif

                    @endif
                @endforeach
            @endif

            @if(count($request_items))
                @foreach($request_items as $request_item)

                    @php
                        $check_decline_status=\App\Models\Request::where('id',$request_item['request_id'])->first();
                    @endphp
                    @if($request_item['unavailable']==true)

                        <a style="text-decoration: none" href="#request_{{$request_item['request_id']}}" rel="modal:open">
            <div class="box-1 mx-auto mt-3">
                <div class="row">
                    <div class="col-md-2">
                        <div class="img img_main">
                            <img style="width: 100%;" src="@if(isset($request_item['image'])){{$request_item['image']}} @endif" alt="">
                        </div>
                    </div>
                    <div class="col-md-7 px-4 py-2">
                        <h6 style="font-size: 14px" class="pt-1">{{$request_item['title']}}</h6>
                        <p style="font-size: 14px" class="">${{$request_item['price']}}</p>
                        <div class="radio-buttons d-flex gap-2">
                            <img class="red-button" src="{{asset('images/red.png')}}" alt="">

                            @if(isset($request_item['options']))
                                @foreach($request_item['options'] as $option)
                                    @if($option)
                                      <p class="m">
                                        {{$option}}</p>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                           <div class="col-md-3 exchange">
                          <span class="notfulfilled">View Progress</span>
                           </div>
                </div>
            </div>

                        </a>

                        <div id="request_{{$request_item['request_id']}}" class="modal">
                            <?php
                            $getuser_id=\App\Models\User::where('name',$domain)->first();
                            $request = \App\Models\Request::where('id',$request_item['request_id'])->where('shop_id',$getuser_id->id)->first();


                            $order = \App\Models\Order::where('id',$request->order_id)->where('shop_id',$getuser_id->id)->first();
                            $r_status = $request->has_statuses;
                            ?>
                            <div class="row">
                                <h3 class="text-center mt-2 mb-1">Request No
                                    #{{$request->id}}</h3>
                                <ul class="progressbar">
                                    <li @if($request->status >= 0) class="active" @endif>
                                        Requested <br>
                                        <small> {{$request->created_at->format('m / d / Y')}}</small>
                                    </li>

                                    <li @if($request->status >= 1) class="active" @endif>
                                        Compensated <br>
                                        @if($request->request_refund_status)
                                            <small> {{$request->request_refund_status->created_at->format('m / d / Y')}}</small>
                                        @endif

                                        @if($request->request_exchange_status)
                                            <small> {{$request->request_exchange_status->created_at->format('m / d / Y')}}</small>
                                        @endif




                                        @if($request->store_credited==1)
                                            <small> {{$request->where('id',$request->id)->where('store_credited',1)->first()->request_store_credit_date}}</small>
                                        @endif


                                    </li>
                                    <li @if($request->status >= 2) class="active" @endif>
                                        Received<br>

                                        @if($request->where('id',$request->id)->where('request_receive',1)->first())
                                            <small> {{$request->where('id',$request->id)->where('request_receive',1)->first()->request_receive_date}}</small>@endif
                                    </li>
                                    <li @if($request->status == 3) class="active" @endif>
                                        Completed<br>
                                        @if($request->has_statuses()->where('status',3)->first())
                                            <small> {{$request->has_statuses()->where('status',3)->first()->created_at->format('m / d / Y')}}</small>@endif
                                    </li>
                                </ul>
                                <br/>
                                <br/>
                            </div>
                            <div class="products_list">


                                @foreach(json_decode($request->items_json,true) as $index=>$item_json)



                                    <div class="row">

                                        <div class="col-md-2 align-middle p-0">
                                            <img style="width: 100%;height: auto;"
                                                 src="@if(isset($item_json['image'])){{$item_json['image']}}  @endif">
                                            {{--                                                                             src="{{ isset($item_json['image'])?$item_json['image']:isset($line_item['image'])?$line_item['image']:""}}">--}}

                                        </div>
                                        <div class="col-md-4 align-middle">
                                            <b> {{$item_json['title'].'-'.implode(' / ',array_filter($item_json['options']))}} </b>
                                            x {{$item_json['quantity']}}
                                            <div class="row">


                                                <div
                                                    class="col-md-12 mt-2 font-weight-bold">
                                                    Price:
                                                    {{'$'.$item_json['price']}}
                                                </div>
                                                <div
                                                    class="col-md-12 mt-2 font-weight-bold">
                                                    Reason:
                                                    <!--                                                                                --><?php //$reason=\App\Models\ReasonsDataSet::find($item_json['return_reason'])?>
                                                    <?php $reason=\App\Models\Reason::find($item_json['return_reason'])?>
                                                    {{($reason!==null?$reason->name:'Unknown Reason')}}
                                                </div>
                                                <div
                                                    class="col-md-12 mt-2 font-weight-bold">
                                                    <br/>
                                                    <b><span
                                                            class="badge badge-primary">{{ucwords(str_replace('_',' ',$item_json['return_type']))}}</span></b>
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



                                            $ext_image = isset($item_json['image'])?$item_json['image']:"";

                                            foreach ($line_product->images as $p_images) {
                                                if ($p_images->id == $sel_variant->image_id) {
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

                                                    <div class="col-md-12 mt-2">
                                                        Price:
                                                        {{'$'.$item_json['price']}}
                                                    </div>
                                                    @if($request->status==3)
                                                        <div
                                                            class="col-md-12 mt-2 font-weight-bold">
                                                            <br/>
                                                            <b><span
                                                                    class="badge badge-success">Product Exchanged</span></b>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif($item_json['return_type']=='payment_method')
                                            <div
                                                class="col-md-6 align-middle text-center text-warning py-5">
                                                <b>{{'$'.$item_json['price']}} Amount will
                                                    be Refunded<br/>against
                                                    this item</b>

                                                @if($request->status==3)
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    <b><span class="badge badge-success">Payment Refunded</span></b>
                                                @endif
                                            </div>
                                        @elseif($item_json['return_type']=='store_credit')
                                            <div
                                                class="col-md-6 align-middle text-center text-warning py-5">

                                                <b>{{'$'.$item_json['price']}} Amount will
                                                    be Credited<br/> by Store
                                                    against this item</b>

                                                @if($request->status==3)
                                                    <br/>
                                                    <br/>
                                                    <br/>
                                                    <b><span class="badge badge-success">Gift Card Issued</span></b>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                @endforeach
                            </div>
                        </div>

                    @endif
                @endforeach
            @endif
            <br>
            @if($returnable && ($r_settings && $r_settings->display_block_product==true && $has_blocked_items==true))
                @foreach($line_items as $line_item)
                    @if($line_item['blocked']==true)
            <div class="mx-auto muted-details d-flex justify-content-between">
                <p>{{$order->order_name}}</p>
                <p>{{$date}}</p>
            </div>
            <div class="box-1 mx-auto mt-4 opacity-50">
                <div class="row">
                    <div class="col-md-2">
                        <div class="img img_main">
                            <img style="width: 100%;" src="@if(isset($line_item['image'])){{$line_item['image']}} @endif" alt="">
                        </div>
                    </div>
                    <div class="col-md-7 px-4 py-2">
                        <h6 style="font-size: 14px" class="pt-1">{{$line_item['title']}}</h6>
                        <p style="font-size: 14px" class="">${{$line_item['price']}}</p>
                        <div class="radio-buttons d-flex gap-2">
                            <img class="muted-button" src="{{asset('images/circle.png')}}" alt="">
                            @if(isset($line_item['options']))
                                @foreach($line_item['options'] as $option)
                                    @if($option)
                                         <p class="m">
                                        {{$option}}</p>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 expired">
                        <span class="blockproduct">Block Product</span>
                    </div>
                </div>
            </div>

                    @endif
                @endforeach
                @endif
{{--            <div class="box-1 mx-auto mt-4 opacity-50">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-2">--}}
{{--                        <div class="img">--}}
{{--                            <img src="./img/profile.avatar.jpg" alt="">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <h6 class="pt-1">Item Name 2</h6>--}}
{{--                        <p class="">28.00€</p>--}}
{{--                        <div class="radio-buttons d-flex gap-2">--}}
{{--                            <img class="muted-button" src="./img/circle.png" alt="">--}}
{{--                            <p class="m">M</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-2 expired">--}}
{{--                        Expired--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

            @if($customsession)
                @if(count($customsession)>1)
{{--                    <span>{{count($customsession)}} items selected</span>--}}

                    @php
                 $count=count($customsession);
                    @endphp
                @elseif(count($customsession))
{{--                    <span>{{count($customsession)}} item selected</span>--}}
                    @php
                        $count=count($customsession);
                    @endphp
                @endif
            @else
{{--                <span>No item selected</span>--}}
            @endif



            <button @if(count($active_items)) type="submit" @else type="button" @endif class="refund-btn"><strong>refund @if(isset($count))({{$count}}) @endif </strong></button>
        </div>

    </div>

    </form>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script>
        $(document).ready(function () {
            // $("head").remove();
            $('.delete_item').on('click', function () {
                window.location.href = $(this).attr('data-href');
            });
            $('.product_container').on('click', function () {
                $(this).parent('a').trigger('click');
            });
            $('.modal').on('change', function () {
                if ($(this).css('display') == 'inline-block') {
                    $('.butonContinue').addClass('z-index0');
                } else {
                    $('.butonContinue').removeClass('z-index0');
                }
            })
        });
    </script>
@endsection

