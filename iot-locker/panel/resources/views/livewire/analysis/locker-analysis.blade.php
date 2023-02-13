@section('custom_css')
    <style>
        .chart-top_lockers .card-header {
            display: flex;
            justify-content: space-between;
        }

        a.canvasjs-chart-credit {
            display: none !important;
        }

        .overlayTrial::after {
            width: 12%;
            height: 40px;
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            background: rgb(255, 255, 255);
        }

        .canvasjs-chart-canvas {
            /* padding-bottom: 10px; */
        }
    </style>
@endsection

<div>
    <div class="row">
        <div class="col-12 chart-top_lockers">
            <div class="card">
                <div class="card-header">
                    <span class="title">Lockers by booking count</span>
                    <div class="form-group">
                        <select name="" id="jq_lockers_asc_desc" class="form-control" wire:model="lockers_asc_desc">
                            <option value="asc">Lowest</option>
                            <option value="desc">Heighest</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="day_filter">
                        <ul class="nav nav-tabs justify-content-end">
                            <li class="nav-item">
                                <a class="nav-link" {{ $day_filter == 365 ? 'active' : '' }} href="#"
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

        <div class="col-12 chart-top_lockers">
            <div class="card">
                <div class="card-body">
                    <div class="overlayTrial">
                        <div id="chartContainer" style="height: 350px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @section('custom_script')
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

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
                let titleText = (highLowSelectedOptionVal == "asc") ? "Lowest 10 Lockers" : "Heighest 10 Lockers";
                
                var chart = new CanvasJS.Chart("chartContainer", {
                    theme: "light2",
                    animationEnabled: true,
                    title: {
                        text: "World Energy Consumption by Sector - 2012"
                    },
                    data: [{
                        type: "pie",
                        indexLabel: "{y}",
                        yValueFormatString: "#,##0.00\"%\"",
                        indexLabelPlacement: "inside",
                        indexLabelFontColor: "#36454F",
                        indexLabelFontSize: 18,
                        indexLabelFontWeight: "bolder",
                        showInLegend: true,
                        legendText: "{label}",
                        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart.render();

            }

            function renderBookingByDate_chart(dataPoints_dropoff, dataPoints_collection) {
                let highLowSelectedOptionVal = $('#jq_lockers_asc_desc').find(":selected").val();
                let titleText = (highLowSelectedOptionVal == "asc") ? "Lowest 10 collections" : "Heighest 10 collections";

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
