@extends('layouts.admin')
@section('content')
    @include('inc.settings-nav')
    <div class="main-content" id="panel">
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Email Editors</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('settings.home')}}">Settings</a></li>
                                    <li class="breadcrumb-item"><a href="{{route('email.workflow')}}">Email WorkFlows</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Email Editors</li>
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
                            <form action="{{route('editor.save')}}" method="POST">
                                {{csrf_field()}}
                            <div class="row">

                                <div class="col-12 mb-2">
                                    <h3>{{$title}}

                                    </h3>
                                </div>
                                <div class="col-12">

                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="example3cols1Input">Subject</label>
                                        <input type="text" class="form-control" id="example3cols1Input" name="{{$subject}}" value="{{$settings->$subject}}">
                                    </div>
                                </div>
                                <div class="col-12">
                                   <textarea id="trumbowyg-demo" name="{{$content}}">
                                              {{$settings->$content}}
                                        </textarea>
                                   </div>
                                <div class="col mt-4">
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.17.0/ui/trumbowyg.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.17.0/trumbowyg.min.js"></script>

    <script>
        $('#trumbowyg-demo').trumbowyg();
    </script>
    @endsection
