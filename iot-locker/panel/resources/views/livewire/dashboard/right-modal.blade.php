<div>
    <style>
        .right-modal .modal-dialog {
            width: 80%
        }
    </style>
    {{-- <button onclick="openModal()">Open</button> --}}
    <div id="right-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-right" style="width: 80%">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        @isset($box)
                            <div class="box_info">
                                <div class="info_row">
                                    {{-- {{$boxId}} --}}
                                    <strong>{{ $box->locker->locker_code }}</strong>
                                    <span class="box_no">{{ $box->box_no }}</span>

                                </div>
                                <hr class="my-2" />
                                <div class="info_row">
                                    <strong>Address</strong>
                                    <span>{{ $box->locker->location_address }}</span>
                                </div>

                            </div>
                            <hr class="my-2" />
                        @endisset
                    </div>
                    @if (!isset($currentBooking))
                        <div class="booking_info">
                            <div class="info_row">
                                <strong>Box Status</strong>
                                <span>Empty</span>
                            </div>
                        </div>
                    @endisset
                    @isset($currentBooking)
                        <div class="booking_info">
                            <div class="info_row">
                                <strong>Box Status</strong>
                                <span>Booked</span>
                            </div>
                            <div class="info_row">
                                <strong>Booked At</strong>
                                <span>
                                    {{ $currentBooking->booked_at }}
                                </span>
                            </div>
                            <div class="info_row">
                                <strong>Booked By</strong>
                                <span>
                                    {{ $currentBooking->rider->user_full_name ? $currentBooking->rider->user_full_name : $currentBooking->rider->email }}
                                    <br>
                                    ( <a
                                        href="tel:{{ $currentBooking->rider->user_mobile_no }}">{{ $currentBooking->rider->user_mobile_no }}</a>
                                    )
                                </span>
                            </div>
                            <div class="">
                                <strong>Parcel No</strong>

                                <div class="clipboard">
                                    <input onclick="copy()" class="copy-input" value="{{ $currentBooking->parcel_no }}"
                                        id="parcelNo" readonly>
                                    <button class="copy-btn" id="copyButton" onclick="copy()"><i
                                            class="far fa-copy"></i></button>
                                </div>
                            </div>
                        </div>

                        @if ($inputPermission)
                            <div class="row customer_form">
                                <div class="col-md-12">
                                    <div class="form-group readonly">
                                        <label for="phone">Customer Number <span
                                                class="required_sign">*</span></label>
                                        <input type="phone" class="form-control" id="phone"
                                            aria-describedby="phoneHelp" placeholder="Enter Customer Number"
                                            value="{{ $currentBooking->customer_no }}"
                                            {{ $currentBooking->customer_sms_key != null ? 'readonly' : '' }}>

                                        <input type="text" id="bookingID" value="{{ $currentBooking->booking_id }}"
                                            hidden>

                                        <small id="phoneHelp" class="form-text text-muted">Enter customer number match
                                            with
                                            parcel no.</small>
                                    </div>
                                    <div class="submit_btn_container">
                                        <button onclick="submitCustomerNumber()" class="btn btn-primary"
                                            {{ $currentBooking->customer_sms_key != null ? 'disabled' : '' }}>Submit</button>
                                    </div>
                                </div>
                            </div>
                        @endif


                    @endisset

            </div>
            <div class="modal-footer">
                <div id="copied-success" class="copied">
                    <span>Copied!</span>
                </div>
                {{-- <button onclick="bfocus()"></button> --}}
                {{-- <a href="javascript:void(0)" onclick="checkOtp('settings_box')">open settings box</a> --}}
            </div>
        </div>
        <div class="box_history">
            {{-- <i class="fe-database"></i> --}}
        </div>
        {{-- view details --}}
    </div>
</div>

<script>
    function submitCustomerNumber() {
        var url = '/ajax/submit-customer-number'
        let phone = $("#phone").val();
        let parcelNo = $("#parcelNo").val();
        let bookingID = $("#bookingID").val();

        if (phone == "") {
            alert("customer number required.");
            $("#phone").addClass("required");
        }

        $.ajax({
            url: url,
            dataType: "json",
            type: "Post",
            async: true,
            data: {
                '_token': '{{ csrf_token() }}',
                'parcelNo': parcelNo,
                'contactNo': phone,
                'bookingID': bookingID,
            },
            success: function(data) {
                console.log("success");
                console.log(data);
                if (data.status == 203) {
                    toastr.error(data.message, "Error Alert !", {
                        timeout: 3000
                    });
                    return false;
                }
                toastr.success(data.message, "Success", {
                    timeout: 3000
                });

            },
            error: function(xhr, exception) {
                var msg = "";
                if (xhr.status === 0) {
                    msg = "Not connect.\n Verify Network." + xhr.responseText;
                } else if (xhr.status == 404) {
                    msg = "Requested page not found. [404]" + xhr.responseText;
                } else if (xhr.status == 500) {
                    msg = "Internal Server Error [500]." + xhr.responseText;
                } else if (exception === "parsererror") {
                    msg = "Requested JSON parse failed.";
                } else if (exception === "timeout") {
                    msg = "Time out error." + xhr.responseText;
                } else if (exception === "abort") {
                    msg = "Ajax request aborted.";
                } else {
                    msg = "Error:" + xhr.status + " " + xhr.responseText;
                }

            }
        });
    }

    window.onload = function() {
        Livewire.on('showModal', () => {
            console.log("show");
            openModal();
        })
    }

    function openModal() {
        // console.log("box");
        let rightModal = $("#right-modal");
        rightModal.modal('show');
        setTimeout(() => {
            // $("#parcelNo").click();
            // rightModal.find("#phone").focus();
            // console.log("focused");
        }, 1000);
        // console.log(rightModal.find("#phone"));
        // rightModal.find("#phone")[0].focus();
    }

    function copy() {
        var copyText = document.getElementById("parcelNo");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");

        $('#copied-success').fadeIn(800);
        $('#copied-success').fadeOut(1000);
    }
</script>
</div>
