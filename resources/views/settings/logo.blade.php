@extends('layouts.admin')
@section('content')
    @include('inc.settings-nav')
    <div class="main-content" id="panel">
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Logo</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i
                                                class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('settings.home')}}">Settings</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Logo</li>
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
                                    Build a consistent experience and customer trust by uploading your logo. It will be
                                    used to brand the emails that are sent out. For the geeky stuff, please note that
                                    our servers prefer a PNG file, with a transparent background, and an optional width
                                    of 250px.
                                </p>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <a href="https://{{auth()->user()->name}}/a/return/order" type="button" style="float: right" target="_blank">Preview
                                    <i class="fa fa-link"></i>
                                    </a>

                                </div>
                            </div>

                            <div class="row mt-4 mb-4">
                                <div class="col-md-6">
                                    @if($settings)
                                        @if($settings ->logo != null)
                                            <img style="width: 100%;" src="{{asset('/logos/'.$settings->logo)}}">
                                        @else
                                            No Logo.
                                        @endif

                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @if($settings)
                                        @if($settings ->background != null)
                                            <img style="width: 100%;" src="{{asset('/logos/'.$settings->background)}}">
                                        @else
                                            No Logo.
                                        @endif

                                    @endif
                                </div>
                            </div>


                            <form action="{{route('settings.logo.post')}}" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mt-2 mb-2">Choose Logo</p>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFileLang" name="logo"
                                                   lang="en">
                                            <label class="custom-file-label file-name" for="customFileLang">Select
                                                Logo</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mt-2 mb-2">Choose Background</p>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="background"
                                                   name="background" lang="en">
                                            <label class="custom-file-label file-name" for="background">Select
                                                Background</label>
                                        </div>
                                    </div>
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
