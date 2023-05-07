function donutChartRender(chartRenderTo, percentage, labels, colors) {

    let max_of_array = Math.max.apply(Math, percentage);
    if (max_of_array <= 0) {
        percentage = [100];
        labels = ["No Data"];
        colors = ["#FF8585"];
    }

    var donutChartOptions = {
        chart: {
            type: "donut",
            height: 120,
            toolbar: {
                show: false,
            },
        },
        dataLabels: {
            enabled: false,
        },
        series: percentage,
        legend: { show: false },
        comparedResult: [2, -3, 8],
        labels: labels,
        stroke: { width: 0 },
        colors: colors,
        grid: {
            padding: {
                right: -20,
                bottom: -8,
                left: -20,
            },
        },
        plotOptions: {
            pie: {
                startAngle: -10,
                donut: {
                    labels: {
                        show: true,
                        name: {
                            offsetY: 15,
                        },
                        value: {
                            offsetY: -15,
                            formatter: function (val) {
                                return parseInt(val) + "%";
                            },
                        },
                        total: {
                            show: true,
                            offsetY: 15,
                            label: labels[0],
                            formatter: function (w) {
                                if (max_of_array <= 0) {
                                    return "0";
                                } else {
                                    return percentage[0] + "%";
                                }
                            },
                        },
                    },
                },
            },
        },
        responsive: [
            {
                breakpoint: 1325,
                options: {
                    chart: {
                        height: 100,
                    },
                },
            },
            {
                breakpoint: 1200,
                options: {
                    chart: {
                        height: 120,
                    },
                },
            },
            {
                breakpoint: 1045,
                options: {
                    chart: {
                        height: 100,
                    },
                },
            },
            {
                breakpoint: 992,
                options: {
                    chart: {
                        height: 120,
                    },
                },
            },
        ],
    };
    var donutChart = new ApexCharts(chartRenderTo, donutChartOptions);
    donutChart.render();
}

