

@extends('master')

@section('custom_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Lockers by booking count
                </div>
                <div class="card-body">
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('custom_script')
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
        window.onload = function() {

            var data = {!!json_encode($dataPoints_booking, JSON_NUMERIC_CHECK);!!}
            console.log(data);
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                exportEnabled: true,
                theme: "light1", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Top 10 Lockers"
                },
                axisY: {
                    includeZero: true
                },
                data: [{
                    type: "column", //change type to column, bar, line, area, pie, etc
                    // indexLabel: "{y}", //Shows y value on all Data Points
                    indexLabelFontColor: "#5A5757",
                    indexLabelPlacement: "outside",
                    dataPoints: data
                }]
            });
            chart.render();

        }
    </script>
@endsection
