@extends('layouts.touchscreen.app')
@section('home-bg', 'home-bg')

@section('content')
<div class="account-pages">
    <div class="container">
        <div class="row justify-content-center mt-2">
            <div class="col-xl-7 col-md-7">

            </div>
            <div class="col-xl-5 col-md-5">
                <div class="card bg-pattern">
                    <div class="card-body">
                        <div class="text-center w-75 m-auto">
                            <div class="auth-logo">
                                <a href="#" class="logo logo-dark text-center">
                                    <span class="logo-md">
                                        <span class="logo-lg-text-dark">OTP</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('verification-otp') }}">
                            @csrf
                            <div class="mb-3">
                                <input class="form-control" type="text" id="otp" name="otp" placeholder="Enter your otp" onfocus="myKeyboard(this)" autocomplete="off">
                            </div>
                            <div class="text-center d-grid">
                                <button class="btn btn-lg btn-secondary waves-effect waves-light" type="submit"> Submit </button>
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