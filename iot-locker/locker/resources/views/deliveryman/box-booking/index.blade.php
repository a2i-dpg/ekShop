@extends('layouts.touchscreen.app')
@section('home-bg', 'home-bg')

@section('custom-css')
<style>
    .box-list-scroll {
        height: 40vh;
        width: 40vw;
        /* width: 100%; */
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
        /* margin-bottom: 4vh; */
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
                                {{__('boxlist-deliveryman.button.logout')}}
                                <i class="dripicons-power logout_icon"></i>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <!-- <h4 class="page-title">Box List</h4> -->
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="content-conainer">
        <div class="right_side_box">
            <!-- tasks panel -->
            <div class="row heigh-100vh">
                <!-- task details -->
                <div class=" card_container">
                    <div class="card box-list">
                        <div class="card-header">
                            <h4 style="text-transform: uppercase; font-weight: bold;">{{__('boxlist-deliveryman.card.header.title')}}</h4>
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#">{{__('boxlist-deliveryman.tabs.all')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('deliveryman.size-wise-boxlist', ['box_size' => 'small']) }}" class="nav-link" role="button" aria-pressed="true">{{__('boxlist-deliveryman.tabs.small')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('deliveryman.size-wise-boxlist', ['box_size' => 'medium']) }}" class="nav-link" role="button" aria-pressed="true">{{__('boxlist-deliveryman.tabs.medium')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('deliveryman.size-wise-boxlist', ['box_size' => 'large']) }}" class="nav-link" role="button" aria-pressed="true">{{__('boxlist-deliveryman.tabs.large')}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4>{{__('boxlist-deliveryman.card.header.sub-title')}}</h4>
                                    <div>
                                        @php
                                        if (Session::get('selected_flag') == 'booked') {
                                        $activeBooked = 'active';
                                        $activeMaintenance = '';
                                        $activeAvailable = '';
                                        } elseif (Session::get('selected_flag') == 'maintenance') {
                                        $activeBooked = '';
                                        $activeMaintenance = 'active';
                                        $activeAvailable = '';
                                        } elseif (Session::get('selected_flag') == 'available') {
                                        $activeBooked = '';
                                        $activeMaintenance = '';
                                        $activeAvailable = 'active';
                                        } else {
                                        $activeBooked = '';
                                        $activeMaintenance = '';
                                        $activeAvailable = '';

                                        }
                                        @endphp
                                        <a href="{{ route('deliveryman.legend-wise-boxlist', ['flag' => 'booked']) }}" class="legend {{$activeBooked}}">
                                            <input type="checkbox" class="form-check-input bg-booked button__disabled" disabled>
                                            <span class="text-booked">{{__('boxlist-deliveryman.legend.booked')}}</span>
                                        </a>
                                        <a href="{{ route('deliveryman.legend-wise-boxlist', ['flag' => 'maintenance']) }}" class="legend {{$activeMaintenance}}">
                                            <input type="checkbox" class="form-check-input bg-maintenance button__disabled" disabled>
                                            <span class="text-maintenance">{{__('boxlist-deliveryman.legend.maintenance')}}</span>
                                        </a>
                                        <a href="{{ route('deliveryman.legend-wise-boxlist', ['flag' => 'available']) }}" class="legend {{$activeAvailable}}">
                                            <input type="checkbox" class="form-check-input bg-available button__disabled" disabled>
                                            <span class="text-available">{{__('boxlist-deliveryman.legend.available')}}</span>
                                        </a>
                                    </div>
                                    <hr class="my-2" />
                                    <div class="box-list-scroll">
                                        <div class="row">
                                            @foreach ($boxes as $key => $box)
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
                                                    <button class="btn btn-md waves-effect waves-light {{ $statusColor }} box-btn button__disabled" data-bs-toggle="modal" data-bs-target="#right-modal-{{ $loop->iteration }}" {{ $statusDisabled }}>
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
                            <!-- <a href="{{ route('deliveryman.box-booking-return') }}" class="collect_return" role="button">Collect Returned </a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Start right modal content -->

    @foreach ($boxes as $box)
    <div id="right-modal-{{ $loop->iteration }}" class="modal fade right-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-right">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h3 class="mt-0">{{__('boxlist-deliveryman.modal.details.title')}}</h3>
                        <hr class="my-2" />
                        <div class="row">
                            <div class="col-md-6" style="text-align:right">
                                <h6 class="title">{{__('boxlist-deliveryman.modal.details.label1')}}</h6>
                            </div>
                            <div class="col-md-6" style="text-align:left">
                                <h6>{{ $box->box_no }}</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="text-align:right">
                                <h6 class="title">{{__('boxlist-deliveryman.modal.details.label2')}}</h6>
                            </div>
                            <div class="col-md-6" style="text-align:left">
                                <h6>{{ ucfirst($box->box_size) }}</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="text-align:right">
                                <h6 class="title">{{__('boxlist-deliveryman.modal.details.label3')}}</h6>
                            </div>
                            <div class="col-md-6" style="text-align:left">
                                <h6>{{ $box->box_is_enable == 1 ? 'Enable' : 'Disabled ' }}</h6>
                            </div>
                        </div>
                        <hr class="my-2" />
                    </div>
                    <div class="row">
                        <form method="GET" action="{{ route('deliveryman.box-booking') }}">
                            <!-- @csrf -->
                            <input type="hidden" name="box_id" value="{{ $box->id }}">
                            <div class="text-center d-grid">
                                <button class="boxlist btn btn-lg btn-secondary waves-effect waves-light" type="submit">{{__('boxlist-deliveryman.modal.button.submit')}}</button>
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