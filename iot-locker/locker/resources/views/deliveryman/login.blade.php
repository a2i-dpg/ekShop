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
        width: 60vw;
        display: block !important;
    }
</style>
@endsection

@section('content')
<div class="account-pages">
    <div class="container">
        <div class="row justify-content-center mt-2">
            <div class="col-xl-5 col-md-4">
                <div class="page-title-box">
                    <div class="page-title">
                        <a href="{{ route('fend.dashboard') }}" class="win7-btn back-btn btn btn-lg btn-secondary btn-block waves-effect waves-light" role="button">{{__('login-deliveryman.button.back')}}</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-md-8">
                <div class="card login-cart bg-pattern form-card">
                    <div class="card-header">
                        <div class="text-center w-75 m-auto pb-2">
                            <div class="auth-logo">
                                <a href="#" class="logo logo-dark text-center">
                                    <span class="logo-lg">
                                        <span class="logo-lg-text-dark">{{__('login-deliveryman.card.header.title')}}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-2">
                        <form method="POST" action="{{ route('deliveryman.login') }}">
                            @csrf
                            <div class="mb-3">
                                <!-- <label for="username" class="form-label">Username</label> -->
                                <input class="form-control" type="text" id="username" name="username" value="{{old('username') }}" placeholder="{{__('login-deliveryman.input-field.username.placeholder')}}" onfocus="myKeyboard(this)" autocomplete="off" autofocus>
                                <!-- <input class="form-control" type="text" id="username" name="username" value="01671479377" placeholder="{{__('login-deliveryman.input-field.username.placeholder')}}" onfocus="myKeyboard(this)" autocomplete="off"> -->
                            </div>
                            <div class="mb-3">
                                <!-- <label for="password" class="form-label">Password</label> -->
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" name="password" value="{{old('password') }}" class="form-control" placeholder="{{__('login-deliveryman.input-field.password.placeholder')}}" onfocus="myKeyboard(this)" autocomplete="off">
                                    <!-- <input type="password" id="password" name="password" value="12345678" class="form-control" placeholder="{{__('login-deliveryman.input-field.password.placeholder')}}" onfocus="myKeyboard(this)" autocomplete="off"> -->
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center d-grid">
                                <button class="win7-btn btn btn-lg  waves-effect waves-light" type="submit">{{__('login-deliveryman.button.login')}}</button>
                            </div>
                            <div class="text-md-end footer-links d-none d-sm-block mt-2">
                                <a href="{{ route('deliveryman.alternative-login') }}">{{__('login-deliveryman.button.alternative-login')}}</a>
                            </div>
                        </form>
                    </div>
                    <div id="keyboardusername"></div>
                    <div id="keyboardpassword"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
    $(document).ready(function() {

        $('#keyboardusername').jkeyboard({
            layout: "english",
            input: $('#username')
        });

        $('#keyboardpassword').jkeyboard({
            layout: "english",
            input: $('#password')
        });

        $('#keyboardpassword').hide();
    });

    function myKeyboard(x) {
        if (x.id == 'username') {
            $('#keyboardpassword').hide();
            $('#keyboardusername').show();
        } else {
            $('#keyboardusername').hide();
            $('#keyboardpassword').show();
        }
    }
</script>
@endsection