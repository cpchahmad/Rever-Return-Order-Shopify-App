@extends('layouts.admin')
@section('content')
    @include('inc.settings-nav')
    <div class="main-content" id="panel">
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('settings.home')}}">Settings</a></li>
                                    <li class="breadcrumb-item active text-white" aria-current="page">Orders Detail - Refund Type</li>
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
                            <p class="card-text mb-2 text-left">
                               When a customer request to make an exchange, a text will appear prompting the customer to indicate the desire item they wish to receive in exchange.
                            </p>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5> Please enter the custom message that will show on the top of the exchange text box.</h5>
                                    <form method="POST" action="{{route('custom.text.save')}}">
                                    <div class=" col-md-6">

                                            @csrf
                                        <div class="form-group ">
                                            <label for="custom_text"> Default Text:</label>
                                            <input class="form-control" id="custom_text" type="text" name="custom_text" required

                                            @if($settings != null)
                                                value="{{$settings->exchange_text}}"
                                                @endif  placeholder="What item(s) would you like to receive in exchange?">
                                        </div>
                                        <button class="btn btn-primary btn-sm"> Save</button>
                                    </div>
                                    </form>
                                </div>

                            </div>




                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
