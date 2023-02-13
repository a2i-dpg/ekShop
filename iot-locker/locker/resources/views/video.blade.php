@extends('layouts.touchscreen.app')

@section('home-bg', 'home-bg')

@section('custom-css')
<style>
    .video-card {
        border: 2px solid #ffd000;
        border-radius: 10px;
        box-shadow: rgb(0 0 0 / 15%) 7px 8px 8px 3px;
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
                                Logout <i class="dripicons-power logout_icon"></i>
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
                    <div class="card video-card">
                        <div class="card-body">
                            <h4 class="page-title">Demo Video</h4>
                            <hr class="my-2" />



                            <div class="row justify-content-center">
                                <div class="col-xl-6 col-md-6">
                                    <div class="mt-3">
                                        <form class="pb-2" method="POST" action="{{ route('video') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-xl-8 col-md-8">
                                                <input type="file" id="demo-video" name="demo-video" style="font-size:20px;">
                                            </div>
                                            <div class="text-center d-grid  my-2">
                                                <button class="btn btn-md btn-secondary waves-effect waves-light" type="submit">Upload</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->



                            <div class="table-responsive" style="height: 40vh;">
                                <!-- <div class="table-responsive"> -->
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="row">#SL</th>
                                            <th scope="row">Receiver Contact no.</th>
                                            <th scope="row">Parcel no.</th>
                                            <th scope="row">Box label</th>
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
                            <h3 class="mt-0 box-details-right">Box details</h3>
                            <hr class="my-2" />
                            <div class="row">
                                <div class="col-md-6" style="text-align:right">
                                    <h6>Number:</h6>
                                </div>
                                <div class="col-md-6" style="text-align:left">
                                    <h6>{{ $value->box->box_no }}</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" style="text-align:right">
                                    <h6>Size:</h6>
                                </div>
                                <div class="col-md-6" style="text-align:left">
                                    <h6>{{ ucfirst($value->box->box_size) }}</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" style="text-align:right">
                                    <h6>Status:</h6>
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
                                    <button class="btn btn-lg btn-secondary waves-effect waves-light" type="submit">Return</button>
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