@extends('layouts.admin')
@section('content')
    @include('inc.settings-nav')
    <div class="main-content" id="panel">
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Text</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('settings.home')}}">Settings</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Orders</li>
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

                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                    <!-- Pricing -->
                    <div class="card card-pricing border-0 text-center mb-4">
                        <div class="card-body text-left">
                            <div class="reasons_list">
                                <p class="card-text mb-2 text-left">
                                   You can see Total Orders here. You can Sync All orders by clicking on sync order button </p>
                            </div>


                                <div class="row">



                                    <div class="col-md-10">
                                        <div class="col-md-12 pl-3 pt-2">
                                            <div class="row ">
                                                <div class="col-md-6 col-lg-3 col-12 mb-2 col-sm-6" style="border-radius: 8px">
                                                    <div class="media shadow-sm   p-2 " style="background: lavender;">
                                                        <div class="media-body p-2">
                                                            <h4 class="media-title m-0">Total Orders</h4>
                                                            <div class="media-text">
                                                                <h3>{{$orders_count}}</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">

                                            <a href="{{url('syncOrders')}}"  class="btn btn-primary">Sync Orders</a>
                                        </div>
                                    </div>
                                </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.17.0/ui/trumbowyg.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.17.0/trumbowyg.min.js"></script>

    <script>
        // $('textarea').trumbowyg();
    </script>
@endsection

