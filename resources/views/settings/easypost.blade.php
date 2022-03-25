@extends('layouts.admin')
@section('content')
    @include('inc.settings-nav')
    <div class="main-content" id="panel">
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Easy Post Integration</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i
                                                class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('settings.home')}}">Settings</a></li>
                                    <li class="breadcrumb-item active text-white" aria-current="page">Easy Post Integration
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt--6">
            <div class="row card-wrapper">
                <div class="col-lg-12">
                    <!-- Pricing -->
                    <div class="card card-pricing border-0 text-center mb-4">
                        <div class="card-body text-left">
                            {{--                            <div class="reasons_list">--}}
                            {{--                                <p class="card-text mb-2 text-left">--}}
                            {{--                                    To protect your Application from shady customers that wants to trick your store, tag--}}
                            {{--                                    their emails to block them.--}}
                            {{--                                    <br/>--}}
                            {{--                                    Customer Email tags(comma separated list) that will mark customer not as eligible for--}}
                            {{--                                    return:--}}
                            {{--                                </p>--}}
                            {{--                            </div>--}}



                            <form action="{{route('easypost.update')}}" method="POST" >
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label  for="name">API Key:</label>
                                            <input required type="text" @if($easy_post) value="{{$easy_post->api_key}}"  @endif class="form-control"  id="api_key"  name="api_key" >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label  for="name">API Secret Key:</label>
                                            <input required type="text" @if($easy_post) value="{{$easy_post->api_secretkey}}"  @endif class="form-control"  id="api_key"  name="api_secretkey" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label  for="name">Name:</label>
                                            <input required type="text" @if($easy_post) value="{{$easy_post->name}}"  @endif class="form-control"  id="name"  name="name" >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label  for="name">Country:</label>
                                            <input required type="text" @if($easy_post) value="{{$easy_post->country}}"  @endif class="form-control"  id="name"  name="country" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label  for="name">City:</label>
                                            <input required type="text" @if($easy_post) value="{{$easy_post->city}}"  @endif class="form-control"  id="city"  name="city" >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label  for="name">ISO State Code (2 digit):</label>
                                            <input required type="text" @if($easy_post) value="{{$easy_post->state}}"  @endif class="form-control"  id="state"  name="state" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label  for="name">Zip Code:</label>
                                            <input required type="text" @if($easy_post) value="{{$easy_post->zip}}"  @endif class="form-control"  id="zip"  name="zip" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label  for="name">Phone:</label>
                                            <input required type="text" @if($easy_post) value="{{$easy_post->phone}}"  @endif class="form-control"  id="phone"  name="phone" >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label  for="name">Address:</label>
                                            <textarea required type="text" @if($easy_post) value="{{$easy_post->street1}}"  @endif class="form-control"  id="street1"  name="street1" >@if($easy_post) {{$easy_post->street1}}  @endif</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-left mt-3">
                                        <button type="submit" class="btn btn-sm btn-primary mt4">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .premade_list_items li {
            list-style: none;
        }

        .premade_list_items.text-left {
            column-count: 2;
        }
    </style>
@endsection
