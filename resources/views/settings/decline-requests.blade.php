@extends('layouts.admin')
@section('content')

    <div class="main-content">


        <div class="container-fluid">
            <div class="card my-5">
                <h4 class="card-header">
                    Decline Requests

                </h4>
                @if(count($decline_request) > 0 )

                    <div class="card-body">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>Return ID</th>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Requested</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach($decline_request as $request)
                                <tr>
                                    <td><a href="/requests/{{$request->id}}">#{{$request->id}}</a></td>
                                    <td><a href="/requests/{{$request->id}}">{{$request->has_order->order_name}}</a></td>
                                    <td>{{$request->has_order->email}}</td>
                                    <td>{{$request->created_at->format('d/m/Y')}}</td>
                                    <td><a href="{{route('request.delete',$request->id)}}">Delete</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                @else
                    <div class="card-body text-center pb-6 pt-6 pl-4 pr-4">
                        <i class="fa fa-sign-language" style="font-size: 60px;"></i>
                        <p class="mt-2">There are no Decline request at the moment.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
    @endsection
