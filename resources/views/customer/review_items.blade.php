@extends('layouts.customer')

@section('css')
    <link rel="stylesheet" href="{{asset('css/exchange.css')}}">


{{--<style>--}}
{{--    body {--}}
{{--        @if(isset($settings->background))--}}
{{--background-image: url('{{asset('logos/'.$settings->background)}}') !important;--}}
{{--        @else--}}
{{--background-image: url('{{asset('logos/backgroungimg.png')}}') !important;--}}
{{--        @endif--}}
{{--background-repeat: no-repeat !important ;--}}
{{--        background-size: cover !important;--}}
{{--    }--}}
{{--</style>--}}
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
                    <img src="{{asset('logos/Logo REVER.png')}}" style="width:135px;height: auto;" alt="logo">
                    <h5 style="color: white">Powered by Rever</h5>


                @endif
            </a>
        </div>
        </div>
        <div class="main_products_all_section">
            <div class="heading_section">
                <h2>Review your Return</h2>
            </div>
        </div>
        <?php $ex_sum = 0?>
        {{--@if(count($exchange_items))
            <div class="main_prodduct_parent">
                <div class="product_detail product_one_detail">
                    <div class="header_product">
                        <span>Items you’re getting</span>
                    </div>
                    @foreach($exchange_items as $ex_item)
                        <?php
                        $ex_sum += $ex_item['price'];
                        ?>
                        <div class="product__detail">
                            <div class="product___flex_main">
                                <div class="produc__img_detail">
                                    <div class="product__img_disc">
                                        <div class="product_img">
                                            <img src="{{$ex_item['image']}}" alt="" class="img_responsive">
                                        </div>
                                        <div class="product__detail_variants">
                                            <div class="title___produt">
                                                <span>{{$ex_item['title']}}</span>
                                            </div>
                                            <div class="title___produt">
                                                <ul class="product__variants">
                                                    @foreach($ex_item['exchange_options'] as $opt)
                                                        @if($opt)
                                                            <li>{{$opt}}</li>@endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="produt__price">
                                    <span>{{'$'.$ex_item['price']}}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif--}}
        <div class="main_prodduct_parent main_prodduct_parent_one">
            <div class="product_detail">
                <div class="header_product">
                    <span>Items you’re returning</span>
                </div>
                <?php $r_sum = 0; $s_sum = 0;$sum = 0?>
                @foreach($items as $item)
                    <?php
                    if ($item['return_type'] == 'payment_method') {
                        $r_sum += $item['price'];
                    } else if ($item['return_type'] == 'store_credit') {
                        $s_sum += $item['price'];
                    }
                    $sum += $item['price'];
                    ?>
                    <div class="product__detail">
                        <div class="product___flex_main">
                            <div class="produc__img_detail">
                                <div class="product__img_disc">
                                    <div class="product_img">
                                        <img src="@if(isset($item['image'])){{$item['image']}} @endif" alt="" class="img_responsive">
                                    </div>
                                    <div class="product__detail_variants">
                                        <div class="title___produt">
                                            <span>{{$item['title']}}</span>
                                        </div>
                                        <div class="title___produt">
                                            <ul class="product__variants">
                                                @foreach($item['options'] as $opt)
                                                    @if($opt)
                                                        <li>{{$opt}}</li>@endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="produt__price">
                                <span>{{'$'.$item['price']}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="main_summry_parent">
            <div class="product_detail">
                <div class="summeryheader">
                    <span>Summary</span>
                </div>
                @if($ex_sum>0)
                    <div class="product_price_detail new_items">
                        <ul>
                            <li>
                                <div class="product_detail_summry_flex">
                                    <div class="return_name">
                                        <span>New Items</span>
                                    </div>
                                    <div class="return_price">

                                        <span>${{number_format($ex_sum,2)}}</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endif
                <div class="product_price_detail">

                    <ul>
                        @if($ex_sum>0)
                            <li>
                                <div class="product_detail_summry_flex">
                                    <div class="return_name">
                                        <span>Subtotal</span>
                                    </div>
                                    <div class="return_price">

                                        <span>${{number_format($ex_sum,2)}}</span>
                                    </div>
                                </div>
                            </li>
                        @endif
                        @if($r_sum>0)
                            <li>
                                <div class="product_detail_summry_flex">
                                    <div class="return_name">
                                        <span>Refund Credit</span>
                                    </div>
                                    <div class="return_price">

                                        <span>${{number_format($r_sum,2)}}</span>
                                    </div>
                                </div>
                            </li>
                        @endif
                        @if($s_sum>0)
                            <li>
                                <div class="product_detail_summry_flex">
                                    <div class="return_name">
                                        <span>Store Credit</span>
                                    </div>
                                    <div class="return_price">

                                        <span>${{number_format($s_sum,2)}}</span>
                                    </div>
                                </div>
                            </li>
                        @endif


                    </ul>
                </div>

                <div class="product__button_two">
                    @if(($sum-$ex_sum)>=0)
                        <div class="product__button_flex product__button_flex_second">
                            <div class="producct__one_div">
                                @if($s_sum>0 && $r_sum==0 && $ex_sum==0)
                                    <span>TOTAL STORE CREDIT</span>
                                @elseif($r_sum>0 && $s_sum==0 && $ex_sum==0)
                                    <span>TOTAL REFUND USD</span>
                                @elseif($ex_sum>0 && $r_sum==0 && $s_sum==0)
                                    <span>TOTAL EXCHANGE AMOUNT</span>
                                @else
                                    <span>TOTAL RETURNABLE AMOUNT</span>
                                @endif

                            </div>
                            <div class="producct__second_div text-rightt">
                                <span>${{number_format($sum-$ex_sum,2)}}</span>
                            </div>
                        </div>
                    @else
                        <div class="product__button_flex product__button_flex_second">
                            <div class="producct__one_div">
                                TOTAL PAYABLE AMOUNT
                            </div>
                            <div class="producct__second_div text-rightt">

                                <span>${{number_format(abs($sum-$ex_sum),2)}}</span>
                            </div>
                        </div>

                    @endif
                    <div class="product__button_flex">
                        <div class="producct__one_div">
                            <div class="btn_product_main btn_product_main_one">
                                <button type="button" onclick="go_back()">Go Back</button>
                            </div>
                        </div>
                        <?php
                        $order_name = str_replace('#', '', $order->order_name);
                        ?>
                        <div class="producct__second_div">
                            <div class="btn_product_main btn_product_main_two">

                                <form id="submitForm" method="GET" action="https://{{$shop}}/a/return/customer/confirm/request">
                                    <input type="hidden" name="shop" value="{{\App\Models\User::find($order->shop_id)->name}}">
                                    <input type="hidden" name="order_name" value="{{$order_name}}">
                                    <input type="hidden" name="email" value="{{$order->email}}">
                                    <input type="hidden" name="sessiondata" value="{{json_encode($customsession)}}">
                                    <button type="submit">
                                        @if($r_sum==0 && $s_sum==0 && $ex_sum>0)
                                            Submit Exchange
                                        @else
                                            Submit Return
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
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
