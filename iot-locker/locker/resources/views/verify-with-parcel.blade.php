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

    .form-control {
        font-size: 1.3rem !important;
    }

    .custom-badge-md {
        padding-top: 20px !important;
        padding-bottom: 20px !important;
    }

    #tracking-list::-webkit-scrollbar-track {
        background-color: #EAEAEA;
    }

    #tracking-list::-webkit-scrollbar {
        width: 5px;
        background-color: #EAEAEA;
    }

    #tracking-list::-webkit-scrollbar-thumb {
        background-color: #FCC015;
        border-radius: 10px;
    }

    input.iotLocker_otp {
        box-sizing: border-box;
        border: 1.5px solid #FCC015;
        outline: none;
        /* line-height: 1rem !important; */

    }

    input.iotLocker_otp::placeholder {
        display: flex;
        align-items: center;
        font-size: 15px !important;
        line-height: 1rem !important;
    }

    input.iotLocker_otp:focus {
        border: 1.5px solid orangered;
        background-color: #EAEAEA;
    }

    #company_otp {
        box-sizing: border-box;
        border: 1.5px solid #FCC015;
        outline: none;
    }

    #company_otp:focus {
        border: 1.5px solid orangered;
        background-color: #EAEAEA;
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
                        <a href="{{ route('slider-page') }}" class="win7-btn back-btn btn btn-lg btn-secondary btn-block waves-effect waves-light" role="button">{{__('verify-with-parcel.button.cancel')}}</a>
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
                                        <span class="logo-lg-text-dark custom-card-header-title">{{__('verify-with-parcel.card.header.title')}}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-2 pt-0 pb-2">
                        <form id="otp-verification-form" method="POST" action="{{ route('verify-with-parcel') }}">
                            @csrf
                            <h3 class="text-center p-2 mb-2">{{__('verify-with-parcel.card.header.sub-title', ['digit' => '4'])}}</h3>
                            <div class="custom-check-div mb-2" id="tracking-list">
                                @foreach ($bookings as $key => $booking)
                                @php
                                $parcel_no = $booking->booking_parcel_no;
                                $checkedStatus = (($key == 0) ? "checked" : '');
                                $oldCheckedStatus = (old('booking_id') !== null && old('booking_id') == $booking->booking_id ? 'checked' : '');
                                @endphp
                                <div class="row align-items-center px-2" style="height: 70px;">
                                    <div class="form-check form-check-custom col-xl-1 col-md-1">
                                        <input class="form-check-input" type="radio" id="{{$booking->booking_id}}" name="booking_id" value="{{$booking->booking_id}}" onclick="showInputField('{{$booking->booking_id}}')" {{$checkedStatus}} {{$oldCheckedStatus}}>
                                    </div>
                                    <div class="col-xl-7 col-md-7 text-center show-parcel-no" id="show-parcel-no-{{$booking->booking_id}}">
                                        <label class="form-check-label px-1 show-parcel-no" for="{{$booking->booking_id}}">{{$parcel_no}}</label>
                                    </div>
                                    <div class="col-xl-4 col-md-4">
                                        <div class="input-group show-input-field" id="show-input-field-{{$booking->booking_id}}">
                                            <input class="form-control iotLocker_otp" type="text" name="iotLocker_otp" value="{{old('iotLocker_otp')}}" placeholder="{{__('verify-with-parcel.input-field.iotLocker_otp.placeholder')}}" onfocus="myKeyboard(this)" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <input type="text" id="iotLocker_otp" name="iotLocker_otp" value="{{old('iotLocker_otp')}}" style="display: none;">
                            </div>
                            <hr class="p-0 m-0 mb-2">
                            <!-- <h4 class="text-center p-2 mb-2">Enter 6 digits Daraz OTP</h4> -->
                            <div class="mb-2">
                                <!-- <label for="parcel_number" class="form-label">Enter Daraz OTP</label> -->
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="text" id="company_otp" name="company_otp" value="{{old('company_otp') }}" placeholder="{{__('verify-with-parcel.input-field.company_otp.placeholder', ['digit' => '6'])}}" onfocus="myKeyboard(this)" autocomplete="off">
                                </div>
                            </div>
                            <div class="text-center d-grid">
                                <button class="btn win7-btn btn-lg btn-gray btn-secondary waves-effect waves-light" type="submit" id="verification">{{__('verify-with-parcel.button.submit')}}</button>
                            </div>
                        </form>
                    </div>
                    <div id="keyboard_iotLocker_otp"></div>
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
                        <h2>{{__('verify-with-parcel.modal.information.title')}}</h2>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row" class="pb-0" style="text-align: left;">{{__('verify-with-parcel.modal.information.label1')}}</th>
                                    <td id="show_iotLocker_otp" style="text-align: left;"></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="pb-0" style="text-align: left;">{{__('verify-with-parcel.modal.information.label2')}}</th>
                                    <td id="show_company_otp" style="text-align: left;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h5 class="my-3">{{__('verify-with-parcel.modal.information.sub-title')}}</h5>
                    <button type="button" class="btn btn-lg btn-light mx-2 px-5" data-bs-dismiss="modal">{{__('verify-with-parcel.modal.information.button-label-no')}}</button>
                    <button type="button" class="btn btn-lg btn-success btn-yes mx-2 px-5" data-bs-dismiss="modal" onclick="verificationFormSubmitted()">{{__('verify-with-parcel.modal.information.button-label-yes')}}</button>
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
        let $tempVal = $("#iotLocker_otp").val();
        $("#iotLocker_otp").val('');
        $("#iotLocker_otp").focus().val($tempVal);

        var checkedRadioBtnId = $('input[name="booking_id"]:checked').val();
        $("#show-input-field-" + checkedRadioBtnId).css("display", "flex");
        $("#show-parcel-no-" + checkedRadioBtnId).addClass('badge bg-warning custom-badge-md');

        $('#keyboard_iotLocker_otp').jkeyboard({
            layout: "numbers_only",
            input: $('#iotLocker_otp')
        });

        $('#keyboard_company_otp').jkeyboard({
            layout: "numbers_only",
            input: $('#company_otp')
        });

        $('#keyboard_company_otp').hide();

        $('#information-modal').modal({
            backdrop: 'static',
            keyboard: false
        });

        $("#verification").click(function(e) {
            e.preventDefault();
            let iotLockerOTP = ($('#iotLocker_otp').val() == '') ? "{{__('verify-with-parcel.modal.information.dummy-data')}}" : (': ' + $('#iotLocker_otp').val());
            let cOTP = ($('#company_otp').val() == '') ? "{{__('verify-with-parcel.modal.information.dummy-data')}}" : (': ' + $('#company_otp').val());

            $('#show_iotLocker_otp').text(iotLockerOTP);
            $('#show_company_otp').text(cOTP);
            $('#information-modal').modal('show');
        });

        $('.jkey').on('click', function() {
            var iotLockerOTP = $('#iotLocker_otp').val();
            $('.iotLocker_otp').val(iotLockerOTP);
        });
    });

    function myKeyboard(x) {
        document.getElementById(x.name).style.backgroundColor = "#EAEAEA";
        if (x.name == 'iotLocker_otp') {
            $('.iotLocker_otp').css('border', '1.5px solid orangered');
            $('.iotLocker_otp').css('background-color', '#EAEAEA');
            $('#company_otp').css('background-color', '');

            $('#keyboard_company_otp').hide();
            $('#keyboard_iotLocker_otp').show();
        } else {
            $('.iotLocker_otp').css('border', '1.5px solid #FCC015');
            $('.iotLocker_otp').css('background-color', '');

            $('#keyboard_iotLocker_otp').hide();
            $('#keyboard_company_otp').show();
        }
    }

    function verificationFormSubmitted() {
        document.getElementById('otp-verification-form').submit();
    }

    function showInputField(id) {
        $(".show-input-field").hide();
        $("#show-input-field-" + id).css("display", "flex");
        $("#show-input-field-" + id).find('input').focus();

        $(".show-parcel-no").removeClass('badge bg-warning custom-badge-md');
        $("#show-parcel-no-" + id).addClass('badge bg-warning custom-badge-md');

        $('#iotLocker_otp').val('');
        $('.iotLocker_otp').val('');
    }
</script>
@endsection