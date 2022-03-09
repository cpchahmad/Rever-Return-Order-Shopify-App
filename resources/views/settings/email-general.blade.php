@extends('layouts.admin')
@section('content')
    @include('inc.settings-nav')
    <div class="main-content" id="panel">
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Emails</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('settings.home')}}">Settings</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Emails</li>
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
                            <div class="reasons_list">
                                <p class="card-text mb-2 text-left">
                                    The system will send all email notifications to your customers during their return journey using the Sender Name and Sender Email below.
                                    Please note that for legal reasons, all customer emails will be sent from our servers using your email address below.  </p>
                            </div>

                            <form action="{{route('email.general.save')}}" method="POST">
                                {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="example3cols1Input">Sender Name</label>
                                        <input type="text" class="form-control" id="example3cols1Input" name="sender_name" @if(!empty($settings)) value="{{$settings->sender_name}}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="example3cols2Input">Sender Email</label>
                                        <input type="email" class="form-control" id="example3cols2Input" name="sender_email" @if(!empty($settings)) value="{{$settings->sender_email}}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="example3cols2Input">Receiver Email (for testing)</label>
                                        <input type="email" class="form-control" id="example3cols2Input" name="receiver_email" @if(!empty($settings)) value="{{$settings->receiver_email}}" @endif>
                                    </div>
                                </div>
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label class="form-control-label" for="example3cols1">Authenticated Username</label>--}}
{{--                                        <input type="text" class="form-control" id="example3cols1" name="sender_username" @if(!empty($settings)) value="{{$settings->sender_username}}" @endif>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label class="form-control-label" for="example3co">Password</label>--}}
{{--                                        <input type="text" class="form-control" id="example3co" name="sender_password" @if(!empty($settings)) value="{{$settings->sender_password}}" @endif>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="col-md-12 text-left mt-2">
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
@endsection
