@extends('layouts.touchscreen.app')
@section('home-bg', 'home-bg')

@section('content')

@php
if (Session::get('show_video') != 1) {
$style = 'style=display:none';
}else {
$style = '';
}

$checkedStatus = ((Session::get('locale') == 'bn') ? "checked" : "");
@endphp

<div class="switch">
    <input id="language-toggle" name="language-toggle" class="check-toggle check-toggle-round-flat" type="checkbox" onclick="switchLanguage()" {{$checkedStatus}}>
    <label for="language-toggle"></label>
    <span class="on">EN</span>
    <span class="off">বাংলা</span>
</div>

<div class="container">
    <div class="content-conainer">
        <div class="right_side_box">
            <div class="dashboard-btn-list">
                <a href="{{ route('verification') }}" class=" dashboard-btn-item btn btn-lg btn-primary waves-effect waves-light" role="button" style="background-color: orangered; border:none" aria-pressed="true">{{__('landing-page.dashboard.customer')}}</a>
                <a href="{{ route('deliveryman.login') }}" class=" dashboard-btn-item btn btn-lg btn-primary waves-effect waves-light" role="button" style="background-color: orangered; border:none" aria-pressed="true">{{__('landing-page.dashboard.rider')}}</a>
                <div class="maintenance">
                    <a href="{{ route('login') }}">Maintenance</a>
                    <!-- <a href="{{ route('login') }}">Admin Login</a> -->
                </div>
                <div class="help-btn" {{ $style }}>
                    <a href="#" class="btn btn-lg p-0" role="button" title="{{__('landing-page.button.help.label')}}" tabindex="0" data-plugin="tippy" data-tippy-touchHold="true" onclick="showHelpVideo()"><span style="font-size:15px;color:orangered"> {{__('landing-page.button.help.label')}} </span><i class="fas fa-info-circle" style="color:orangered"></i></a>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('slider-page') }}" class="win7-btn back-btn btn btn-lg" role="button">{{__('landing-page.button.back')}}</a>

    @endsection

    @section('custom-js')
    <script>
        function switchLanguage() {
            let resource = '/switch-language';
            let urlEndpoint = window.location.origin + resource;
            var locale;

            if (document.getElementById('language-toggle').checked) {
                locale = 'bn';
            } else {
                locale = 'en';
            }

            $.ajax({
                    type: 'POST',
                    dataType: "json",
                    url: urlEndpoint,
                    timeout: 2000,
                    retries: 1,
                    headers: {
                        "appKey": "{{ env('APP_KEY') }}",
                        "secretKey": 'secretKey',
                    },
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "language": locale
                    },
                })
                .done(function(data) {
                    window.location.reload();
                })
                .fail(function(data) {
                    console.log('Faild Block');
                });


        }
    </script>
    @endsection