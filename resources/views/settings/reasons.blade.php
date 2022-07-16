@extends('layouts.admin')
@section('content')
@include('inc.settings-nav')
<div class="main-content" id="panel">
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Return Reasons</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{route('settings.home')}}">Settings</a></li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Orders Detail - Return Reason</li>
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
                        <div class="custom_text_lists text-left">
                        <p class="card-text mb-2">
                            Build a consistent experience and customer trust by adding some reasons for Exchange/Return .
                            Incase if you will not add reasons then it will not be shown in Customer side

                        </p>

                            <div class="table-responsive mb-3">
                                <table class="table align-items-center table-flush">
                                    <tbody>
                                    @foreach($reasons as $reason)
                                        @if($reason->reason_type == 2)
                                    <tr>
                                        <td>
                                            {{$reason->name}}
                                        </td>
                                        <td>
                                            @if($reason->category)
                                            @if(strtolower($reason->category->name)=='refund')
                                            <span class="badge badge-primary">{{$reason->category->name}}</span>
                                            @else
                                                <span class="badge badge-success">{{$reason->category->name}}</span>
                                            @endif
                                            @endif
                                        </td>
                                        <td class="table-actions">
                                            <a href='{{url("/setting/$reason->id/reasons/edit")}}' class="mx-1 text-primary">
                                                <i class="fas fa-user-edit"></i>
                                            </a>
                                            <a href="{{url("/setting/$reason->id/reasons/delete")}}" class="mx-1 text-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <button type="button" class="btn btn-sm btn-primary" id="create_custom_reason">Add New Custom</button>
                        </div>
                        <div class="add_new_reason" @if($edit_reason == "")style="display:none;" @endif>
                            <hr/>
                            <p class="card-text mb-2 text-left">
                                Create a custom return reason to collect insights specific to your products. The reason Category allows you to compare your custom reason to industry benchmarks. This feature is currently in Beta and not yet available in your Analytics module or Rules engine. Please send us feedback!</p>
                            <form action="{{route('settings.reasons.new')}}" method="POST">
                                <input type="hidden" name="status" @if($edit_reason != "") value="update"@endif>
                                <input type="hidden" name="reason_id" @if($edit_reason != "") value="{{$edit_reason->id}}"@endif>

                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="category_id">Category</label>
                                            <select class="form-control" id="category_id" name="category_id">
                                                @foreach($categories as $category)
                                                    <option @if($edit_reason != "" && $edit_reason->category_id==$category->id  ){!! 'selected' !!} @endif value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="name">Return Reason</label>
                                            <input type="text" class="form-control" id="name" placeholder="" name="name" @if($edit_reason != "")
                                            value="{{$edit_reason->name}}" @endif>
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
</div>
<style>
    .premade_list_items  li {
        list-style: none;
    }

    .premade_list_items.text-left {
        column-count: 2;
    }
</style>
<script>
    $('#create_custom_reason').click(function(){
        $('.reasons_list').hide();
        $('.add_new_reason').show();
    });
</script>
@endsection
