@section('custom_css')
    <style>
        .chart-top_lockers .card-header {
            display: flex;
            justify-content: space-between;
        }

        a.canvasjs-chart-credit {
            display: none !important;
        }

        .canvasjs-chart-toolbar {
            display: none;
        }

        .day_filter {
            display: flex;
            justify-content: space-between;
        }

        @media only screen and (max-width: 768px) {
            .nav-link {
                padding: 0.3rem 0.3rem !important;
                font-size: 10px !important;
            }

            .nav {
                flex-wrap: nowrap !important;
            }

            .chart-filter .card-body {
                padding: 0.3rem 0.5rem;
                font-size: 10px;
            }
            .chart-filter .card-body .form-control{
                font-size: 10px;
            }

        }
    </style>
@endsection

<div>

    <div class="row">
        <div class="col-12 chart-top_lockers">
            <div class="card chart-filter">
                <div class="card-header">
                    <span class="title">Top lockers by booking count</span>
                    {{-- <div class="form-group">
                        <select name="" id="jq_lockers_asc_desc" class="form-control" wire:model="lockers_asc_desc">
                            <option value="asc">Lowest</option>
                            <option value="desc">Heighest</option>
                        </select>
                    </div> --}}
                </div>
                <div class="card-body">
                    <div class="day_filter">
                        <div class="form-group">
                            <select name="" id="jq_lockers_asc_desc" class="form-control form-select"
                                wire:model="lockers_asc_desc">
                                <option value="asc">Lowest</option>
                                <option value="desc">Heighest</option>
                            </select>
                        </div>
                        <ul class="nav nav-tabs justify-content-end">
                            <li class="nav-item">
                                <a class="nav-link {{ $day_filter == 365 ? 'active' : '' }}" href="#"
                                    wire:click="setDayFilter({{ 365 }})">
                                    Total year
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $day_filter == 30 ? 'active' : '' }}" href="#"
                                    wire:click="setDayFilter({{ 30 }})">
                                    Last 30 days
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $day_filter == 7 ? 'active' : '' }}" href="#"
                                    wire:click="setDayFilter({{ 7 }})">
                                    Last 7 days
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $day_filter == 1 ? 'active' : '' }}" href="#"
                                    wire:click="setDayFilter({{ 1 }})" tabindex="-1">
                                    Last Day
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        {{-- Drop off --}}
        <div class="col-12 chart-top_lockers">
            <div class="card">
                <div class="card-body">
                    <div class="overlayTrial">
                        <div id="bookingChartContainer" style="height: 350px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- drop off & collections --}}
        <div class="col-12 chart-top_lockers">
            <div class="card">
                <div class="card-body">
                    <div class="overlayTrial">
                        <div id="bookingByDateChartContainer" style="height: 350px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- new --}}
        {{-- <div class="col-12 chart-top_lockers">
            <div class="card">
                <div class="card-body">
                    <div class="overlayTrial">
                        <div id="bookingByDateChartContainer" style="height: 350px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    @section('custom_script')
        {{-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> --}}
        <script src="{{ asset('assets/common/js/canvasjs.min.js') }}"></script>

        <script>
            $(document).ready(function() {

                let data = {!! json_encode($dataPoints_booking, JSON_NUMERIC_CHECK) !!}
                let dataPoints_dropoff = {!! json_encode($dataPoints_dropoff, JSON_NUMERIC_CHECK) !!}
                let dataPoints_collection = {!! json_encode($dataPoints_collection, JSON_NUMERIC_CHECK) !!}

                renderTopLockers_chart(data);
                renderBookingByDate_chart(dataPoints_dropoff, dataPoints_collection);

                window.addEventListener('render_top_lockers_chart', function(data) {
                    renderTopLockers_chart(data.detail);
                })
                window.addEventListener('render_booking_by_date_chart', function(dataPoints_dropoff,
                    dataPoints_collection) {
                    // console.log(dataPoints_dropoff.detail);
                    renderBookingByDate_chart(dataPoints_dropoff.detail[0], dataPoints_dropoff.detail[1]);
                })
            });

            function renderTopLockers_chart(dataPoints_booking) {
                let highLowSelectedOptionVal = $('#jq_lockers_asc_desc').find(":selected").val();
                let titleText = (highLowSelectedOptionVal == "asc") ? "Lowest {{ $limitOfData }} Lockers" :
                    "Heighest {{ $limitOfData }} Lockers";
                var top_lockers_chart = new CanvasJS.Chart("bookingChartContainer", {
                    animationEnabled: true,
                    exportEnabled: true,
                    theme: "light2", // "light1", "light2", "dark1", "dark2"
                    title: {
                        text: titleText
                    },
                    axisY: {
                        includeZero: true
                    },
                    data: [{
                        type: "column", //change type to column, bar, line, area, pie, etc
                        // indexLabel: "{y}", //Shows y value on all Data Points
                        indexLabelFontColor: "#5A5757",
                        indexLabelPlacement: "outside",
                        dataPoints: dataPoints_booking
                    }]
                });
                top_lockers_chart.render();
            }

            function renderBookingByDate_chart(dataPoints_dropoff, dataPoints_collection) {
                let highLowSelectedOptionVal = $('#jq_lockers_asc_desc').find(":selected").val();
                let titleText = (highLowSelectedOptionVal == "asc") ? "Lowest {{ $limitOfData }} collections" :
                    "Heighest {{ $limitOfData }} collections";

                var bookingByDateChartContainer = new CanvasJS.Chart("bookingByDateChartContainer", {
                    animationEnabled: true,
                    theme: "light2",
                    title: {
                        text: titleText
                    },
                    axisY: {
                        includeZero: true
                    },
                    legend: {
                        cursor: "pointer",
                        verticalAlign: "bottom",
                        horizontalAlign: "bottom",
                        itemclick: toggleDataSeries
                    },
                    data: [{
                        type: "column",
                        name: "Total Dropoff",
                        indexLabel: "{y}",
                        yValueFormatString: "#0.##",
                        showInLegend: true,
                        dataPoints: dataPoints_dropoff
                    }, {
                        type: "column",
                        name: "Total Collect",
                        indexLabel: "{y}",
                        yValueFormatString: "#0.##",
                        showInLegend: true,
                        dataPoints: dataPoints_collection
                    }]
                });
                bookingByDateChartContainer.render();

                function toggleDataSeries(e) {
                    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    } else {
                        e.dataSeries.visible = true;
                    }
                    bookingByDateChartContainer.render();
                }
                // var bookingByDateChartContainer = new CanvasJS.Chart("bookingByDateChartContainer", {
                //     animationEnabled: true,
                //     exportEnabled: true,
                //     theme: "light2", // "light1", "light2", "dark1", "dark2"
                //     title: {
                //         text: titleText
                //     },
                //     axisY: {
                //         includeZero: true
                //     },
                //     data: [{
                //         type: "column", //change type to column, bar, line, area, pie, etc
                //         // indexLabel: "{y}", //Shows y value on all Data Points
                //         indexLabelFontColor: "#5A5757",
                //         indexLabelPlacement: "outside",
                //         dataPoints: dataPoints_booking
                //     }]
                // });
                // bookingByDateChartContainer.render();
            }
        </script>
    @endsection

</div>
