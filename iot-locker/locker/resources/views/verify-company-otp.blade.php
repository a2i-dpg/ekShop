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
                        <a href="{{ route('slider-page') }}" class="win7-btn back-btn btn btn-lg btn-secondary btn-block waves-effect waves-light" role="button"> Cancel </a>
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
                                        <span class="logo-lg-text-dark">OTP</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-2 pb-2">
                        <h4 class="text-center p-2 m-0">Please enter the 6-digit Daraz OTP for <span style="color: orangered;">{{$booking->booking_parcel_no}}</span></h4>
                        <form id="otp-verification-form" method="POST" action="{{ route('verify-company-otp') }}">
                            @csrf
                            <div class="mb-3">
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="text" id="company_otp" name="company_otp" value="{{old('company_otp') }}" placeholder="Enter Daraz OTP" onfocus="myKeyboard(this)" autocomplete="off" required>
                                    <!-- <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div> -->
                                </div>
                            </div>
                            <div class="text-center d-grid">
                                <button class="btn win7-btn btn-lg btn-gray btn-secondary waves-effect waves-light" type="submit" id="verification">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div id="keyboard_company_otp"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Information Alert Modal -->
<div id="information-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center">
                    <div class="mb-2 p-2 ">
                        <h2>Given Information</h2>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Daraz OTP : </th>
                                    <td id="show_company_otp" style="text-align: left;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h5 class="my-3">Are you sure want to continue?</h5>
                    <button type="button" class="btn btn-lg btn-light mx-2 px-5" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-lg btn-success btn-yes mx-2 px-5" data-bs-dismiss="modal" onclick="verificationFormSubmitted()">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Information Alert Modal -->

@endsection

@section('custom-js')
<script>
    $(document).ready(function() {

        $('#keyboard_company_otp').jkeyboard({
            layout: "numbers_only",
            input: $('#company_otp')
        });

        $('#information-modal').modal({
            backdrop: 'static',
            keyboard: false
        });

        $("#verification").click(function(e) {
            e.preventDefault();
            let rOTP = ($('#company_otp').val() == '') ? 'Yet to given' : $('#company_otp').val();

            $('#show_company_otp').text(rOTP);
            $('#information-modal').modal('show');
        });
    });

    function myKeyboard(x) {
        if (x.id == 'company_otp') {
            $('#keyboard_company_otp').show();
        }
    }

    function verificationFormSubmitted() {
        document.getElementById('otp-verification-form').submit();
    }
</script>
@endsection