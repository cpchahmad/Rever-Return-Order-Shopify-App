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
                              Return Type allow customers to specify what they want, whether isa a refund and exchange, store credit or any thing else.
                            </p>

                            @if(empty($edit_type))
                                <div class="row">
                                    <div class="col-md-12">
{{--                                        @if(count($built_types) >0)--}}
{{--                                            <form method="POST" action="{{route('built.return.type.save')}}">--}}
{{--                                                @csrf--}}
{{--                                                <ul class="list-unstyled">--}}
{{--                                                    @foreach($built_types as $built_type)--}}
{{--                                                        <li>--}}
{{--                                                            <div class="custom-control custom-checkbox mr-sm-2">--}}
{{--                                                                <input type="checkbox" name="built_type[]" class="custom-control-input" value="{{$built_type->id}}" id="built_{{$built_type->id}}"--}}
{{--                                                                @if(count($selected) > 0)--}}
{{--                                                                    @foreach($selected as $select)--}}
{{--                                                                        @if($select->return_assigning ==$built_type->id  )--}}
{{--                                                                            {!! 'checked' !!}--}}
{{--                                                                            @endif--}}
{{--                                                                        @endforeach--}}
{{--                                                                    @endif--}}
{{--                                                                >--}}
{{--                                                                <label class="custom-control-label" for="built_{{$built_type->id}}">{{$built_type->return_type}}</label>--}}
{{--                                                            </div>--}}
{{--                                                        </li>--}}
{{--                                                    @endforeach--}}
{{--                                                </ul>--}}
{{--                                                <button class="btn btn-primary btn-sm" type="submit"> Save</button>--}}
{{--                                            </form>--}}

{{--                                        @endif--}}


                                    </div>

                                </div>

                                <div class="row mt-5 border-top">
                                    <div class="col-md-12 mt-3">
                                        <h2> Your Custom Types</h2>
                                        <div class="custom_types">
                                            @if(count($custom_types)> 0)
                                                <div class="col-md-8 ">
                                                    @foreach($custom_types as $c_type)

                                                        <div class="d-flex justify-content-between">
                                                            <h5> {{$c_type->return_type}}</h5>
                                                            <div>
                                                                <a href='{{url("/order/$c_type->id/type/edit")}}' class="table-action" data-toggle="tooltip" data-original-title="Edit">
                                                                    <i class="fas fa-user-edit"></i>
                                                                </a>
                                                                <a href="{{url("/order/$c_type->id/type/delete")}}" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Delete">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>

                                                            </div>
                                                        </div>


                                                    @endforeach
                                                </div>

                                            @endif
                                            <button class="btn btn-primary btn-sm show_custom_add mt-2"> Add new Custom</button>
                                        </div>
                                        <div class="show_custom_add_form" style="display: none">
                                            <form method="POST" action="{{route('orders.return.type.save')}}">
                                                @csrf
                                                <div class="form-group col-md-6">
                                                    <label for="custom_type"> Type</label>
                                                    <input class="form-control" type="text" name="type" required>
                                                </div>
                                                <button class="btn btn-primary btn-sm ml-3" type="submit"> Save</button>
                                            </form>

                                        </div>


                                    </div>

                                </div>
                                @else
                                <div class="" >
                                    <form method="POST" action="{{route('return.type.edited')}}">
                                        @csrf
                                        <input type="hidden" name="type_id" value="{{$edit_type->id}}">
                                        <div class="form-group col-md-6">
                                            <label for="custom_type"> Type</label>
                                            <input class="form-control" type="text" name="type" value="{{$edit_type->return_type}}" required>
                                        </div>
                                        <button class="btn btn-primary btn-sm ml-3" type="submit"> Save</button>
                                    </form>

                                </div>

                                @endif



                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function(){

$('.show_custom_add').click(function(){

    $('.show_custom_add').css('display','none');
    $('.custom_types').css('display','none');
        $('.show_custom_add_form').css('display','block');

})

        });
    </script>
@endsection


