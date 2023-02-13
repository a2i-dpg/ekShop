@extends('layouts.touchscreen.app')

@section('home-bg', 'home-bg')

@section('custom-css')
<style>
    .return-card {
        border: 2px solid #ffd000;
        border-radius: 10px;
        box-shadow: rgb(0 0 0 / 15%) 7px 8px 8px 3px;
        /* width: 50vw; */
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
                        <div class="col-sm-12" style="text-align:right">
                            <a href="{{route('logout')}}" class="win7-btn btn btn-md btn-secondary btn-block waves-effect waves-light" role="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{__('box-booking-return.button.logout')}}
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
    <div class="row justify-content-end">
        <div class="col-xl-7 col-md-7">
            <div class="row">
                <div class="col">
                    <div class="card return-card">
                        <div class="card-body">
                            <h4 class="page-title">{{__('box-booking-return.card.booking-list.header.title')}}</h4>
                            <hr class="my-2" />
                            <div class="table-responsive" style="height: 65vh;">
                                <!-- <div class="table-responsive"> -->
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="row">{{__('box-booking-return.card.booking-list.column1')}}</th>
                                            <th scope="row">{{__('box-booking-return.card.booking-list.column2')}}</th>
                                            <th scope="row">{{__('box-booking-return.card.booking-list.column3')}}</th>
                                            <th scope="row">{{__('box-booking-return.card.booking-list.column4')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($booking as $key => $value)
                                        @php
                                        if ($value->box->box_is_enable == 0) {
                                        $statusDisabled = 'disabled';
                                        $statusColor = 'box-maintenance';
                                        } elseif ($value->box->box_is_booked == 1) {
                                        $statusDisabled = 'disabled';
                                        $statusColor = 'box-booked';
                                        } else {
                                        $statusDisabled = '';
                                        $statusColor = 'box-available';
                                        }
                                        @endphp

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$value->booking_receiver_mobile_no}}</td>
                                            <td>{{$value->booking_parcel_no}}</td>
                                            <td>
                                                <div class="text-center d-grid">
                                                    <button class="btn btn-lg waves-effect waves-light {{$statusColor}}" data-bs-toggle="modal" data-bs-target="#right-modal-{{$loop->iteration}}">
                                                        {{ $value->box->box_no }}
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-md-start footer-links d-none d-sm-block mt-2">
                                <a class="btn-skip" href="{{ route('deliveryman.skip-returned-list') }}">Skip</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start right modal content -->

        @foreach ($booking as $key => $value)
        <div id="right-modal-{{$loop->iteration}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-right">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <h3 class="mt-0 box-details-right">{{__('box-booking-return.modal.details.title')}}</h3>
                            <hr class="my-2" />
                            <div class="row">
                                <div class="col-md-6" style="text-align:right">
                                    <h6>{{__('box-booking-return.modal.details.label1')}}</h6>
                                </div>
                                <div class="col-md-6" style="text-align:left">
                                    <h6>{{ $value->box->box_no }}</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" style="text-align:right">
                                    <h6>{{__('box-booking-return.modal.details.label2')}}</h6>
                                </div>
                                <div class="col-md-6" style="text-align:left">
                                    <h6>{{ ucfirst($value->box->box_size) }}</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" style="text-align:right">
                                    <h6>{{__('box-booking-return.modal.details.label3')}}</h6>
                                </div>
                                <div class="col-md-6" style="text-align:left">
                                    <h6>{{ ($value->box->box_is_enable == 1) ? 'Enable' : 'Disabled ' }}</h6>
                                </div>
                            </div>
                            <hr class="my-2" />
                        </div>
                        <div class="row">
                            <form method="POST" action="{{ route('deliveryman.box-booking-return') }}">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{$value->id}}">
                                <input type="hidden" name="box_id" value="{{$value->box->id}}">
                                <div class="text-center d-grid">
                                    <button class="btn btn-lg btn-secondary waves-effect waves-light" type="submit">{{__('box-booking-return.button.submit')}}</button>
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