@extends('layouts.touchscreen.app')
@section('home-bg', 'home-bg')

@section('custom-css')
<style>
    .return-card {
        border: 2px solid #ffd000;
        border-radius: 10px;
        box-shadow: rgb(0 0 0 / 15%) 7px 8px 8px 3px;
    }

    .box-list-scroll {
        height: 40vh;
        width: 40vw;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    .box-size {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        background-color: #ced4da;

    }

    .box-size-btn {
        text-decoration: none;
        font-style: normal;
        color: #323a46;
        font-size: 16px;
        font-weight: 600;
        padding: 10px;
    }

    .nav-link {
        font-size: 22px;
    }

    .nav-tabs {
        display: flex;
        justify-content: space-between;
    }

    .box-btn {
        font-size: 22px;
        height: 70px;
    }

    .disabled {
        cursor: no-drop;
    }

    .card_container {
        display: flex;
        align-items: center;
    }

    .card-header {
        padding: 0;
    }

    .card-header h4 {
        text-align: center;
    }

    .nav-tabs .nav-link.active {
        color: #800280;
        font-weight: 800;
    }

    .btn:disabled {
        pointer-events: auto !important;
        cursor: no-drop !important;
        opacity: 0.3 !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-8">
                            <!-- <a href="{{ route('dashboard') }}" class="btn btn-lg btn-secondary btn-block waves-effect waves-light" role="button"> Back </a> -->
                        </div>

                        <div class="col-sm-4" style="text-align:right">
                            <a href="{{ route('logout') }}" class="win7-btn logout_btn btn btn-md btn-secondary btn-block waves-effect waves-light" role="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                                <i class="dripicons-power logout_icon"></i>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- tasks panel -->
    <div class="row heigh-100vh">

        <div class="col-md-6 "></div>
        <!-- task details -->
        <div class="col-md-6 card_container">
            <div class="card box-list return-card">
                <div class="card-header">
                    <h4 class="p-2" style="text-transform: uppercase; font-weight: bold;">Emergency Box Open</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
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
                                    @foreach ($emergency_boxlist as $key => $box)
                                    @php
                                    if ($box->box_is_in_maintenance == 1) {
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

                                    <div class="col-md-4 mb-2">
                                        <div class="text-center d-grid">
                                            <button class="btn btn-md waves-effect waves-light {{ $statusColor }} box-btn" data-bs-toggle="modal" data-bs-target="#right-modal-{{ $loop->iteration }}">
                                                {{ $box->box_no }}
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <hr class="my-2" />
                            <div class="text-md-start footer-links d-none d-sm-block mt-2">
                                <a class="btn-skip" href="{{ route('deliveryman.skip-emergencyboxopen-list') }}">Skip</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start right modal content -->

    @foreach ($emergency_boxlist as $box)
    <div id="right-modal-{{ $loop->iteration }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-right">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h3 class="mt-0">Box Details</h3>
                        <hr class="my-2" />
                        <div class="row">
                            <div class="col-md-6" style="text-align:right">
                                <h6>Number:</h6>
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
                        <hr class="my-2" />
                    </div>
                    <div class="row">
                        <form method="POST" action="{{ route('deliveryman.emergency_box_open') }}">
                            @csrf
                            <input type="hidden" name="box_id" value="{{ $box->id }}">
                            <div class="text-center d-grid">
                                <button class="boxlist btn btn-lg btn-secondary waves-effect waves-light" type="submit">Box Open</button>
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