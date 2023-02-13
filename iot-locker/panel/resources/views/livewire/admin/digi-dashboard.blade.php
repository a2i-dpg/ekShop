@section('custom_css')
    <style>
        .total {}

        .active_box {
            border: 2px solid rgb(86, 221, 19) !important;
        }

        .inactive_box {
            border: 2px solid red !important;
        }
    </style>
@endsection

<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <h4>iotLockeres</h4>
    <div class="row">
        {{-- Total --}}
        <div class="col-md-3 col-xl-3">
            <a href="#">
                <div class="widget-rounded-circle card iotLocker-card">
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
            <a href="#">
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
            <a href="#">
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
</div>

@section('custom_script')
@endsection
