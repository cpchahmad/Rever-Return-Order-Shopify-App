@extends('layouts.customer')

@section('css')
    <link rel="stylesheet" href="{{asset('css/product.css')}}">
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

        <div class="container">




            <div class="header">
                <div id="over" style="position:absolute;left: 50%;transform: translateX(-50%) ">
                    <a href="https://{{$domain}}"  style="text-decoration: none;">
                        @if($settings)
                            <img class="logo-img" src="{{asset('logos/'.$settings->logo)}}" style="width:135px;height: auto;" alt="logo">
                            <h5 style="color: white">Powered by Rever</h5>
                        @else
                            <img src="{{asset('logos/Logo REVER.png')}}" style="width:135px;height: auto;" alt="logo">
                            <h5 style="color: white">Powered by Rever</h5>

                        @endif
                    </a>
                </div>
            </div>
            @if(isset($error))
                <div class="alert" style="margin-top: 20px" >
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <strong>{{$error}}</strong>
                </div>

            @endif
            <div class="main_products_all_section" style="margin-top: 10px;">
                <div class="heading_section">
                    <h2>Choose an item to return/ exchange</h2>


                </div>
                <div class="return_text">
                    <span class="return">Returnable until {{$date}}</span>
                </div>
                <div class="main_all_products_section">
                    <ul class="all_prodcts_list">
                        @if(!$returnable)
                            <div class="non-returnAble">
                                <div class="return_text">
                                    <ul class="non_return">
                                        @foreach($line_items as $line_item)

                                            <li class="porduct ">
                                                <a href="">
                                                    <div class="product_container">
                                                        <div class="product_parent">
                                                            <div class="product_img">
                                                                <div class="img_parent">

                                                                    <img src="@if(isset($line_item['image'])){{$line_item['image']}} @endif"
                                                                         alt=""
                                                                         class="img_responsive">
                                                                </div>
                                                            </div>
                                                            <div class="product_disc">
                                                                <div class="all_discription">
                                                                    <div class="product_title">
                                                                        <h3>{{$line_item['title']}}</h3>
                                                                    </div>
                                                                    <div class="variants">
                                                                        <ul class="active">
                                                                            @if(isset($line_item['options']))
                                                                            @foreach($line_item['options'] as $option)
                                                                                @if($option)
                                                                                    <li>{{$option}}</li>@endif
                                                                            @endforeach

                                                                                @endif
                                                                        </ul>
                                                                    </div>
                                                                    <div class="price_product">
                                                                        <span>${{$line_item['price']}}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @else
                            @foreach($line_items as $line_item)

                                @if($line_item['blocked']==false && $line_item['unavailable']==false)
                                    <li class="porduct @if($line_item['fulfillment_status']==null) non-fulfillment @endif @if(in_array($line_item['id'],$active_items)) active @endif ">
                                        @if(!in_array($line_item['id'],$active_items))<a

                                            href="https://{{$domain}}/a/return/customer/order/{{$order->id}}/lineItem/{{$line_item['id']}}/selected">
                                            @endif
                                            <div class="product_container">
                                                <div class="icons_images"
                                                >
                                                    <div class="img_background delete_item"

                                                         data-href="https://{{$domain}}/a/return/customer/{{$order->id}}/item/{{$line_item['id']}}/remove?customsession={{json_encode($customsession)}}&line_item_id={{$line_item['id']}}">
                                                        <img src="{{asset('images/true.svg')}}" alt="tick" id="tick">
                                                        <img src="{{asset('images/x.svg')}}"
                                                             alt="false" id="cross">
                                                    </div>
                                                </div>
                                                <div class="product_parent">
                                                    <div class="product_img">
                                                        <div class="img_parent">
                                                            <img src="@if(isset($line_item['image'])){{$line_item['image']}} @endif" alt=""
                                                                 class="img_responsive">
                                                        </div>
                                                    </div>
                                                    <div class="product_disc">
                                                        <div class="all_discription">
                                                            <div class="product_title">
                                                                <h3>{{$line_item['title']}}</h3>
                                                            </div>
                                                            <div class="variants">
                                                                <ul>
                                                                    @if(isset($line_item['options']))
                                                                    @foreach($line_item['options'] as $option)
                                                                        @if($option)
                                                                            <li>{{$option}}</li>@endif
                                                                    @endforeach
                                                                        @endif
                                                                </ul>
                                                            </div>
                                                            <div class="price_product">
                                                                @if(in_array($line_item['id'],$active_items))
                                                                    <?php
                                                                    $li = $session_items->where('id', $line_item['id'])->first();
                                                                    ?>
                                                                    @if($li['return_type']=='exchange' &&isset($li['exchange_options']))
                                                                        <span>Exchange for {{implode(' / ',$li['exchange_options'])}}</span>
                                                                    @elseif($li['return_type']=='payment_method' || $li['return_type']=='store_credit')
                                                                        <span>Return this item</span>
                                                                    @endif
                                                                @else
                                                                    <span>${{$line_item['price']}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!in_array($line_item['id'],$active_items))</a>@endif
                                    </li>
                                @endif
                            @endforeach
                        @endif


                        @if(count($request_items))
                            <div class="">
                                <div class="return_text">
                                    <span class="return">Return/ Exchange Started</span>
                                    <ul class="non_return">
                                        @foreach($request_items as $request_item)

                                            @php
                                            $check_decline_status=\App\Models\Request::where('id',$request_item['request_id'])->first();
                                            @endphp
                                            @if($request_item['unavailable']==true)
                                                <li class="porduct @if($check_decline_status->status==4) request-decline @else already-Requested @endif">
                                                    <a href="#request_{{$request_item['request_id']}}" rel="modal:open">
                                                        <div class="product_container">
                                                            <div class="product_parent">
                                                                <div class="product_img">
                                                                    <div class="img_parent">
                                                                        <img src="@if(isset($request_item['image'])){{$request_item['image']}} @endif"
                                                                             alt=""
                                                                             class="img_responsive">
                                                                    </div>
                                                                </div>
                                                                <div class="product_disc">
                                                                    <div class="all_discription">
                                                                        <div class="product_title">
                                                                            <h3>{{$request_item['title']}}</h3>
                                                                        </div>
                                                                        <div class="variants">
                                                                            <ul class="active">

                                                                                @if(isset($request_item['options']))
                                                                                @foreach($request_item['options'] as $option)
                                                                                    @if($option)
                                                                                        <li>{{$option}}</li>@endif
                                                                                @endforeach
                                                                                    @endif
                                                                            </ul>
                                                                        </div>
                                                                        <div class="price_product">
                                                                            <span>${{$request_item['price']}}</span>
                                                                        </div>
                                                                    </div>
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
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif






                        @if($returnable && ($r_settings && $r_settings->display_block_product==true && $has_blocked_items==true))
                            <div class="non-returnAble">
                                <div class="return_text">
                                    <span class="return">Final sale/ non returnable products</span>
                                    <ul class="non_return">
                                        @foreach($line_items as $line_item)
                                            @if($line_item['blocked']==true)
                                                <li class="porduct">
                                                    <a href="">
                                                        <div class="product_container">
                                                            <div class="product_parent">
                                                                <div class="product_img">
                                                                    <div class="img_parent">
                                                                        <img src="@if(isset($line_item['image'])){{$line_item['image']}} @endif"
                                                                             alt=""
                                                                             class="img_responsive">
                                                                    </div>
                                                                </div>
                                                                <div class="product_disc">
                                                                    <div class="all_discription">
                                                                        <div class="product_title">
                                                                            <h3>{{$line_item['title']}}</h3>
                                                                        </div>
                                                                        <div class="variants">
                                                                            <ul class="active">
                                                                                @if(isset($line_item['options']))
                                                                                @foreach($line_item['options'] as $option)
                                                                                    @if($option)
                                                                                        <li>{{$option}}</li>@endif
                                                                                @endforeach

                                                                                    @endif
                                                                            </ul>
                                                                        </div>
                                                                        <div class="price_product">
                                                                            <span>${{$line_item['price']}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="butonContinue">
            <div class="container">
                <div class="main_btn_section">
                    <div class="small_section">

                        @if($customsession)
                            @if(count($customsession)>1)
                                <span>{{count($customsession)}} items selected</span>
                            @elseif(count($customsession))
                                <span>{{count($customsession)}} item selected</span>
                            @endif
                        @else
                            <span>No item selected</span>
                        @endif
                    </div>
                    <div class="button_section">
                        <button @if(count($active_items))type="submit" @else type="button" @endif>Continue with return
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script>
        $(document).ready(function () {
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


