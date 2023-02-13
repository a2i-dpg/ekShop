@extends('dashboard_layout')

@section('content')
    <style>
        @media only screen and (min-width: 992px) {
            body[data-sidebar-size="condensed"] .content-page {
                margin-left: 70px !important;
            }

            body[data-sidebar-size="default"] .content-page {
                margin-left: 70px !important;
            }
        }

        /* body[data-sidebar-size="condensed"] .content-page {
                    margin-left: 70px !important;
                }

                body[data-sidebar-size="default"] .content-page {
                    margin-left: 70px !important;
                } */
    </style>
    {{-- <div class="row page_title">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">

                </div>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div> --}}
    <!-- end page title -->
    <div class="row">
        <div class="col-3 location_list">
            @livewire('dashboard.location-grid')
        </div>
        <div class="col-9 tabs_table">
            <div class="row" style=" background:#fff;border-radius:10px">
                {{-- <div class="col-xl-12 mx-auto"> --}}
                <div class="card tab_card">
                    <div class="card-header tab_header">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">

                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                    aria-selected="false">
                                    Booking
                                </button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                    type="button" role="tab" aria-controls="home" aria-selected="true">
                                    Activities
                                </button>
                            </li>

                            <li class="nav-item only_mobile" role="presentation">
                                <button class="nav-link" id="locations-tab" data-bs-toggle="tab" data-bs-target="#locations"
                                    type="button" role="tab" aria-controls="profile" aria-selected="false">
                                    Locations
                                </button>
                            </li>
                            <!-- <li class="nav-item" role="presentation">
                                                                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                                                                    </li> -->
                        </ul>
                    </div>
                    <div class="card-body log_table tab_body">
                        <div class="tab-content" id="myTabContent">

                            <!-- Bookings -->
                            <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                aria-labelledby="profile-tab">
                                @livewire('dashboard.dashboard-booking-boxes')
                            </div>

                            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                                @livewire('dashboard.dashboard-logs')
                            </div>


                            <!-- Location Grid -->
                            <div class="tab-pane fade" id="locations" role="tabpanel" aria-labelledby="locations-tab">
                                @livewire('dashboard.location-grid')
                            </div>
                        </div>

                    </div>
                </div>

                {{-- </div> --}}
                <!-- end col -->
            </div>
        </div>
    </div>



    <!-- Box Data grid -->

    {{-- @livewire('dashboard.location-grid') --}}

    <!-- end row -->

    <!-- Company booking data list -->
    {{-- <div class="row p-4 mb-3" style=" background:#fff;border-radius:10px">
        <div class="col-xl-6 mx-auto">
            @livewire('company-booking-lists')
        </div>
        <div class="col-xl-6 mx-auto">
            @livewire('customer-report')
        </div>
        <!-- end col -->
    </div> --}}
    <!-- end row -->
@endsection
@section('custom_script')
    <script>
        $(document).ready(function() {
            // console.log("ready");
            $('button[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('data-bs-target'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('#myTab button[data-bs-target="' + activeTab + '"]').tab('show');
            }
            // $('#myTab button[data-bs-target="#profile"]').tab('show');
            // console.log("fadeout filter");
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                Livewire.emit('setDateRange', start.format('YYYY-MM-DD'), end.format(
                    'YYYY-MM-DD 23:59:59'));
            });

            console.log("ready filterrrr");
            document.getElementById("location_filter_icon").addEventListener("click", function() {
                let locationFilterIcon = $("#location_filter_icon");
                if (locationFilterIcon.hasClass('fe-filter')) {
                    $(".location_list").addClass("location_list_show");
                    locationFilterIcon.removeClass('fe-filter location_filter_icon').addClass(
                        "fe-delete location_filter_icon");
                } else {
                    $(".location_list").removeClass("location_list_show");
                    locationFilterIcon.removeClass('fe-delete location_filter_icon').addClass(
                        "fe-filter location_filter_icon");
                }



            });

            $(".singleBox").click(function(e) {
                if ($(".location_list").hasClass("location_list_show")) {
                    let locationFilterIcon = $("#location_filter_icon");
                    setTimeout(() => {
                        $(".location_list").removeClass("location_list_show",2000);
                        locationFilterIcon.removeClass('fe-delete location_filter_icon').addClass(
                            "fe-filter location_filter_icon",2000);
                    }, 500);
                }
            });


            // $("#totalBox").click(function (e) { 
            //     e.preventDefault();
            //     // alert("click");
            //     $("#jq_total_boxes").addClass('d-block');
            // });
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#getAllBoxStatus").click(function (e) { 
                e.preventDefault();
                console.log("click");
            });
        });
    </script>
@endsection
