@extends('layouts.touchscreen.app')
@section('home-bg', 'home-bg')
@section('custom-css')
<style>
    .admin_login_card {
        width: 60vw;
        height: 90vh;
        top: 0;
        position: fixed;
        right: 0;
        height: 100vh;
        display: block !important;
    }
</style>
@endsection

@section('content')
<div class="account-pages">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-md-4">
                <div class="page-title-box">
                    <div class="page-title">
                        <a href="{{ route('fend.dashboard') }}" class="win7-btn btn-back btn btn-lg btn-secondary btn-block waves-effect waves-light" role="button"> Back </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-md-8">
                <div class="card admin_login_card form-card bg-pattern pb-2">
                    <div class="card-header">
                        <div class="text-center w-75 m-auto">
                            <div class="auth-logo pb-2">
                                <a href="#" class="logo logo-dark text-center">
                                    <span class="logo-lg">
                                        <span class="logo-lg-text-dark">Admin login</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 pb-0 mb-5">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <!-- <label for="email" class="form-label">E-Mail Address</label> -->
                                <input class="form-control" type="text" id="email" name="email" placeholder="Enter your email address" onfocus="myKeyboard(this)" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <!-- <label for="password" class="form-label">Password</label> -->
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" onfocus="myKeyboard(this)">
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center d-grid">
                                <button class="win7-btn btn btn-lg btn-secondary waves-effect waves-light" type="submit"> Log In </button>
                            </div>
                            <div class="text-md-end footer-links d-none d-sm-block mt-2">
                                <!-- <a href="{{ route('deliveryman.alternative-login') }}">Alternative Login</a> -->
                            </div>
                        </form>
                    </div>
                    <div id="keyboardemail"></div>
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
        $('#keyboardemail').jkeyboard({
            layout: "english",
            input: $('#email')
        });

        $('#keyboardpassword').jkeyboard({
            layout: "english",
            input: $('#password')
        });

        $('#keyboardpassword').hide();
    });

    function myKeyboard(x) {
        if (x.id == 'email') {
            $('#keyboardpassword').hide();
            $('#keyboardemail').show();
        } else {
            $('#keyboardemail').hide();
            $('#keyboardpassword').show();
        }
    }
</script>
@endsection