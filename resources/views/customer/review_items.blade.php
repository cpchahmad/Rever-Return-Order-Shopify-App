@extends('layouts.customer')

@section('css')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/design-app.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css"/>



<style>
    .items-no{

        padding: 0px !important;
        line-height:26px !important;
    }
    .main-card{

        padding: 34px 60px;
    }
    .overview-rates {
        padding-top: 104px;
    }
    .img.overview-png {

        height: 130px;
    }
    .heading {

        margin-bottom: 40px;
    }
</style>

@endsection


@section('content')
    <div class="container">


        <div class="main-card mx-auto">
            <div class="row mx-auto">
                <h1 class="heading">Overview</h1>

                <?php $r_sum = 0; $s_sum = 0;$sum = 0;$ex_sum=0;?>
                @foreach($items as $item)
                    <?php

                    if ($item['return_type'] == 'payment_method') {
                        $r_sum += $item['price'];

                    } else if ($item['return_type'] == 'store_credit') {
                        $s_sum += $item['price'];
                    }
                    $sum += $item['price'];

                    ?>

                <div class="col-md-6 col-12">



                    <div class="row">

                        <h6>Return Item</h6>
                        <div class="col-md-4 col-3">
                            <img class="overview-png" style="width: 100%" src="@if(isset($item['image'])){{$item['image']}} @endif" alt="">
                        </div>


                        <div class="col-md-6 col-8 pt-2">
                            <h4 class="items-no" style="font-size: 12px">{{$item['title']}}</h4>
                            <div class="radio-buttons d-flex">
                                <img src="{{asset('images/red.png')}}" alt="" class="red-button">

                                @if(isset($item['options']))
                                    @foreach($item['options'] as $opt)
                                        @if($opt)
                                            <p class="m">{{$opt}}</p>
                                                @endif
                                        @endforeach
                                                 @endif

                            </div>
                            <div class="overview-text d-flex">
                                <p class="p-tag">Return Item Cost:</p>
                                <p style="color:black;margin-left: 20px">{{$item['price']}}€</p>
{{--                                <p>Shipping</p>--}}
{{--                                <p class="p-tag">Refund</p>--}}
                            </div>

                        </div>
                        <div class="col-md-2 ">
                            <div class="overview-rates">

{{--                                <p>3.00€</p>--}}
{{--                                <p class="rate">+25.00€</p>--}}
                            </div>

                        </div>

                    </div>
                </div>
                @endforeach

                @if(count($exchange_items))
                    @foreach($exchange_items as $ex_item)
                        <?php
                        $ex_sum += $ex_item['price'];
                        ?>


                    <div class="col-md-6 col-12">
                        <div class="row">
                            <h6>New Item</h6>
                            <div class="col-md-4 col-3">
                                <img style="width: 100%" class="overview-png" src="{{$ex_item['image']}}" alt="">
                            </div>
                            <div class="col-md-6 col-8 pt-2">
                                <h4 class="items-no" style="font-size: 12px">{{$ex_item['title']}}</h4>
                                <div class="radio-buttons d-flex">
                                    <img src="{{asset('images/red.png')}}" alt="" class="red-button">
                                    @foreach($ex_item['exchange_options'] as $opt)
                                        @if($opt)
                                    <p class="m">{{$opt}}</p>
                                        @endif
                                            @endforeach

                                </div>
                                <div class="overview-text d-flex">
{{--                                    <p>Size change</p>--}}
{{--                                    <p>Shipping</p>--}}
                                    <p class="p-tag">New Item Cost</p>
                                    <p style="color: black;margin-left: 20px" class="">{{$ex_item['price']}}€</p>
                                </div>

                            </div>
                            <div class="col-md-3 mt-3">
                                <div class="overview-rates">
{{--                                    <p>0.00€</p>--}}
{{--                                    <p>3.00€</p>--}}

                                </div>

                            </div>
                        </div>
                    </div>

                    @endforeach
                @endif

            </div>

            <hr>

            <div class="overview-summary row mb-5">
                <h1>Summary</h1>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6 col-8">
                            @if($ex_sum>0)
                                <p>New Items:</p>
                                <p>Subtotal:</p>
                            @endif
                                @if($r_sum>0)
                                    <p>Refund Credit</p>
                                    @endif

{{--                            <p>Shipping</p>--}}

                                @if(($ex_sum-$sum)>=0)
                                @if($ex_sum>0 && $r_sum==0 && $s_sum==0)
                                        <p><strong>TOTAL EXCHANGE AMOUNT</strong></p>

                                    @elseif($r_sum>0 && $s_sum==0 && $ex_sum==0)
                                        <p><strong>TOTAL REFUND</strong></p>

                                    @endif
                                    @endif


                        </div>
                        <div class="col-md-6 col-4">
                            @if($ex_sum>0)
                                <p>{{number_format($ex_sum,2)}}€</p>
                                <p>{{number_format($ex_sum,2)}}€</p>
                            @endif
                                @if($r_sum>0)
                                    <p>{{number_format($r_sum,2)}}€</p>
                                @endif

                                @if(($ex_sum-$sum)>=0)
                                @if($ex_sum>0 && $r_sum==0 && $s_sum==0)
                            <p><strong>{{number_format($sum-$ex_sum,2)}}€</strong></p>
                                    @elseif($r_sum>0 && $s_sum==0 && $ex_sum==0)
                                    <p><strong>{{number_format($sum-$ex_sum,2)}}€</strong></p>
                                @endif

                                @endif

{{--                            <p>6.00€</p>--}}

                        </div>
                    </div>
                </div>


{{--                <div class="col-md-6">--}}
{{--                    <div class="form-group">--}}
{{--                        <label class="iban-label">pleasr introduce your IBAN to get your instant fund</label>--}}
{{--                        <input type="text" class="iban-input">--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

            <?php
            $order_name = str_replace('#', '', $order->order_name);
            ?>
            <form id="submitForm" method="GET" action="https://{{$shop}}/a/return/customer/confirm/request">
                <input type="hidden" name="shop" value="{{\App\Models\User::find($order->shop_id)->name}}">
                <input type="hidden" name="order_name" value="{{$order_name}}">
                <input type="hidden" name="email" value="{{$order->email}}">
                <input type="hidden" name="sessiondata" value="{{json_encode($customsession)}}">
            <div class="row">


                <div class="col-md-10 offset-md-1">
                    <button style="margin-left: unset"   type="submit" class="refund-btn"><strong>Complete </strong></button>
                </div>


                </div>
            </form>

        </div>
    <br/>
@endsection


@section('script')
    <script>
        function submit_return() {
            window.location.href = ",['shop'=>$shop,'order_name'=>$order_name,'email'=>$order->email]))}}";
        }
        $(document).on('submit','#submitForm',function(){
            $(this).find('button[type=submit]').attr('disabled','disabled');
        })


        function go_back() {
            window.history.back();
        }
    </script>
@endsection
