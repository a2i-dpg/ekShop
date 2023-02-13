@extends('master')


@section('custom_css')
    <style>
        .total_box {
            border: 2px solid #F5D403 !important;
        }

        .active_box {
            border: 2px solid rgb(86, 221, 19) !important;
        }

        .inactive_box {
            border: 2px solid red !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <h4>Booking</h4>
    <div class="row">
        {{-- Booking --}}
        <div class="col-md-3 col-xl-3">
            @include('templates.includes.number_counter', [
                'icon' => '<i class="fe-package font-22 avatar-title text-primary"></i>',
                'number' => $totalBooking,
                'label' => 'Booking',
            ])
        </div>

        {{-- Picked --}}
        <div class="col-md-3 col-xl-3">
            @include('templates.includes.number_counter', [
                'icon' => '<i class="fe-truck font-22 avatar-title text-success"></i>',
                'number' => $pickedBooking,
                'label' => 'Picked',
            ])
        </div>

        {{-- Returned --}}
        <div class="col-md-3 col-xl-3">
            @include('templates.includes.number_counter', [
                'icon' => '<i class="fe-bar-chart-line- font-22 avatar-title text-danger"></i>',
                'number' => $returnedBook,
                'label' => 'Returned',
            ])
        </div>

        {{-- Pending --}}
        <div class="col-md-3 col-xl-3">
            @include('templates.includes.number_counter', [
                'icon' => '<i class="fe-truck font-22 avatar-title text-success"></i>',
                'number' => $pendingBooking,
                'label' => 'Pending',
            ])
        </div>

    </div>




    <h4>iotLockeres</h4>
    <div class="row">
        {{-- Total --}}
        <div class="col-md-3 col-xl-3">
            <a href="{{ asset(route('iotLocker.dashboard')) }}">
                <div class="widget-rounded-circle card iotLocker-card total_box">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                    <i class="fe-user font-22 avatar-title text-info"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    @if (!is_null($totalboxes))
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"
                                                style="font-size: 30px;font-weight:700">
                                                {{ $totalboxes }}
                                            </span></h3>
                                    @else
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"
                                                style="font-size: 30px;font-weight:700">0</span></h3>
                                    @endif
                                    <p class="text-muted mb-1 text-truncate">Total</p>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->

        {{-- Active --}}
        <div class="col-md-3 col-xl-3">
            <a href="{{ asset(route('iotLocker.dashboard')) }}">
                <div class="widget-rounded-circle card iotLocker-card active_box">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                    <i class="fe-user font-22 avatar-title text-info"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    @if (!is_null($activeBoxes))
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"
                                                style="font-size: 30px;font-weight:700">
                                                {{ $activeBoxes }}
                                            </span></h3>
                                    @else
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"
                                                style="font-size: 30px;font-weight:700">0</span></h3>
                                    @endif
                                    <p class="text-muted mb-1 text-truncate">Active</p>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->

        {{-- Active --}}
        <div class="col-md-3 col-xl-3">
            <a href="{{ asset(route('iotLocker.dashboard')) }}">
                <div class="widget-rounded-circle card iotLocker-card inactive_box">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                    <i class="fe-user font-22 avatar-title text-info"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    @if (!is_null($totalboxes))
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"
                                                style="font-size: 30px;font-weight:700">
                                                {{ $totalboxes - $activeBoxes }}
                                            </span></h3>
                                    @else
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"
                                                style="font-size: 30px;font-weight:700">0</span></h3>
                                    @endif
                                    <p class="text-muted mb-1 text-truncate">Inactive</p>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->



    </div>



    <h4>Users</h4>
    <div class="row">

        {{-- Admins --}}
        <div class="col-md-3 col-xl-3">
            <a href="{{ asset(route('admin.allAdmin')) }}">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                    <i class="fe-user font-22 avatar-title text-info"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    @if (!is_null($totalAdmin))
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"
                                                style="font-size: 30px;font-weight:700">
                                                {{ $totalAdmin }}
                                            </span></h3>
                                    @else
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"
                                                style="font-size: 30px;font-weight:700">0</span></h3>
                                    @endif
                                    <p class="text-muted mb-1 text-truncate">Admins</p>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->

        {{-- Agents --}}
        <div class="col-md-3 col-xl-3">
            <a href="{{ asset(route('admin.allAgent')) }}">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                    <i class="fe-user font-22 avatar-title text-info"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    @if (!is_null($totalAgent))
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"
                                                style="font-size: 30px;font-weight:700">
                                                {{ $totalAgent }}
                                            </span></h3>
                                    @else
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"
                                                style="font-size: 30px;font-weight:700">0</span></h3>
                                    @endif
                                    <p class="text-muted mb-1 text-truncate">Agents</p>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->

        {{-- Riders --}}
        <div class="col-md-3 col-xl-3">
            <a href="{{ asset(route('admin.allDeliveryMan')) }}">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                    <i class="fe-user font-22 avatar-title text-info"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    @if (!is_null($totalDeliveryMan))
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"
                                                style="font-size: 30px;font-weight:700">{{ $totalDeliveryMan }}</span>
                                        </h3>
                                    @else
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"
                                                style="font-size: 30px;font-weight:700">0</span></h3>
                                    @endif
                                    <p class="text-muted mb-1 text-truncate"><small>Delivery Man</small></p>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->






    </div>


    <div class="row bg-white p-3">
        <div class="col-xl-12">
            <h4 class=" text-center mb-3" style="font-weight: 700;font-size:16px;line-height:18px;">Today's Parcel</h4>
            <div class="card">

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless table-nowrap table-hover table-centered m-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Location</th>
                                    <th>Parcel No</th>
                                    <th>Booked Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($package as $item)
                                    <tr>
                                        <td>{{ $item->booking_id }}</td>
                                        <td>{{ $item->locker->location_address }}</td>
                                        <td>{{ $item->parcel_no }}</td>
                                        <td>{{ $item->created_at->diffForHumans(null, true) . ' ago' }}</td>
                                        <td>
                                            @if (!is_null($item->collected_at))
                                                <span class="badge bg-soft-warning text-warning">Picked</span>
                                            @else
                                                <span class="badge bg-soft-warning text-warning">Processing..</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end .table-responsive-->
                    <div class="d-flex justify-content-end mt-3">
                        {!! $package->links() !!}
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->


    <div class="row bg-white p-3">
        <div class="col-xl-6">
            @livewire('delivery-man-booking-report')
        </div>
    </div>
    <!-- end row -->
@endsection
