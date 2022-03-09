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
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i
                                                class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('settings.home')}}">Settings</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Email-Expired</li>
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
                                    The system will send all email as reminder to customer to drop the package at
                                    EasyPost Location immediately.
                                    Please note that for legal reasons, all customer emails will be sent from our
                                    servers.
                                    <br/>
                                    Use <?php echo '#{{tracking_code}}'?> for tracking Code Link
                                    <br/>
                                    Use <?php echo '#{{print}}'?> for print label button
                                    <br/>
                                    Use <?php echo '#{{created_at}}'?> for request creation date
                                    <br/>
                                    Use <?php echo '#{{expired_at}}'?> for request expire date
                                </p>
                            </div>

                            <form action="{{route('email.expired.save')}}" method="POST">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">Subject</label>
                                            <input type="text" class="form-control" id="example3cols1Input"
                                                   name="subject"
                                                   @if(!empty($settings)) value="{{$settings->label_expired_subject}}" @endif>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols2Input">Body</label>
                                            <textarea name="body" class="form-control"
                                                      rows="5">@if(!empty($settings)){{$settings->label_expired_body}}@endif</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-left mt-2">
                                        <button type="submit" class="btn btn-sm btn-primary mt4">Save</button>
                                        <button type="button" data-href="{{route('send.test.label','expire')}}" class="send_test btn btn-sm btn-primary mt4 mx-3">Send Test Mail</button>

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
        $('textarea').trumbowyg();
        $(document).ready(function(){
            $('.send_test').on('click',function(event){
                $.get($(this).attr('data-href'),function(response){
                    console.log(response);
                });
            });
        });
    </script>
@endsection
