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
                                    <li class="breadcrumb-item active text-white" aria-current="page">Return Methods - Custom Methods</li>
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
                                <p class="card-text mb-1 text-left">
                                    In return Methods customers let you know how they would like to return their orders, this may be by sending their orders by post, a store drop-off or by asking you to pick it up from their home.
                                </p>
                            <p class="card-text mb-1 text-left">
                                No one size fits all applies to brands of any type. This is why all return methods can be customized.
                             </p>
                            <p class="card-text mb-1 text-left">
                                Why is there a price column here? This is the money you will deduct your customers for returning an order when you issue them with a refund. You must do this manually.
                            </p>

                        </div>

                        <div class="refunds_list" @if($edit_refund != "")style="display: none"@endif>
                        <div class="card-header border-0 text-left">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button id="add_new" href="#" class="btn btn-sm btn-neutral btn-round btn-icon" data-toggle="tooltip" data-original-title="Add New Refund Method">
                                        <span class="btn-inner--icon"><i class="fas fa-user-edit"></i></span>
                                        <span class="btn-inner--text">Add New</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                            @if(count($refunds)>0)
                                <div class="table-responsive p-2">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Edit</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($refunds as $refund)
                                            <tr>
                                                <td>
                                                    {{$refund->name}}
                                                </td>
                                                <td>
                                                    {{$refund->description}}
                                                </td>
                                                <td>
                                                    @if($refund->price == 0)
                                                        Free
                                                    @else
                                                  @if($shop_details != null && $shop_details->currency != null) {{ $shop_details->currency}}@endif{{$refund->price}}
                                                    @endif
                                                </td>
                                                <td class="table-actions">
                                                    <a href='{{url("/settings/$refund->id/edit/refund")}}' class="table-action" data-toggle="tooltip" data-original-title="Edit product">
                                                        <i class="fas fa-user-edit"></i>
                                                    </a>
                                                    <a href='{{url("/settings/$refund->id/delete/refund")}}' class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Delete product">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            @endif
                        </div>

                        <div class="add_new_refund"  @if($edit_refund == "")style="display: none"@endif>
                            <div class="card-header border-0 text-left">
                                <div class="row">
                                    <div class="col-6">
                                        <h3 class="mb-0">Add New Refund</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-left">
                                <form action="{{route('orders.refund.post')}}" method="POST">
                                    <input type="hidden" name="status" @if($edit_refund != "") value="update"@endif>
                                    <input type="hidden" name="refund_id" @if($edit_refund != "") value="{{$edit_refund->id}}"@endif>
                                    {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Name</label>
                                        <input type="text" class="form-control" name="name" @if($edit_refund != "")
                                        value="{{$edit_refund->name}}" @endif>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Description</label>
                                        <input type="text" class="form-control" name="description"@if($edit_refund != "")
                                        value="{{$edit_refund->description}}" @endif>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Price</label>
                                        <input type="text" class="form-control" name="price"@if($edit_refund != "")
                                        value="{{$edit_refund->price}}" @endif>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col">
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

    <script>
        $('#add_new').click(function(){
            $('.refunds_list').hide();
            $('.add_new_refund').show();
        });
    </script>
@endsection
