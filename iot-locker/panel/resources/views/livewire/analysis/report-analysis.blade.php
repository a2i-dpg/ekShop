<div>
    @section('custom_css')
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
        <style>
            .chart-top_lockers .card-header {
                /* display: flex; */
                /* justify-content: space-between; */
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
                align-items: center;
            }

            #reportTable td {
                border-right: 1px solid #8080803b !important;
                /* display: none; */
            }
            #reportTable th {
                /* display: none; */
            }

            
            .chart_data .title{
                display: none;
            } 

            tr:nth-child(odd) .canvasjs-chart-canvas{
                background-color: #343a400a !important;
            }

            @media only screen and (max-width: 768px) {
                .card-body{
                    background: white;
                }
                #reportTable{
                    margin-top: 12px;
                }
                .nav-link {
                    padding: 0.3rem 0.3rem !important;
                    font-size: 12px !important;
                }

                .nav {
                    flex-wrap: nowrap !important;
                }

                .chart-filter .card-body {
                    padding: 0.3rem 0.5rem;
                    font-size: 10px;
                }

                .chart-filter .card-body .form-control {
                    font-size: 10px;
                }

                #reportTable td {
                border-right: 1px solid #8080803b !important;
                display: none;
                }
                #reportTable th {
                    display: none;
                }

                #reportTable td.chart_data {
                    display: block;
                }
                #reportTable th.chart_header {
                    display: block;
                }

                .chart_data .title{
                    text-align: center;
                    display: block;
                }   

                .table-responsive {
                    padding: 0;
                }

                .hide_on_mobile{
                    display: none;
                }

                .chart-filter{
                    position: fixed;
                    top: 8%;
                    left: 4%;
                    width: 92%;
                    z-index: 2;
                    height: 150px;
                }
                .report-card{
                    margin-top: 150px;
                }
                .day_filter {
                    flex-direction: column;
                }

                .day_filter {
                    align-items: normal;
                }

            }
        </style>
    @endsection

    <div class="row">
        <div class="col-12 chart-top_lockers">
            <div class="card chart-filter">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="title">Top lockers by booking count</span>
                        </div>
                        <div class="col-md-6">
                            <input type="text" wire:model.debounce.300ms='dateRangeShow' name="daterange"
                                class="form-control" />
                        </div>
                    </div>
                    {{-- {{"hello"}}
                    {{$dateRangeShow}} --}}
                </div>
                <div class="card-body">
                    {{-- <div class="row">
                        
                        <div class="offset-md-8 col-md-4 d-flex align-items-center gap-2 mobile-mt-1">
                            <input type="text" wire:model.debounce.300ms='dateRangeShow' name="daterange"
                                class="form-control" />
                        </div>
                    </div> --}}
                    <div class="day_filter">
                        {{-- <div class="form-group hide_on_mobile">
                            <select name="" id="jq_lockers_asc_desc" class="form-control form-select"
                                wire:model="lockers_asc_desc">
                                <option value="asc">Lowest</option>
                                <option value="desc">Heighest</option>
                            </select>
                        </div> --}}
                        <ul class="nav nav-tabs justify-content-end">
                            <li class="nav-item">
                                <a class="nav-link {{ $day_filter == 365 ? 'active' : '' }}" href="javascript:void(0)"
                                    wire:click="setDayFilter({{ 365 }})">
                                    Total year
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $day_filter == 30 ? 'active' : '' }}" href="javascript:void(0)"
                                    wire:click="setDayFilter({{ 30 }})">
                                    Last 30 days
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $day_filter == 7 ? 'active' : '' }}" href="javascript:void(0)"
                                    wire:click="setDayFilter({{ 7 }})">
                                    Last 7 days
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $day_filter == 1 ? 'active' : '' }}" href="javascript:void(0)"
                                    wire:click="setDayFilter({{ 1 }})" tabindex="-1">
                                    Last Day
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $day_filter == 0 ? 'active' : '' }}" href="javascript:void(0)"
                                    wire:click="setDayFilter({{ 0 }})" tabindex="-1">
                                    Today
                                </a>
                            </li>
                        </ul>

                        <div class="search">
                            <div class="form-group">
                                <label for="searchLocker">Search Lockers</label>
                                <input type="text" class="form-control" wire:model="searchText" id="searchLocker" aria-describedby="searchHelp" placeholder="Search locker">
                                <small id="searchHelp" class="form-text text-muted">Search lockers by name, address, landmarks e.t.c.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card report-card">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover display" id="reportTable">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Location</th>
                        <th scope="col">Booking</th>
                        <th scope="col">Collected</th>
                        <th scope="col">Return</th>
                        <th scope="col">Pending</th>
                        <th scope="col" class="chart_header">Chart</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataOfAllLockers as $key => $locker)
                        @php
                            $locker = (object) $locker;
                        @endphp
                        <tr>
                            {{-- <th scope="row">{{ $key + 1 }}</th> --}}
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $locker->locker_code }}</td>
                            <td>{{ $locker->total_booking }}</td>
                            <td>{{ $locker->total_collect }}</td>
                            <td>{{ $locker->total_return }}</td>
                            <td>{{ $locker->total_pending }}</td>
                            <td class="chart_data">
                                <h4 class="title">{{$locker->locker_code}}</h4>
                                <div id="chartContainer_{{ $key }}" style="height: 200px; width: 300px;">
                                </div>
                                
                                {{-- <button type="button" class="btn btn-primary" wire:click="setChartData({{$key}})"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    View
                                </button> --}}
                            </td>
                        </tr>
                    @endforeach

                    {{-- <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                    </tr> --}}
                </tbody>
            </table>

            {{ $allLockers->links() }}
        </div>

    </div>



    {{-- Chart Modal --}}
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="chartContainer"style="height: 200px; width: 300px;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>



    @section('custom_script')
        {{-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> --}}
        <script src="{{ asset('assets/common/js/canvasjs.min.js') }}"></script>

        <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>


        <script>
            $(document).ready(function() {
                // This is for 1st time only when component render for first time
                let dataPoints = <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>;
                renderPieCharts(dataPoints);
            });

            function renderPieCharts(dataPoints) {
                // console.log(dataPoints);
                // @foreach ($dataPoints as $key => $data)
                //     var chart = new CanvasJS.Chart("chartContainer_" + {{ $key }}, {
                //         animationEnabled: true,
                //         exportEnabled: true,
                //         data: [{
                //             type: "pie",
                //             showInLegend: "false",
                //             legendText: "{}",
                //             indexLabelFontSize: 10,
                //             indexLabel: "{label} - #percent%",
                //             yValueFormatString: "#,##0",
                //             dataPoints: dataPoints
                //         }]
                //     });
                //     chart.render();
                // @endforeach

                dataPoints.forEach((item, index) => {
                    // CanvasJS.addColorSet("greenShades",
                    //     [//colorSet Array
                    //     "#2F4F4F",
                    //     "#008080",
                    //     "#2E8B57",
                    //     "#3CB371",
                    //     "#90EE90"                
                    //     ]);
                    var chart = new CanvasJS.Chart("chartContainer_" + index, {
                        animationEnabled: true,
                        exportEnabled: true,
                        data: [{
                            type: "pie",
                            showInLegend: "false",
                            legendText: "{}",
                            indexLabelFontSize: 12,
                            indexLabel: "{label} - #percent%",
                            yValueFormatString: "#,##0",
                            dataPoints: item
                        }]
                    });
                    chart.render();
                });
            }

            window.addEventListener('renderDataTable', function(dataPoints) {
                // console.log("renderDataTable");
                // console.log(dataPoints.detail);
                renderPieCharts(dataPoints.detail);
                // $('#reportTable').DataTable();
            })
        </script>

        
        <script>
            $(document).ready(function() {
                // console.log("fadeout filter");
                $('input[name="daterange"]').daterangepicker({
                    opens: 'left'
                }, function(start, end, label) {
                    Livewire.emit('setDateRange', start.format('YYYY-MM-DD'), end.format(
                        'YYYY-MM-DD 23:59:59'));
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                // $('#reportTable').DataTable();
            });
        </script>
    @endsection

</div>
