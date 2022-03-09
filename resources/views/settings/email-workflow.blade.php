@extends('layouts.admin')
@section('content')
    @include('inc.settings-nav')
    <div class="main-content" id="panel">
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Emails Workflow</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('settings.home')}}">Settings</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Emails Workflow</li>
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
                                    Improve the customer journey during the return process. Transparency and clear communication are instrumental to a great experience.
                                    Edit and enable or disable the customer end emails that you would like them to receive after each one of the returns journey’s touch points.
                                     <br/>
                                    Use <?php echo '#{{return.number}}'?> for return number.
                                </p>
                            </div>

                            <form action="{{route('email.workflow.save')}}" method="POST">
                                {{csrf_field()}}
                            <div class="row">
                                <div class="col">
                                    <div class="tabs_wrapper mt-4">
                                        <div class="tabs_nav">
                                            <li class="active" data-tab="tab1">Requested</li>
                                            <li data-tab="tab2">Approved</li>
                                            <li data-tab="tab3">Received</li>
                                            <li data-tab="tab4">Finished</li>
                                        </div>

                                        <div class="tabs_content">
                                           <div class="tab_content" id="tab1" style="display: block;">

{{--                                                       <div class="custom-control custom-checkbox mb-3">--}}
{{--                                                           <input class="custom-control-input" id="r_1" type="checkbox" name="rq_customer" value="1" @if(!empty($settings) && $settings->rq_customer == 1) checked @endif >--}}
{{--                                                           <label class="custom-control-label" for="r_1">Send my customers an email when they request an return.</label>--}}
{{--                                                       </div>--}}
{{--                                                       <div class="custom-control custom-checkbox mb-3">--}}
{{--                                                           <input class="custom-control-input" id="r_2" type="checkbox" name="rq_admin" value="1" @if(!empty($settings) && $settings->rq_admin == 1) checked @endif>--}}
{{--                                                           <label class="custom-control-label" for="r_2">Send me an email when a return is requested.</label>--}}
{{--                                                       </div>--}}

{{--                                               <div class="text-left mt-2">--}}
{{--                                                   <button type="submit" class="btn btn-sm btn-primary mt4">Save</button>--}}
{{--                                               </div>--}}

                                               <div class="row mt-4">
                                                   <div class="col-md-6">
                                                       <div class="card">
                                                           <div class="card-header">
                                                               <h5 class="h4 mb-0">Request Created By Customer
                                                                   <label class="custom-toggle float-right">
                                                                       <input name="request_email" id="request-email" type="checkbox" value="1" @if($settings->request_email==true) checked="checked" @endif>
                                                                       <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                                   </label>
                                                               </h5>
                                                           </div>
                                                           <div class="card-body">
                                                               <p class="card-text mb-4">Customer this email when they request the return and is pending approval.</p>
                                                               <a href="{{route('editor')}}?type=rq_customer" class="btn btn-primary btn-sm">Edit</a>
                                                               <a href="{{route('send.test.email',0)}}" class="send_test btn btn-primary btn-sm">Send Test Email</a>
                                                           </div>
                                                       </div>
                                                   </div>

                                                   <div class="col-md-6">
                                                       <div class="card">
                                                           <div class="card-header">
                                                               <h5 class="h4 mb-0">Request  Denied By Admin
                                                                   <label class="custom-toggle float-right">
                                                                       <input name="deny_email" id="deny-email" type="checkbox" value="1" @if($settings->deny_email==true) checked="checked" @endif>
                                                                       <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                                   </label>
                                                               </h5>
                                                           </div>
                                                           <div class="card-body">
                                                               <p class="card-text mb-4">
                                                                   Customer this email when they request the return and is pending approval.
                                                               </p>
                                                               <a href="{{route('editor')}}?type=rq_admin" class="btn btn-primary btn-sm">Edit</a>
                                                               <a href="{{route('send.test.email',4)}}" class="send_test btn btn-primary btn-sm">Send Test Email</a>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>

                                           </div>
                                            <div class="tab_content" id="tab2">

{{--                                                <div class="custom-control custom-checkbox mb-3">--}}
{{--                                                    <input class="custom-control-input" id="a_1" type="checkbox" name="ap_customer_approved"  value="1" @if(!empty($settings) && $settings->ap_customer_approved == 1) checked @endif>--}}
{{--                                                    <label class="custom-control-label" for="a_1">Send my customers an email when their return request is approved</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="custom-control custom-checkbox mb-3">--}}
{{--                                                    <input class="custom-control-input" id="r_3" type="checkbox" name="ap_customer_rejected" value="1" @if( !empty($settings) && $settings->ap_customer_rejected == 1) checked @endif>--}}
{{--                                                    <label class="custom-control-label" for="r_3">Send my customers an email when their return request is rejected</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="text-left mt-2">--}}
{{--                                                    <button type="submit" class="btn btn-sm btn-primary mt4">Save</button>--}}
{{--                                                </div>--}}

                                                <div class="row mt-4">
                                                    <div class="col-md-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="h4 mb-0">Manual Approval: Return  Approval
                                                                    <label class="custom-toggle float-right">
                                                                        <input name="approve_email" id="approve-email" type="checkbox" value="1" @if($settings->approve_email==true) checked="checked" @endif>
                                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                                    </label>
                                                                </h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <p class="card-text mb-4">This email is sent to your customers when their return request is approved.</p>
                                                                <a href="{{route('editor')}}?type=ap_customer_approval" class="btn btn-primary btn-sm">Edit</a>
                                                                <a href="{{route('send.test.email',1)}}" class="send_test btn btn-primary btn-sm">Send Test Email</a>
                                                            </div>
                                                        </div>
                                                    </div>

{{--                                                    <div class="col-md-4">--}}
{{--                                                        <div class="card">--}}
{{--                                                            <div class="card-header">--}}
{{--                                                                <h5 class="h4 mb-0">Manual Approval: Return Rejected</h5>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="card-body">--}}
{{--                                                                <p class="card-text mb-4">--}}
{{--                                                                    This email is sent to your customers when you have rejected their return request.--}}
{{--                                                                </p>--}}
{{--                                                                <a href="{{route('editor')}}?type=ap_customer_rejected" class="btn btn-primary btn-sm">Edit</a>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
                                                </div>
                                            </div>
                                            <div class="tab_content" id="tab3">
{{--                                                <div class="custom-control custom-checkbox mb-3">--}}
{{--                                                    <input class="custom-control-input" id="rr_1" type="checkbox" name="rc_customer_product"  value="1" @if(!empty($settings) && $settings->rc_customer_product == 1) checked @endif>--}}
{{--                                                    <label class="custom-control-label" for="rr_1">Send my customers an email when their return product is received.</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="text-left mt-2">--}}
{{--                                                    <button type="submit" class="btn btn-sm btn-primary mt4">Save</button>--}}
{{--                                                </div>--}}

                                                <div class="row mt-4">
                                                    <div class="col-md-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="h4 mb-0">Package Received
                                                                    <label class="custom-toggle float-right">
                                                                        <input name="received_email" id="received-email" type="checkbox" value="1" @if($settings->received_email==true) checked="checked" @endif>
                                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                                    </label>
                                                                </h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <p class="card-text mb-4">This email is a status update sent to your customers when you mark their package as received.</p>
                                                                <a href="{{route('editor')}}?type=rc_customer_product" class="btn btn-primary btn-sm">Edit</a>
                                                                <a href="{{route('send.test.email',2)}}" class="send_test btn btn-primary btn-sm">Send Test Email</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab_content" id="tab4">
{{--                                                <div class="custom-control custom-checkbox mb-3">--}}
{{--                                                    <input class="custom-control-input" id="rrr_1" type="checkbox" name="rf_customer_product"  value="1" @if(!empty($settings) && $settings->rf_customer_product == 1) checked @endif>--}}
{{--                                                    <label class="custom-control-label" for="rrr_1">Send my customers an email when their return is fully processed</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="text-left mt-2">--}}
{{--                                                    <button type="submit" class="btn btn-sm btn-primary mt4">Save</button>--}}
{{--                                                </div>--}}

                                                <div class="row mt-4">
                                                    <div class="col-md-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="h4 mb-0">Refund Issued
                                                                    <label class="custom-toggle float-right">
                                                                        <input name="finished_email" id="finished-email" type="checkbox" value="1" @if($settings->finished_email==true) checked="checked" @endif>
                                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                                    </label>
                                                                </h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <p class="card-text mb-4">This confirmation email is sent to your customers when their return is refunded on their original payment method.</p>
                                                                <a href="{{route('editor')}}?type=rf_customer_product" class="btn btn-primary btn-sm">Edit</a>
                                                                <a href="{{route('send.test.email',3)}}" class="send_test btn btn-primary btn-sm">Send Test Email</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6" style="display:none;">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="h4 mb-0">Exchange Completed</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <p class="card-text mb-4">
                                                                    This confirmation email is sent to your customers when you have marked their exchange as processed. Make sure to update them with the tracking information of their new item.
                                                                </p>
                                                                <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

@section('script')
    <script>
        $(document).ready(function(){
            $('.send_test').on('click',function(event){
                event.preventDefault();
                $.get($(this).attr('href'),function(response){
                    console.log(response);
                });
            });
            $('.custom-toggle input').on('input',function(){

                $.ajax({
                    type:'POST',
                    url:"{{route('email.flow.update')}}",
                    data:$('.custom-toggle input').serialize(),
                    success:function(response){
                        console.log(response);
                    },
                    error:function (error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection
