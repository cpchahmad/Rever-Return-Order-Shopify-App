
<html>

<body>
<head>
<style>

    #products {
        padding: 25px;
    }
</style>
</head>

@if(!empty($content))


<div id="main">
    <div id="container">
        <?php         $products_json = json_decode($content['request']->has_order->products_json, true); ?>
        <header> <h3 align="center">{!! $content["content"] !!}</h3></header>
            <div align="center">
                <table width="50%">
                    <tbody>
                    <div id="products">
                        @foreach( $content['all_products'] as $a_product)
                            @foreach( $content['selected_products'] as $s_product)
                                @if($s_product['id'] == $a_product['id'])
                                    <div class="row">
                                        <tr>
                                            <td align="center">
                                                <div class="col-md-3 align-middle">
                                                    @foreach($products_json as $image)
                                                        @if($image['id'] == $a_product['variant_id'])
                                                            <img style="max-width: 70px;" src="{{$image['image']}}">
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td  align="center">
                                                <div class="col-md-9 align-middle">
                                                    <b> {{$a_product['title']}}</b>  x   {{$s_product['quantity']}}
                                                </div>
                                                <div>
                                                    {{$a_product['variant_title']}}
                                                </div>
                                                <div>
                                                    Reason :  {{$s_product['reason']}}
                                                </div>

                                            </td>

                                        </tr>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                    </tbody>
                </table>
                        <table width="40%">
                            <tbody>
                            <tr><td>                    <h4> Order Details:</h4>
                                </td></tr>
                            <tr>
                                <td>  Order # :</td>
                                <td>{{$content['request']->has_order->order_name}}</td>
                            </tr>
                            <tr>
                                <td>  Cstomer :</td>
                                <td> {{$content['request']->has_order->email}}</td>
                            </tr>
                            <tr>
                                <td>  Amount : </td>
                                <?php $payments=json_decode($content['request']->payment_id);?>
                                <td>@if($content['shop'] != null && $content['request']->currency != null )
                                        {{$content['shop']->currency}}@endif{{$payments->name}}</td>
                            </tr>
                            </tbody>
                            <hr>
                        </table>
                @if($content['request']->request_pdf != null && $content['request']->status == "1" )
                    <div>
                        <a href='{{url($content['request']->request_pdf)}}'>Download Application Details</a>

                    </div>
                    @endif


            </div>


    </div>
</div>




@endif
</body>
</html>
