@extends('layouts.touchscreen.app')
@section('home-bg', 'home-bg')
<style>
    .box-list-scroll {
        height: 40vh;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    .disabled {
        cursor: no-drop;
    }

    .btn:disabled {
        pointer-events: auto !important;
        cursor: no-drop !important;
        opacity: 0.3 !important;
    }
</style>

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-6">
                            <a href="{{ route('dashboard') }}" class="btn win7-btn back-btn btn-lg btn-secondary btn-block waves-effect waves-light" role="button"> Back </a>
                        </div>
                        <div class="col-sm-6" style="text-align:right">
                            <a href="{{ route('logout') }}" class="btn win7-btn logout_btn btn-md btn-secondary btn-block waves-effect waves-light" role="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                                <i class="dripicons-power logout_icon"></i>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <!-- <h4 class="page-title">Locker Box</h4> -->
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- tasks panel -->
    <div class="admin_body_content_center">
        <div class="row">
            <div class="col-xl-8 col-md-8">
                <div class="row">
                    <div class="col">
                        <div class="card addboxform hide">
                            <div class="card-body p-4 pb-2">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row justify-content-md-center">
                                            <div class="col-sm-6">
                                                <h4>Edit Box</h4>
                                            </div>
                                            <div class="col-sm-6" style="text-align:right">
                                                <a href="{{ route('locker-box.index') }}" class="btn win7-btn btn-secondary waves-effect waves-light"><i class='fe-plus me-1'></i>Add New</a>
                                            </div>
                                        </div>

                                        <hr class="my-2" />
                                        <div class="row justify-content-md-center">
                                            <div class="col-md-8 my-3">
                                                <form method="POST" action="{{ route('locker-box.update', $box_info->id) }}">
                                                    @csrf
                                                    @method('PUT')

                                                    @php
                                                    $arr_box_no = explode('-', $box_info->box_no);
                                                    $box_no = $arr_box_no[1];
                                                    @endphp

                                                    <div class="mb-3">
                                                        <label for="box_no" class="form-label">Box Number</label>

                                                        <div class="input-group mb-2">
                                                            <div class="input-group-text">Box-</div>
                                                            <input class="form-control" type="text" id="box_no" name="box_no" placeholder="Enter box number" value="{{ $box_no }}" onfocus="myKeyboard(this)" autocomplete="off">
                                                        </div>

                                                    </div>
                                                    <div class="m-3">
                                                        <span class="p-2">
                                                            <input class="form-check-input" type="radio" name="boxsize" id="boxsizesamll" value="small" {{ $box_info->box_size == 'small' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="boxsizesamll">Samll</label>
                                                        </span>
                                                        <span class="p-2">
                                                            <input class="form-check-input" type="radio" name="boxsize" id="boxsizemedium" value="medium" {{ $box_info->box_size == 'medium' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="boxsizemedium">Medium</label>
                                                        </span>
                                                        <span class="p-2">
                                                            <input class="form-check-input" type="radio" name="boxsize" id="boxsizelarge" value="large" {{ $box_info->box_size == 'large' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="boxsizelarge">Large</label>
                                                        </span>
                                                    </div>

                                                    <div class="text-center d-grid">
                                                        <button class="btn btn-lg btn-secondary waves-effect waves-light" type="submit">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div id="keyboard_box_no"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Box details -->
            <div class="col-xl-4 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Box List</h4>
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
                                <div class="box-list-scroll">
                                    <div class="row">
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
                                        @endphp

                                        <div class="col-md-6 mb-2">
                                            <div class="text-center d-grid">
                                                <button class="btn btn-md waves-effect waves-light {{ $statusColor }}" data-bs-toggle="modal" data-bs-target="#right-modal-{{ $loop->iteration }}">
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
                    <div class="card-footer">
                        <div class="form-check form-switch my-2">
                            <input type="checkbox" class="form-check-input" id="enable_add_box_mode" name="enable_add_box_mode">
                            <label class="form-check-label" for="enable_add_box_mode">Enable Add Box Mode</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Start right modal content -->

    @foreach ($boxes as $box)
    <div id="right-modal-{{ $loop->iteration }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-right">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h4 class="mt-0">Box details</h4>
                        <hr class="my-2" />
                        <div class="row">
                            <div class="col-md-6" style="text-align:right">
                                <h6>Label:</h6>
                            </div>
                            <div class="col-md-6" style="text-align:left">
                                <h6>{{ $box->box_no }}</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="text-align:right">
                                <h6>Size:</h6>
                            </div>
                            <div class="col-md-6" style="text-align:left">
                                <h6>{{ ucfirst($box->box_size) }}</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="text-align:right">
                                <h6>Status:</h6>
                            </div>
                            <div class="col-md-6" style="text-align:left">
                                <h6>{{ $box->box_is_enable == 1 ? 'Enable' : 'Disabled ' }}</h6>
                            </div>
                        </div>
                        <div class="text-center d-grid mb-2">
                            <a href="{{ route('locker-box.edit', $box->id) }}" class="btn btn-sm btn-secondary  waves-effect waves-light" role="button" aria-pressed="true">Edit</a>
                        </div>
                        <!-- <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p> -->
                    </div>
                    <div class="row">
                        <form method="POST" action="{{ route('locker-box.maintenance') }}">
                            @csrf
                            <input type="hidden" name="box_id" value="{{ $box->id }}">
                            <div class="col-md-12 m-2">
                                <div class="form-check form-switch my-2">
                                    <input type="checkbox" class="form-check-input" id="{{ $loop->iteration }}_box_is_enable" name="box_is_enable" {{ $box->box_is_enable == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="box_is_enable">Enable</label>
                                </div>
                                <div class="form-check form-switch my-2">
                                    <input type="checkbox" class="form-check-input" id="{{ $loop->iteration }}_box_is_in_maintenance" name="box_is_in_maintenance" onclick="changeBoxEnable(this)" {{ $box->box_is_in_maintenance == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="box_is_in_maintenance">Maintenance</label>
                                </div>
                            </div>
                            <div class="text-center d-grid">
                                <button class="btn btn-sm btn-secondary waves-effect waves-light" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- End right modal content -->
</div>
@endsection

@section('custom-js')
<script>
    $(document).ready(function() {
        $('#keyboard_box_no').jkeyboard({
            layout: "numbers_only",
            input: $('#box_no')
        });

        // Enable Add Box mode:start
        $("#enable_add_box_mode").change(function() {
            if (this.checked) {
                localStorage.setItem("enable_add", 1);
                $(".addboxform").show();
            } else {
                localStorage.setItem("enable_add", 0);
                $(".addboxform").hide();
            }
        });

        if (localStorage.getItem('enable_add') != null && parseInt(localStorage.getItem('enable_add'))) {
            $("#enable_add_box_mode").prop('checked', true);
            $(".addboxform").show();
            // console.log("enable true");
        } else {
            $("#enable_add_box_mode").prop('checked', false);
            $(".addboxform").hide();
            // console.log("enable false");
        }
        // Enable Add Box mode:end
    });

    function myKeyboard(x) {
        $('#keyboard_box_no').show();
    }

    function changeBoxEnable(e) {
        var idIndex = e.id;
        var boxNo = idIndex.split("_")[0];
        if ($(`#${boxNo}_box_is_in_maintenance`).is(":checked")) {
            $(`#${boxNo}_box_is_enable`).prop('checked', false);
        }
    }
</script>
@endsection