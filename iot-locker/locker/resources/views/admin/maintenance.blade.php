@extends('layouts.touchscreen.app')
@section('home-bg', 'home-bg')
<style>
    .box-list-scroll {
        height: 40vh;
        overflow-y: scroll;
        /* width: 43vw; */
    }

    .go-right {
        text-align: right;
        display: block;
    }

    .btn:disabled {
        pointer-events: auto !important;
        cursor: no-drop !important;
        opacity: 0.3 !important;
    }

    .open_all {
        cursor: pointer;
    }
</style>

@section('content')
<div class="container-fluid">

    <div class="buttons">
        <a href="{{ route('dashboard') }}" class="back-btn win7-btn btn btn-lg btn-secondary btn-block waves-effect waves-light" role="button"> Back
        </a>
        <div class="" style="text-align:right">
            <a href="{{ route('logout') }}" class="win7-btn btn btn-md btn-secondary btn-block waves-effect waves-light" role="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
                <i class="dripicons-power logout_icon"></i>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
    <!-- end page title -->


    <div class="content-conainer">
        <div class="right_side_box">
            <!-- Box details -->
            <div class="card ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-9">
                                    <h4>Box List</h4>
                                </div>
                                <div class="col-3 text-end jq_hide">
                                    <div class="reload_container">
                                        <a href="javascript:void(0)" class=" reload_btn win7-btn btn btn-sm  " onclick="reloadPage()" title="If box not open try again">
                                            <span class="retry_txt">Retry</span>
                                            <i class="dripicons-time-reverse reload_icon"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <div>
                                <span class="pr-2">
                                    <input type="checkbox" class="form-check-input bg-booked button__disabled" disabled>
                                    <span class="text-booked">Booked</span>
                                </span>
                                <span class="px-2">
                                    <input type="checkbox" class="form-check-input bg-maintenance button__disabled" disabled>
                                    <span class="text-maintenance">Maintenance</span>
                                </span>
                                <span>
                                    <input type="checkbox" class="form-check-input bg-available button__disabled" disabled>
                                    <span class="text-available">Available</span>
                                </span>
                            </div>
                            <hr class="my-2" />
                            <div class="row box-list-scroll">
                                @foreach ($boxes as $key => $box)
                                @php
                                if ($box->box_is_enable == 0) {
                                $statusDisabled = 'disabled';
                                $statusColor = 'box-maintenance';
                                } elseif ($box->box_is_booked == 1) {
                                $statusDisabled = 'disabled';
                                $statusColor = 'box-booked';
                                } else {
                                $statusDisabled = '';
                                $statusColor = 'box-available';
                                }
                                $boxNumber = explode("-", $box->box_no);
                                $boxNumber = $boxNumber[1];
                                @endphp

                                <div class="col-md-6 mb-2">
                                    <div class="text-center d-grid">
                                        <button class="btn btn-lg waves-effect waves-light {{ $statusColor }}" onclick="openModal('{{ $boxNumber }}')">
                                            {{ $box->box_no }}
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- Start right modal content -->
<div id="right-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-right">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h4 class="mt-0" id="box_no"></h4>
                    <hr class="my-2" />
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                            <div class="input-group mb-2">
                                <div class="input-group-text">OTP</div>
                                <input class="form-control" type="text" id="admin_otp" name="admin_otp" placeholder="Admin OTP" onfocus="myKeyboard(this)" autocomplete="off">

                            </div>
                            <div class="otp_counter">
                                <small class="jq_otp_text go-right">try again after 60 seconds</small>
                                <a href="javascript:void(0)" onclick="getOtp()" class="jq_get_otp go-right">Get OTP</a>
                            </div>

                        </div>
                    </div>
                    <div class="text-center mb-1">
                        <button class="win7-btn btn btn-lg btn-secondary waves-effect waves-light" onclick="checkOtp('single')">
                            Open
                        </button>
                        <a class="open_all" onclick="checkOtp('all')">
                            Open All Boxes
                        </a>
                    </div>
                </div>
                <div id="keyboard_box_no"></div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" onclick="checkOtp('settings_box')">open settings box</a>
            </div>
        </div>
    </div>

</div>
<!-- End right modal content -->
</div>
@endsection

@section('custom-js')
<script>
    var boxId = 0;
    $(document).ready(function() {
        $('#keyboard_box_no').jkeyboard({
            layout: "numbers_only",
            input: $('#admin_otp')
        });
        $(".jq_otp_text").hide();
    });

    function myKeyboard(x) {
        $('#keyboard_box_no').show();
    }

    function reloadPage() {
        // console.log("reload");
        window.location.reload();
    }

    function openModal(box_id) {
        // console.log("box");
        boxId = box_id;
        let rightModal = $("#right-modal");
        rightModal.find("#box_no").html("Box-" + boxId);
        rightModal.modal('show');

    }

    function checkOtp(checkFor) {
        var otp = $("#admin_otp").val();
        var urlEndpoint = '/admin/maintenance/checkOtp';

        if (otp == "") {
            toastr.warning("Enter OTP");
            return false;
        }

        $.ajax({
                type: 'get',
                dataType: "json",
                url: urlEndpoint,
                async: false,
                data: {
                    'check_for': checkFor,
                    'box_id': boxId,
                    'otp': otp,
                }
            })
            .done(function(data) {
                if (data.status == 200) {
                    console.log('OTP Match');
                    if (parseInt(data.box_id) == 1000) { //box_id 1000 means all box 
                        toastr.success("Openning All Boxes");
                        openAllBox();
                    } else {
                        toastr.success("Openning Box-" + data.box_id);
                        boxOpen(parseInt(data.box_id));
                    }

                } else {
                    toastr.error("OTP not match");
                }
            })
            .fail(function(data) {
                console.log('Faild Ajax request');
            });
    }

    function getOtp() {
        var urlEndpoint = '/admin/maintenance/getOtp';
        $.ajax({
                type: 'get',
                dataType: "json",
                url: urlEndpoint,
                async: false,
            })
            .done(function(data) {
                if (data.status == 200) {
                    console.log('OTP Send');
                    toastr.success("OTP send succesfully to the admin.");
                    $(".jq_get_otp").hide();
                    $(".jq_otp_text").show();
                    setTimeout(() => {
                        $(".jq_otp_text").hide();
                        $(".jq_get_otp").show();
                    }, 60000);
                } else {
                    console.log('Internal Error');
                }
            })
            .fail(function(data) {
                console.log('Faild Ajax request');
            });
    }


    // Web socket
    var serverMessage;
    var socket;
    var checkBoxOpen = 0;
    var checkBoxClose = 0;

    const webSocketEndpoint = "{{ env('WEB_SOCKET_URL') }}" + ":" + "{{ env('WEB_SOCKET_URL_PORT') }}";

    function reloadPage() {
        window.location.reload();
    }

    function connect() {
        socket = new Locker(webSocketEndpoint, CUV2);
    }
    connect();

    socket.onOpen(() => {
        console.log('Connection Ready\n');
    });

    socket.onClose(() => {
        console.log('Connection Closed\n');
        reloadPage();
    });

    function openAllBox() {
        console.log("Open All Boxes");
        socket.send(`DOA`);
    }

    function boxOpen(boxNo) {
        console.log('boxOpen function tiggered');
        socket.send(`DO${boxNo}`);
    }

    function checkBoxLocked(boxNo) {
        console.log('checkBoxLocked function tiggered');
        socket.send(`ST${boxNo}`);
    }
</script>
@endsection

{{-- @if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error("{!! $error !!}");
        </script>
    @endforeach
@endif --}}