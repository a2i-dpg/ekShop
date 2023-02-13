@extends('layouts.touchscreen.app')
@section('home-bg', 'home-bg')
<style>
    .box-list-scroll {
        height: 40vh;
        overflow-y: scroll;
        /* width: 43vw; */
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
    <div class="buttons">
        <a href="{{ route('dashboard') }}" class="back-btn win7-btn  btn-lg" role="button"> Back </a>
        <a href="{{ route('logout') }}" class="win7-btn logout_btn btn-md" role="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
            <i class="dripicons-power logout_icon"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
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
                                                <h4>Add Multiple Box</h4>
                                            </div>
                                            <div class="col-sm-6" style="text-align:right">
                                                <a href="{{ route('locker-box.index') }}" class="btn win7-btn btn-secondary waves-effect waves-light"><i class='fe-plus me-1'></i>Add Single Box</a>
                                            </div>
                                        </div>
                                        <hr class="my-2" />
                                        <div class="row justify-content-md-center">
                                            <div class="col-md-8 mb-2">
                                                <form method="POST" action="{{ route('locker-box.create-multiple') }}">
                                                    @csrf

                                                    <div class="row align-items-center">
                                                        <label for="box_no" class="form-label">Box Number</label>

                                                        <div class="col-xl-6 col-md-6">
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-text">From</div>
                                                                <input class="form-control" type="text" id="box_no_from" name="box_no_from" value="{{old('box_no_from') }}" placeholder="Box no." onfocus="myKeyboard(this)" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-md-6">
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-text">To</div>
                                                                <input class="form-control" type="text" id="box_no_to" name="box_no_to" value="{{old('box_no_to') }}" placeholder="Box no." onfocus="myKeyboard(this)" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-3">
                                                        <span class="p-2">
                                                            <input class="form-check-input" type="radio" name="boxsize" id="boxsizesamll" value="small" {{old("boxsize")=="small" ? 'checked' : ''}}>
                                                            <label class="form-check-label" for="boxsizesamll">Samll</label>
                                                        </span>
                                                        <span class="p-2">
                                                            <input class="form-check-input" type="radio" name="boxsize" id="boxsizemedium" value="medium" {{old("boxsize")=="medium" ? 'checked' : ''}}>
                                                            <label class="form-check-label" for="boxsizemedium">Medium</label>
                                                        </span>
                                                        <span class="p-2">
                                                            <input class="form-check-input" type="radio" name="boxsize" id="boxsizelarge" value="large" {{old("boxsize")=="large" ? 'checked' : ''}}>
                                                            <label class="form-check-label" for="boxsizelarge">Large</label>
                                                        </span>
                                                    </div>
                                                    <div class="text-center d-grid">
                                                        <button class="btn win7-btn btn-lg btn-secondary waves-effect waves-light" type="submit">Add Box</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div id="keyboard_box_no_from"></div>
                                            <div id="keyboard_box_no_to"></div>
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
                                    @endphp

                                    <div class="col-md-6 mb-2">
                                        <div class="text-center d-grid">
                                            <button class="btn btn-lg waves-effect waves-light {{ $statusColor }}" data-bs-toggle="modal" data-bs-target="#right-modal-{{ $loop->iteration }}">
                                                {{ $box->box_no }}
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
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
                            <a href="{{ route('locker-box.edit', $box->id) }}" class="btn btn-lg btn-secondary  waves-effect waves-light" role="button" aria-pressed="true">Edit</a>
                        </div>
                        <div class="text-center mb-2">
                            <button class="btn btn-lg btn-danger waves-effect waves-light" title="Delete {{ $box->box_no }}" onclick="delete_confirmation('{{$box->id}}')"><i class="far fa-trash-alt"></i></button>
                        </div>
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
                                <button class="btn btn-lg btn-secondary waves-effect waves-light" type="submit">Submit</button>
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

<!-- Start Delete Confirmation Modal -->
<div id="delete-confirmation-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center">
                    <!-- <i class="dripicons-information h1 text-info"></i> -->
                    <div class="mb-2 p-2 ">
                        <h2 class="text-danger">Delete</h2>
                    </div>
                    <h5 class="my-3">Are you sure want to <span class="text-danger">Delete</span> this box?</h5>
                    <button type="button" class="btn btn-lg btn-light mx-2 px-5" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-lg btn-success mx-2 px-5" data-bs-dismiss="modal" onclick="deleteConfirmationSubmit(deleteBoxId)">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Delete Confirmation Modal Modal -->

@endsection

@section('custom-js')
<script>
    var deleteBoxId = 0;
    $(document).ready(function() {
        $('#keyboard_box_no_from').jkeyboard({
            layout: "numbers_only",
            input: $('#box_no_from')
        });

        $('#keyboard_box_no_to').jkeyboard({
            layout: "numbers_only",
            input: $('#box_no_to')
        });

        $('#keyboard_box_no_to').hide();

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
        } else {
            $("#enable_add_box_mode").prop('checked', false);
            $(".addboxform").hide();
        }
        // Enable Add Box mode:end

        $('#delete-confirmation-modal').modal({
            backdrop: 'static',
            keyboard: false
        });

    });

    function myKeyboard(x) {
        if (x.id == 'box_no_from') {
            $('#keyboard_box_no_to').hide();
            $('#keyboard_box_no_from').show();
        } else {
            $('#keyboard_box_no_from').hide();
            $('#keyboard_box_no_to').show();
        }
    }

    function changeBoxEnable(e) {
        var idIndex = e.id;
        var boxNo = idIndex.split("_")[0];
        if ($(`#${boxNo}_box_is_in_maintenance`).is(":checked")) {
            $(`#${boxNo}_box_is_enable`).prop('checked', false);
        }
    }

    function delete_confirmation(id) {
        deleteBoxId = id;
        $('#delete-confirmation-modal').modal('show');
    }

    function deleteConfirmationSubmit(id) {
        var resource = '/admin/locker-box';
        var apiEndpoint = window.location.origin + resource + '/' + id;

        $.ajax({
                type: 'DELETE',
                dataType: "json",
                url: apiEndpoint,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'DELETE',
                },
            })
            .done(function(data) {
                toastr.success("Box deleted successfully");

                setTimeout(function() {
                    window.location.reload();
                }, 1000)
            })
            .fail(function(data) {
                alert('faild');
            });
    }
</script>
@endsection