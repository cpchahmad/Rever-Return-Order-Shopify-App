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
                                    <li class="breadcrumb-item active text-white" aria-current="page">Return Label - Mail</li>
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
                            <p class="card-text mb-5 text-left">
                                The Mail is an automatic mail to send up the returns process on your end and help your customers understand what to do next.
                                At the end of the returns request process, as well as on the status page, customers will be able to download a .PDF document with the information below as well as confirmation details about their return.
                                <br/>
                                Use <?php echo '#{{tracking_code}}'?> for tracking Code Link
                                <br/>
                                Use <?php echo '#{{print}}'?> for print label button
                                <br/>
                                Use <?php echo '#{{created_at}}'?> for request creation date
                                <br/>
                                Use <?php echo '#{{expired_at}}'?> for request expire date
                            </p>

                            <div class="row">

                                <div class="col-md-12">
                                    <form method="post" action="{{route('confirmation.save')}}">
                                        @csrf
                                        <div class="tabs_wrapper mt-4">
                                            <div class="tabs_nav">
                                                <li class="active" data-tab="tab1">Format</li>
                                            </div>

                                            <div class="tabs_content">

                                                <div class="tab_content" id="tab1" style="display: block;">
                                                    <h3> Please enter your Subject Here:</h3>
                                                    <input @if($settings != null && $settings->label_subject != null)
                                                           value="{{$settings->label_subject}}"
                                                           @endif required type="text" name="subject" class="form-control col-md-12">
                                                    <br/>
                                                    <h3> Please enter your Message Here:</h3>
                                                    <textarea required class="col-md-12 trumbowyg-demo"    name="message" rows="6" placeholder="Header">
                                                        @if($settings != null && $settings->label_message != null)
                                                            {{$settings->label_message}}
                                                            @endif
                                                    </textarea>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <button type="submit" class="btn btn-sm btn-primary mt4">Save</button>
                                            <button type="button" data-href="{{route('send.test.label','confirm')}}" class="send_test btn btn-sm btn-primary mt4 mx-3">Send Test Mail</button>
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

@section('script')
    <script>
        $(document).ready(function(){
            $('.send_test').on('click',function(event){
                $.get($(this).attr('data-href'),function(response){
                    console.log(response);
                });
            });
        });
    </script>
@endsection
