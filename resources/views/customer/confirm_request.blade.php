@extends('layouts.customer')

@section('css')
    <link rel="stylesheet" href="{{asset('css/print.css')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <style>
        .banner {
            background-image: none !important;
            height: 100%;
        }

        {{--body {--}}
        {{--    background: url("{{asset('images/Rectangle.png')}}") !important;--}}
        {{--    background-repeat: no-repeat;--}}
        {{--}--}}
        .fa-print:before {
            font-family: 'fontawesome';
        }
        .edit_link
        {
            display: inline-block;
            float: right;
        }
        .no-display
        {
            display: none;
        }
        .input_parent
        {
            width: 100%;
            position: relative;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        .input_parent .input_child_12
        {
            width: 100%;
            display: inline-block;
            padding: 7px 0px;
        }
        .input_parent .field_parent
        {
            margin: 0;
            padding: 0;
            font-family: Oakes-Regular !important;
            width: 100%;
            position: relative;
            box-sizing: border-box;
        }
        .field_parent input
        {

            padding: 15px 15px;
            border-radius: 31px;
            border: none;
            outline: none;
            font-size: 15px;
            border: 1px solid #9B9B9B;
            -webkit-border: 1px solid #9B9B9B;
            width: -webkit-fill-available;
            max-width: 100%;

        }
        .field_parent input::placeholder
        {
            font-size: 15px;
        }

    </style>
@endsection


@section('content')
    <div class="container">
        <div class="header">
            <a href="https://us.centricwear.com">
                <img src="{{asset('images/Group 26.svg')}}" alt="logo">
            </a>
        </div>
        <div class="main_products_all_section">
            <div class="heading_section">
                <h2>Your return has been submitted</h2>
            </div>
            <div class="main__print__section">
                <div class="prin_-one print_section">
                    {{--                    <form method="GET" action="{{proxy(route('print.label',['request_id'=>$request->id,'order_id'=>$request->order_id]))}}">--}}
                    <input type="hidden" name="shop_id" value="{{$request->shop_id}}">
                    <div class="first_main_print_section">
                        <div class="return__text_print">
                            <span>Return {{$request->id}}</span>
                        </div>

                        {{--                            @if($request->request_labels==null)--}}
                        <div class="print_label__main">
                            <h4>Your label is ready to print</h4>
                        </div>
                        <div class="prin__discription">
                            <p>Use the link below to print your label and attach it to the top of the package,then drop
                                it off at any USPS Location by {{strtoupper($date)}}.</p>
                        </div>

                        <div class="button__print">
                            <a @if($request->request_labels!==null) href="{{$request->request_labels->label}}"
                               @else href="#" @endif target="_blank">
                                <button type="button" class="print_btn">
                                    <i class="fa fa-print" aria-hidden="true"></i> Print Return Label
                                </button>
                            </a>
                        </div>
                        {{--                            @else--}}
                        {{--                                <div class="print_label__main">--}}
                        {{--                                    <h4>Your label is Printed</h4>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="prin__discription">--}}
                        {{--                                    <p>Use the link below to print your label and attach it to the top of the package,then drop it off at any USPS Location by 21 OCT 2020.</p>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="button__print">--}}
                        {{--                                    <button type="button" class="print_btn" onclick="download_label('{{$request->request_labels->tracking_code}}','{{$request->request_labels->label}}')">--}}
                        {{--                                        <i class="fa fa-download" aria-hidden="true"></i> Download Return Label--}}
                        {{--                                    </button>--}}
                        {{--                                </div>--}}
                        {{--                            @endif--}}
                    </div>
                    {{--                    </form>--}}
                    <div class="print_discription">
                        <span>A link to your shipping information have been emailed to {{$order->email}}</span>
                    </div>
                </div>
                <div class="prin_-two print_section">
                    <div class="info__shoping_items_print">
                        <div class="items__title">
                            <h4>How to ship your item(s)</h4>
                        </div>
                        <div class="listing__pring">
                            <ul>
                                <li>Securely pack items in original packaging.</li>
                                <li>Attach your return label to the package.</li>
                                <li>Drop off the package within 28 days to your nearest carrier location.</li>
                                <li>We’ll issue your refund, store credit, or exchange once we approve your return.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="prin_-three print_section">
                    <div class="main_print_product">
                        <div class="product_print_header">
                            <h4>Item(s) to send back</h4>
                        </div>
                        @foreach($items as $item)
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
                                        <span>${{number_format($item['price'],2)}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if(count($exchange_items))
                    <div class="prin_-three print_section">
                        <div class="main_print_product">
                            <div class="product_print_header">
                                <h4>Item(s) to expect</h4>
                            </div>
                            @foreach($exchange_items as $ex_item)
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
                                                            @foreach($ex_item['options'] as $opt)
                                                                @if($opt)
                                                                    <li>{{$opt}}</li>@endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="produt__price">
                                            <span>${{number_format($ex_item['price'],2)}}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form id="address_update" method="POST" action="{{proxy(route('address.update',$request->shipping_address->id))}}">
                    <div class="prin_-five print_section">
                        <div class="edit_print_info">
                            <div class="edit_flex">
                                <div class="edit_title">
                                    <h4>Customer information
                                        <div class="edit_link">
                                            <a href="">
                                                <span>EDIT</span>
                                            </a>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                            <div class="customer_editable_info">
                                <div class="email_print">
                                    <h6>Contact Info</h6>
                                    <span>{{$order->email}}</span>
                                </div>
                                <div class="Shipping_address_print">
                                    <?php
                                    $shipping_address = json_decode($order->order_json);
                                    ?>
                                    <h6>Shipping Address</h6>
                                    @if($request->shipping_address)
                                        <?php $shipping_address = $request->shipping_address;?>
                                        <ul>
                                            <li id="name">{{$shipping_address->first_name.' '.$shipping_address->last_name}}</li>
                                            <li id="address">{{$shipping_address->address1}}</li>
                                            <li id="city-zip-province">{{$shipping_address->city}} @if($shipping_address->province!=="")
                                                    , {{$shipping_address->province}}@endif
                                                , {{$shipping_address->zip}}</li>
                                            <li id="country">{{$shipping_address->country}}</li>
                                        </ul>

                                    @elseif(isset($shipping_address->shipping_address))
                                        <ul>
                                            <li>{{$shipping_address->shipping_address->first_name.' '.$shipping_address->shipping_address->last_name}}</li>
                                            <li>{{$shipping_address->shipping_address->address1}}</li>
                                            <li>{{$shipping_address->shipping_address->city}} @if($shipping_address->shipping_address->province!=="")
                                                    , {{$shipping_address->shipping_address->province}}@endif
                                                , {{$shipping_address->shipping_address->zip}}</li>
                                            <li>{{$shipping_address->shipping_address->country}}</li>
                                        </ul>
                                    @endif
                                </div>
                                <div class="no-display update_address">
                                    <div class="input_parent">
                                        <div class="input_child_12">
                                            <div class="field_parent">
                                                <input  @if($shipping_address!==null) value="{{$shipping_address->first_name}}" @endif type="text" name="first_name" class="input_field" placeholder="First Name">
                                            </div>
                                        </div>
                                        <div class="input_child_12">
                                            <div class="field_parent">
                                                <input  @if($shipping_address!==null) value="{{$shipping_address->last_name}}" @endif type="text" name="last_name" class="input_field" placeholder="Last Name">
                                            </div>
                                        </div>
                                        <div class="input_child_12">
                                            <div class="field_parent">
                                                <input  @if($shipping_address!==null) value="{{$shipping_address->address1}}" @endif type="text" name="address" class="input_field" placeholder="Address">
                                            </div>
                                        </div>
                                        <div class="input_child_12">
                                            <div class="field_parent">
                                                <input @if($shipping_address!==null) value="{{$shipping_address->city}}" @endif type="text" name="city" class="input_field" placeholder="City">
                                            </div>
                                        </div>
                                        <div class="input_child_12">
                                            <div class="field_parent">
                                                <input  @if($shipping_address!==null) value="{{$shipping_address->province}}" @endif type="text" name="state" class="input_field" placeholder="State">
                                            </div>
                                        </div>
                                        <div class="input_child_12">
                                            <div class="field_parent">
                                                <input @if($shipping_address!==null)  value="{{$shipping_address->zip}}" @endif type="text" name="zip" class="input_field" placeholder="Zip Code">
                                            </div>
                                        </div>
                                        <div class="input_child_12">
                                            <div class="field_parent">
                                                <input @if($shipping_address!==null)  value="{{$shipping_address->country}}" @endif type="text" name="country" class="input_field" placeholder="Country">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main_print_submit_btn">
                        <div class="print_submit_btn">
                            <button
{{--                                onclick="window.location.href='https://us.centricwear.com/a/return'" --}}
                                    type="submit">
                                Done
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        // function download_label(label)
        // {
        //     console.log(encodeURIComponent(label));
        //
        //     console.log(label);
        // }
        $(document).ready(function () {
            $('.edit_link a').on('click',function(event){
                event.preventDefault();
                if($('.update_address').hasClass('no-display'))
                {
                    $('.Shipping_address_print').addClass('no-display');
                    $('.update_address').removeClass('no-display');
                }else
                {
                    $('.update_address').addClass('no-display');
                    $('.Shipping_address_print').removeClass('no-display');
                }
            });

            $('#address_update').on('submit',function(event){
                event.preventDefault();
                $('button[type=submit]').html('<i class="fa fa-spinner fa-spin" style="font-family: FontAwesome !important;"></i>');
                $.ajax({
                    url:$(this).attr('action'),
                    type:$(this).attr('method'),
                    data:$(this).serialize(),
                    success:function(response)
                    {
                        $('#name').html(response.first_name+' '+response.last_name);
                        $('#name').html(response.first_name+' '+response.last_name);
                        $('#city-zip-province').html(response.city+', '+response.province+', '+response.zip);
                        $('#country').html(response.country);
                        $('#address').html(response.address1);
                        $('.update_address').addClass('no-display');
                        $('.Shipping_address_print').removeClass('no-display');
                        $('button[type=submit]').html('Done');

                    },
                    error:function(error)
                    {
                        $('.update_address').addClass('no-display');
                        $('.Shipping_address_print').removeClass('no-display');
                        $('button[type=submit]').html('Some thing went wrong');
                        setTimeout(function(){
                            $('button[type=submit]').html('Done');
                        },3000);
                    }
                });
            })

            $('.print_btn').on('click', function () {
                $(this).parent('a').click();
            })

        });

        function download_label(filename, label) {
            var element = document.createElement('a');
            element.setAttribute('href', label);
            element.setAttribute('download', filename);
            element.setAttribute('target', '_blank');
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        }


        function go_back() {
            window.history.back();
            {{--window.location.href="{{proxy(route('customer.login.post',['shop'=>$shop,'order_name'=>$order_name,'email'=>$order->email]))}}"--}}
        }
    </script>
@endsection
