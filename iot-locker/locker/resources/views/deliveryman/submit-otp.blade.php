@extends('layouts.touchscreen.app')
@section('home-bg', 'home-bg')

@section('custom-css')
<style>
    .login-cart {
        height: 100vh;
        margin: 0;
        position: absolute;
        top: 0;
        right: 0;
        width: 50vw;
        display: block !important;
    }
</style>
@endsection

@section('content')
<div class="account-pages">
    <div class="container">
        <div class="row justify-content-center mt-2">
            <div class="col-xl-7 col-md-7">
                <div class="page-title-box">
                    <div class="page-title">
                        <a href="{{ route('deliveryman.alternative-login') }}" class="win7-btn back-btn btn btn-lg btn-secondary btn-block waves-effect waves-light" role="button">{{__('send-otp-deliveryman.button.back')}}</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-md-5">
                <div class="card bg-pattern login-cart form-card">
                    <div class="card-header">
                        <div class="text-center w-75 m-auto">
                            <div class="auth-logo">
                                <a href="#" class="logo logo-dark text-center">
                                    <span class="logo-md">
                                        <span class="logo-lg-text-dark">{{__('send-otp-deliveryman.card.header.title')}}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 pb-2">
                        <form method="POST" action="{{ route('deliveryman.submit-otp') }}">
                            @csrf
                            <input type="hidden" name="contact_no" value="{{$contact_no}}">
                            <div class="mb-3">
                                <input class="form-control" type="text" id="otp" name="otp" value="{{old('otp') }}" placeholder="{{__('send-otp-deliveryman.input-field.otp.placeholder')}}" onfocus="myKeyboard(this)" autocomplete="off">
                            </div>
                            <div class="text-center d-grid">
                                <button class="btn win7-btn btn-lg btn-gray btn-secondary waves-effect waves-light" type="submit">{{__('send-otp-deliveryman.button.submit')}}</button>
                            </div>
                        </form>
                    </div>
                    <div id="keyboard_otp"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
    $(document).ready(function() {

        $('#keyboard_otp').jkeyboard({
            layout: "numbers_only",
            input: $('#otp')
        });
    });

    function myKeyboard(x) {
        if (x.id == 'otp') {
            $('#keyboard_otp').show();
        }
    }
</script>
@endsection