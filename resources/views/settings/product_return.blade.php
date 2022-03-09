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
                                    <li class="breadcrumb-item active text-white" aria-current="page">General - Product Return Methods</li>
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
                                    Add tags of products so that only methods can be applied to that specific product.
                                    Add comma seperated values.
                                </p>
                            </div>



                            <form action="{{route('product.return.save')}}" method="POST" >
                                {{csrf_field()}}
                                <div class="row my-5">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label  for="block_tags">Store Credit:</label>
                                            <input type="text" class="form-control" data-role="tagsinput" id="block_tags" @if($settings != null && $settings->store_product_tags != null ) value="{{$settings->store_product_tags}}" @endif name="store_product_tags" >
                                        </div>
                                        <div class="form-group">
                                            <label  for="block_tags">Payment Method:</label>
                                            <input type="text" class="form-control" data-role="tagsinput" id="block_tags" @if($settings != null && $settings->payment_product_tags != null ) value="{{$settings->payment_product_tags}}" @endif name="payment_product_tags" >
                                        </div>
                                        <div class="form-group">
                                            <label  for="block_tags">Exchange:</label>
                                            <input type="text" class="form-control" data-role="tagsinput" id="block_tags" @if($settings != null && $settings->exchange_product_tags != null ) value="{{$settings->exchange_product_tags}}" @endif name="exchange_product_tags" >
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


@endsection
