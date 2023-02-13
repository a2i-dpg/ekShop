@extends('layouts.touchscreen.app')
@section('home-bg', 'home-bg')

@section('custom-css')
<style>
    .right_side_box {
        width: 60vw;
        margin: 5vw !important;
        height: 85vh;
    }

    .booking-card {
        width: 65vw !important;
        margin: 0 !important;
    }

    .custom-badge {
        cursor: pointer;
    }

    .card-body {
        padding: 1.5rem 0.5rem;
    }

    .box-bookig-form-header {
        background-color: orangered;
        padding: 10px 0;
        /* border-radius: 5px; */
    }

    .box-bookig-form-header .title {
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <!-- start page Logout -->
    <div class="buttons">
        <a href="{{ route('logout') }}" class="win7-btn logout_btn btn btn-md btn-secondary btn-block waves-effect waves-light" role="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{__('box-booking-deliveryman.button.logout')}}
            <i class="dripicons-power logout_icon"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <!-- end page Logout -->
    <div class="content-conainer">
        <div class="right_side_box">
            <!-- tasks panel -->
            <div class="card booking-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row box-bookig-form-header">
                                <div class="col-6">
                                    <h4 class="title">{{__('box-booking-deliveryman.card.header.title')}}</h4>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="badge bg-warning custom-badge" data-bs-toggle="modal" data-bs-target="#right-modal-1">{{ $box->box_no }}</span>
                                </div>
                            </div>
                            <hr class="my-2" />
                            <div class="row justify-content-md-center">
                                <div class="col-md-8 my-2">
                                    <form id="booking-form" method="POST" action="{{ route('deliveryman.box-booking') }}">
                                        @csrf
                                        <input type="hidden" name="box_id" value="{{ $box->id }}">
                                        <input type="hidden" name="box_key" value="{{ $box->box_key }}">

                                        <div class="input-group input-group-merge mb-3">
                                            <input class="form-control" type="text" id="parcel_no" name="parcel_no" value="{{ old('parcel_no') }}" placeholder="{{__('box-booking-deliveryman.input-field.parcel_no.placeholder')}}" onfocus="myKeyboard(this)" autocomplete="off" autofocus>

                                            <div class="input-group-text" onclick="clearBarCodeField()">
                                                <span>{{__('box-booking-deliveryman.input-field.parcel_no.button-label')}}</span>
                                            </div>
                                        </div>
                                        @if(Auth::user()->role_id === 6)
                                        <div class="mb-3">
                                            <input class="form-control" type="text" id="receiver_mobile_no" name="receiver_mobile_no" value="{{ old('receiver_mobile_no') }}" placeholder="{{__('box-booking-deliveryman.input-field.receiver_mobile_no.placeholder')}}" onfocus="myKeyboard(this)" autocomplete="off">
                                        </div>
                                        @endif
                                        <div class="text-center d-grid">
                                            <button class="btn-gray win7-btn btn btn-lg btn-secondary waves-effect waves-light" type="submit" id="booking">{{__('box-booking-deliveryman.button.submit')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="keyboard_parcel_no"></div>
                        <div id="keyboard_receiver_mobile_no"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Start right modal content -->
    <div id="right-modal-1" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-right">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="box-details-right text-center">
                        <h4 class="mt-0 ">{{__('box-booking-deliveryman.modal.details.title')}}</h4>
                        <hr class="my-2" />
                        <div class="row">
                            <div class="col-md-6" style="text-align:right">
                                <h6 class="details-title">{{__('box-booking-deliveryman.modal.details.label1')}}</h6>
                            </div>
                            <div class="col-md-6" style="text-align:left">
                                <h6>{{ $box->box_no }}</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="text-align:right">
                                <h6 class="details-title">{{__('box-booking-deliveryman.modal.details.label2')}}</h6>
                            </div>
                            <div class="col-md-6" style="text-align:left">
                                <h6>{{ ucfirst($box->box_size) }}</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="text-align:right">
                                <h6 class="details-title">{{__('box-booking-deliveryman.modal.details.label3')}}</h6>
                            </div>
                            <div class="col-md-6" style="text-align:left">
                                <h6>{{ $box->box_is_enable == 1 ? 'Enable' : 'Disabled ' }}</h6>
                            </div>
                        </div>
                        <!-- <p>Here are the details of the particular box.</p> -->
                        <hr class="my-2" />
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- End right modal content -->

</div>

<!-- Information Alert Modal -->
<div id="information-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center">
                    <div class="mb-2 p-2 ">
                        <h2>{{__('box-booking-deliveryman.modal.information.title')}}</h2>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">{{__('box-booking-deliveryman.modal.information.label1')}}</th>
                                    <td id="show_parcel_number" style="text-align: left;"></td>
                                </tr>
                                @if(Auth::user()->role_id === 6)
                                <tr>
                                    <th scope="row">{{__('box-booking-deliveryman.modal.information.label2')}}</th>
                                    <td id="show_receiver_mobile_no" style="text-align: left;"></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <h5 class="my-3">{{__('box-booking-deliveryman.modal.information.sub-title')}}</h5>
                    <button type="button" class="btn btn-lg btn-light mx-2 px-5" data-bs-dismiss="modal">{{__('box-booking-deliveryman.modal.information.button-label-no')}}</button>
                    <button type="button" class="btn btn-lg btn-success btn-yes mx-2 px-5" data-bs-dismiss="modal" onclick="formSubmitted()">{{__('box-booking-deliveryman.modal.information.button-label-yes')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Information Alert Modal -->
<a href="{{ route('deliveryman.boxlist') }}" class="win7-btn  btn-back btn btn-lg btn-secondary btn-block waves-effect waves-light" role="button">{{__('box-booking-deliveryman.button.back')}}</a>





@endsection

@section('custom-js')
<script>
    $(document).ready(function() {
        $('#information-modal').modal({
            backdrop: 'static',
            keyboard: false
        });

        $('#keyboard_receiver_mobile_no').jkeyboard({
            layout: "numbers_only",
            input: $('#receiver_mobile_no')
        });

        $('#keyboard_parcel_no').jkeyboard({
            layout: "english",
            input: $('#parcel_no')
        });

        $('#keyboard_receiver_mobile_no').hide();

        $("#booking").click(function(e) {
            e.preventDefault();
            let rParcelNumber = ($('#parcel_no').val() == '') ? "{{__('box-booking-deliveryman.modal.information.dummy-data')}}" : $('#parcel_no').val();
            let rMobileNo = ($('#receiver_mobile_no').val() == '') ? "{{__('box-booking-deliveryman.modal.information.dummy-data')}}" : $('#receiver_mobile_no').val();

            $('#show_parcel_number').text(rParcelNumber);
            $('#show_receiver_mobile_no').text(rMobileNo);

            $('#information-modal').modal('show');
        });
    });

    function formSubmitted() {
        document.getElementById('booking-form').submit();
    }

    function myKeyboard(x) {
        if (x.id == 'receiver_mobile_no') {
            $('#keyboard_parcel_no').hide();
            $('#keyboard_receiver_mobile_no').show();
        } else {
            $('#keyboard_receiver_mobile_no').hide();
            $('#keyboard_parcel_no').show();
        }
    }

    function clearBarCodeField() {
        // $('#parcel_no').val('');
        $("#parcel_no").focus().val('');
    }
</script>
@endsection