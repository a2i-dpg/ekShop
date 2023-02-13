@extends('layouts.touchscreen.app')
@section('home-bg', 'home-bg')

@section('custom-css')
<style>
    .pickup-cart {
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
                        <a href="{{route('fend.dashboard')}}" class="win7-btn btn-back btn btn-lg btn-secondary btn-block waves-effect waves-light" role="button">{{__('verification.button.back')}}</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-md-8">
                <div class="card pickup-cart bg-pattern pb-2 form-card">
                    <div class="card-header">
                        <div class="text-center w-75 m-auto">
                            <div class="auth-logo">
                                <a href="#" class="logo logo-dark text-center">
                                    <span class="logo-lg">
                                        <span class="logo-lg-text-dark custom-card-header-title">{{__('verification.card.collect-parcel.header.title')}}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <h3 class="text-center p-0 mb-2">{{__('verification.card.collect-parcel.header.sub-title')}}</h3>
                        <ul class="nav nav-pills navtab-bg nav-justified">
                            <li class="nav-item">
                                <a href="#default-form" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                    {{__('verification.tabs.otp.title')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#barcode-form" data-bs-toggle="tab" aria-expanded="false" class="nav-link" onclick="barcodeAutoFocus(this)">
                                    {{__('verification.tabs.qr-code.title')}}
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="default-form">
                                <form id="default-verification-form" method="POST" action="{{ route('verification') }}" class="pb-2">
                                    @csrf
                                    <div class="mb-2">
                                        <input class="form-control" type="text" id="receiver_mobile_no" name="receiver_mobile_no" value="{{old('receiver_mobile_no') }}" required="" placeholder="{{__('verification.input-field.receiver_mobile_no.placeholder')}}" onfocus="myKeyboard(this)" autocomplete="off">
                                    </div>
                                    <div class="text-center d-grid">
                                        <button class="win7-btn btn btn-lg btn-secondary waves-effect waves-light" type="submit" id="verification">{{__('verification.button.submit-find')}}</button>
                                    </div>
                                </form>
                                <div id="keyboard_receiver_mobile_no"></div>
                                <div id="keyboard_parcel_number"></div>
                                <div id="keyboard_otp"></div>
                            </div>
                            <div class="tab-pane" id="barcode-form">
                                <form id="barcode-verification-form" method="POST" action="{{ route('verification-barcode') }}">
                                    @csrf
                                    <div class="input-group input-group-merge mb-2">
                                        <input class="form-control" type="text" id="barcode" name="barcode" value="{{old('barcode') }}" required="" placeholder="{{__('verification.input-field.barcode.placeholder')}}" autocomplete="off" autofocus>

                                        <div class="input-group-text" onclick="clearBarCodeField()">
                                            <span>{{__('verification.input-field.barcode.button-label')}}</span>
                                        </div>
                                    </div>
                                    <div class="text-center d-grid">
                                        <button class="win7-btn btn btn-lg btn-secondary waves-effect waves-light" type="submit" id="verification-barcode">{{__('verification.button.submit-verify')}}</button>
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

<!-- Information Alert Modal -->
<div id="information-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center">
                    <div class="mb-2 p-2 ">
                        <h2>{{__('verification.modal.information.title')}}</h2>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">{{__('verification.modal.information.label1')}}</th>
                                    <td id="show_receiver_mobile_no" style="text-align: left;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h5 class="my-3">{{__('verification.modal.information.sub-title')}}</h5>
                    <button type="button" class="btn btn-lg btn-light mx-2 px-5" data-bs-dismiss="modal">{{__('verification.modal.information.button-label-no')}}</button>
                    <button type="button" class="btn btn-lg btn-success btn-yes mx-2 px-5" data-bs-dismiss="modal" onclick="defaultVerificationFormSubmitted()">{{__('verification.modal.information.button-label-yes')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Information Alert Modal -->

<!-- Barcode Information Alert Modal -->
<div id="barcode-information-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center">
                    <!-- <i class="dripicons-information h1 text-info"></i> -->
                    <div class="mb-2 p-2 ">
                        <h2>{{__('verification.modal.barcode-information.title')}}</h2>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">{{__('verification.modal.barcode-information.label1')}}</th>
                                    <td id="show_barcode" style="text-align: left;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h5 class="my-3">{{__('verification.modal.barcode-information.sub-title')}}</h5>
                    <button type="button" class="btn btn-lg btn-light mx-2 px-5" data-bs-dismiss="modal">{{__('verification.modal.barcode-information.button-label-no')}}</button>
                    <button type="button" class="btn btn-lg btn-success btn-yes mx-2 px-5" data-bs-dismiss="modal" onclick="barcodeVerificationFormSubmitted()">{{__('verification.modal.barcode-information.button-label-yes')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Barcode Information Alert Modal -->

@endsection

@section('custom-js')
<script>
    $(document).ready(function() {

        $('a[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
            console.log("tab change");
            localStorage.setItem('activeTab_pickup', $(e.target).attr('href'));
        });
        var activeTab_pickup = localStorage.getItem('activeTab_pickup');
        if (activeTab_pickup) {
            $('a[href="' + activeTab_pickup + '"]').tab('show');
        }



        $('#keyboard_receiver_mobile_no').jkeyboard({
            layout: "numbers_only",
            input: $('#receiver_mobile_no')
        });

        $('#keyboard_otp').jkeyboard({
            layout: "numbers_only",
            input: $('#otp')
        });

        $('#keyboard_parcel_number').jkeyboard({
            layout: "english",
            input: $('#parcel_number')
        });

        $('#keyboard_parcel_number').hide();
        $('#keyboard_otp').hide();

        $('#information-modal').modal({
            backdrop: 'static',
            keyboard: false
        });

        $('#barcode-information-modal').modal({
            backdrop: 'static',
            keyboard: false
        });

        $("#verification").click(function(e) {
            e.preventDefault();
            let rMobileNo = ($('#receiver_mobile_no').val() == '') ? "{{__('verification.modal.information.dummy-data')}}" : $('#receiver_mobile_no').val();
            let rParcelNumber = ($('#parcel_number').val() == '') ? "{{__('verification.modal.information.dummy-data')}}" : $('#parcel_number').val();

            $('#show_receiver_mobile_no').text(rMobileNo);
            $('#show_parcel_number').text(rParcelNumber);
            $('#information-modal').modal('show');
        });

        $("#verification-barcode").click(function(e) {
            e.preventDefault();
            let rBarcode = ($('#barcode').val() == '') ? "{{__('verification.modal.information.dummy-data')}}" : $('#barcode').val();

            $('#show_barcode').text(rBarcode);
            $('#barcode-information-modal').modal('show');
        });
    });

    function defaultVerificationFormSubmitted() {
        document.getElementById('default-verification-form').submit();
    }

    function barcodeVerificationFormSubmitted() {
        document.getElementById('barcode-verification-form').submit();
    }

    function barcodeAutoFocus(e) {
        $('#barcode').focus();
    }

    function myKeyboard(x) {
        if (x.id == 'receiver_mobile_no') {
            $('#keyboard_parcel_number').hide();
            $('#keyboard_otp').hide();
            $('#keyboard_receiver_mobile_no').show();
        } else if (x.id == 'parcel_number') {
            $('#keyboard_otp').hide();
            $('#keyboard_receiver_mobile_no').hide();
            $('#keyboard_parcel_number').show();
        } else {
            $('#keyboard_parcel_number').hide();
            $('#keyboard_receiver_mobile_no').hide();
            $('#keyboard_otp').show();
        }
    }

    function clearBarCodeField() {
        $('#barcode').val('');
    }
</script>
@endsection