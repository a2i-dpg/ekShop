$(document).ready(function() {

    let data =  json_encode($dataPoints_booking, JSON_NUMERIC_CHECK)
    renderTopLockers_chart(data);
    renderBookingByDate_chart(data);

    window.addEventListener('render_top_lockers_chart', function(data) {
        renderTopLockers_chart(data.detail);
        renderBookingByDate_chart(data.detail);
    })
});

function renderTopLockers_chart(dataPoints_booking) {
    let highLowSelectedOptionVal = $('#jq_lockers_asc_desc').find(":selected").val();
    let titleText = (highLowSelectedOptionVal == "asc") ? "Lowest 10 Lockers" : "Heighest 10 Lockers";
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

function renderBookingByDate_chart(dataPoints_booking) {
    let highLowSelectedOptionVal = $('#jq_lockers_asc_desc').find(":selected").val();
    let titleText = (highLowSelectedOptionVal == "asc") ? "Lowest 10 Lockers" : "Heighest 10 Lockers";
    var bookingByDateChartContainer = new CanvasJS.Chart("bookingByDateChartContainer", {
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
    bookingByDateChartContainer.render();
}