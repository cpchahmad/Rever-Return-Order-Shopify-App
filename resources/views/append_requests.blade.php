@if(count($requests) > 0 )

    <table class="table align-items-center table-flush">
        <thead class="thead-light">
        <tr>
            <th>Return ID</th>
            <th>Order</th>
            <th>Customer</th>
            <th>Requested</th>
            {{--                                <th>--}}
            {{--                                    <div class="dropdown">--}}
            {{--                                        <h5 style="font-size: 14px;color: #8898aa;" class="m-0 dropdown-toggle"--}}
            {{--                                            type="button" id="dropdownMenuButton" data-toggle="dropdown"--}}
            {{--                                            aria-haspopup="true" aria-expanded="false">--}}
            {{--                                            Type--}}
            {{--                                        </h5>--}}
            {{--                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">--}}
            {{--                                            @if(count($return_types)>0)--}}
            {{--                                                @foreach($return_types as $type)--}}
            {{--                                                    <a class="dropdown-item"--}}
            {{--                                                       href="{{route('filtration').'?type='.$type->id.'&status='.$current_status}}"> {{$type->return_type}}</a>--}}

            {{--                                                @endforeach--}}
            {{--                                            @endif--}}

            {{--                                        </div>--}}
            {{--                                    </div>--}}
            {{--                                </th>--}}
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
            <th>Package Status</th>
            {{--                                <th>Tracking Code</th>--}}
            <th>Action</th>
        </tr>
        </thead>
        <tbody class="list">

        @foreach($requests as $request)
            <tr>
                <td><a href="/requests/{{$request->id}}">#{{$request->id}}</a></td>
                <td><a href="/requests/{{$request->id}}">{{$request->has_order->order_name}}</a>
                </td>
                <td>{{$request->has_order->email}}</td>
                <td>{{$request->created_at->format('d/m/Y')}}</td>
                <?php $request_products = json_decode($request->product);
                //                                    $payments = json_decode($request->payment_id);?>
                <?php
                $methods=json_decode($request->items_json,true);
                $method_str=[];
                foreach ($methods as $method)
                {
                    $string=ucwords(str_replace('_',' ',$method['return_type']));
                    array_push($method_str,$string);
                }
                $method_str=array_unique($method_str);
                asort($method_str);
                ?>
                <td><b>@foreach($method_str as $method_str) {{$method_str}}<br/>@endforeach</td>
                <td>
                    @if(isset($request->request_labels->status))
                        @if($request->request_labels->status=='delivered')
                            <span
                                class="badge badge-success">{{strtoupper(str_replace('_',' ',$request->request_labels->status))}}</span>
                        @elseif($request->request_labels->status=='in_transit')
                            <span
                                class="badge badge-danger">{{strtoupper(str_replace('_',' ',$request->request_labels->status))}}</span>
                        @else
                            <span
                                class="badge badge-primary">{{strtoupper(str_replace('_',' ',$request->request_labels->status))}}</span>
                        @endif
                    @endif
                </td>
                {{--                                    <td><span class="badge badge-sm badge-success">{{$payments->name}}</span></td>--}}
                {{--                                    <td>@if($request->request_labels)<a target="_blank" href="https://www.google.com/search?q={{$request->request_labels->tracking_code}}">{{$request->request_labels->tracking_code}}</a> @endif</td>--}}
                <td>
                    <a href="/requests/{{$request->id}}">Open</a>
                    @if($request->status==4)
                        <a class="text-danger ml-2" href="{{route('request.delete',$request->id)}}">Delete</a>
                    @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

@else
    <div class="card-body text-center pb-6 pt-6 pl-4 pr-4">
        <i class="fa fa-sign-language" style="font-size: 60px;"></i>
        <p class="mt-2">Great job, there are no return requsest at the moment.</p>
    </div>
@endif
