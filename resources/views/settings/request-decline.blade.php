@extends('layouts.admin')
@section('content')
    @include('inc.settings-nav')
    <div class="main-content" id="panel">
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
{{--                            <h6 class="h2 text-white d-inline-block mb-0">Emails Workflow</h6>--}}
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('settings.home')}}">Settings</a></li>
                                    <li class="breadcrumb-item active text-white" >General - Request Keeping</li>
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
                                    Please specify what would you like to do with requests.
                                </p>
                            </div>

                            <form action="{{route('request.decline.setting.save')}}" method="POST" id="request_settings">
                                {{csrf_field()}}

                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h4>Exclude non-US orders.</h4>
                                        <div class="">
                                            <label class="custom-toggle" >
                                                <input name="exclude_non_us_order" id="exclude-non" type="checkbox" value="1"
                                                @if($r_settings != null && $r_settings->exclude_non_us_order == true)
                                                    {!! 'checked' !!}
                                                    @endif
                                                >
                                                <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                            </label>
                                        </div>


                                    </div>
{{--                                    <div class="d-flex justify-content-between mb-2">--}}
{{--                                        <h4>Automatically approve pending request.</h4>--}}
{{--                                        <div class="">--}}
{{--                                            <label class="custom-toggle" >--}}
{{--                                                <input name="auto_approval" id="auto-approve" type="checkbox" value="1"--}}
{{--                                                @if($r_settings != null && $r_settings->auto_approval == true)--}}
{{--                                                    {!! 'checked' !!}--}}
{{--                                                    @endif--}}
{{--                                                >--}}
{{--                                                <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}


{{--                                    </div>--}}
                                    <div class="d-flex justify-content-between">

                                        <h4>Delete declined requests manually</h4>
                                        <div class="">
                                            <label class="custom-toggle" >
                                                <input name="decline" id="manual-decline" type="checkbox" value="0"
                                                @if($r_settings != null && $r_settings->decline_status == '0')
                                                    {!! 'checked' !!}
                                                    @endif
                                                    >
                                                <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                            </label>
                                        </div>


                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h4> Delete declined requests automatically</h4>
                                        <label class="custom-toggle">
                                            <input name="decline" type="checkbox" id="auto-decline" value="1"
                                            @if($r_settings != null && $r_settings->decline_status == '1')
                                                {!! 'checked' !!}
                                                @endif>
                                            <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                        </label>
                                    </div>
                                    <div class="d-flex">
                                        <ul class="list-unstyled">
                                            <li> <input type="radio" class="mr-3 decline" name="decline-time" value="1"
                                                @if($r_settings != null && $r_settings->decline_month == '1')
                                                    {!! 'checked' !!}
                                                    @endif> 1 month</li>
                                            <li> <input type="radio" class="mr-3 decline"  name="decline-time" value="3"
                                                @if($r_settings != null && $r_settings->decline_month == '3')
                                                    {!! 'checked' !!}
                                                    @endif> 3 month</li>
                                            <li> <input type="radio" class="mr-3 decline" name="decline-time" value="6"
                                                @if($r_settings != null && $r_settings->decline_month == '6')
                                                    {!! 'checked' !!}
                                                    @endif> 6 month</li>
{{--                                            <li> <input type="radio" class="mr-3 decline"  name="decline-time" value="0"--}}
{{--                                                @if($r_settings != null && $r_settings->decline_month == '0')--}}
{{--                                                    {!! 'checked' !!}--}}
{{--                                                    @endif> Custom</li>--}}

                                        </ul>
                                    </div>

                                    <div class="d-flex justify-content-between">

                                        <h4> Delete finished requests manually</h4>
                                        <div class="">
                                            <label class="custom-toggle" >
                                                <input name="finished" type="checkbox" id="manual-finished" value="0"
                                                @if($r_settings != null && $r_settings->finish_status == '0')
                                                    {!! 'checked' !!}
                                                    @endif>
                                                <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                            </label>
                                        </div>


                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h4> Delete finished requests automatically</h4>
                                        <label class="custom-toggle">
                                            <input name="finished" type="checkbox" id="auto-finished" value="1"
                                            @if($r_settings != null && $r_settings->finish_status == '1')
                                                {!! 'checked' !!}
                                                @endif>
                                            <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                        </label>
                                    </div>
                                    <div class="d-flex">
                                        <ul class="list-unstyled">
                                            <li> <input type="radio"  class="mr-3 finished" name="finished-time" value="1"
                                                @if($r_settings != null && $r_settings->finish_month == '1')
                                                    {!! 'checked' !!}
                                                    @endif> 1 month</li>
                                            <li> <input type="radio" class="mr-3 finished" name="finished-time" value="3"
                                                @if($r_settings != null && $r_settings->finish_month == '3')
                                                    {!! 'checked' !!}
                                                    @endif
                                                > 3 month</li>
                                            <li> <input type="radio" class="mr-3 finished" name="finished-time" value="6"
                                                @if($r_settings != null && $r_settings->finish_month == '6')
                                                    {!! 'checked' !!}
                                                    @endif> 6 month</li>
{{--                                            <li> <input type="radio" class="mr-3 finished" name="finished-time" value="0"--}}
{{--                                                @if($r_settings != null && $r_settings->finish_month == '0')--}}
{{--                                                    {!! 'checked' !!}--}}
{{--                                                    @endif> Custom</li>--}}

                                        </ul>
                                    </div>
                                    <button class="btn btn-primary btn-sm" type="submit">save</button>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
