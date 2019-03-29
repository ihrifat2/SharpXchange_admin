demo = {
    initDocumentationCharts: function() {
        if ($('#dailySalesChart').length != 0 && $('#websiteViewsChart').length != 0) {
            dataDailySalesChart = {
                labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
                series: [
                [12, 17, 7, 17, 23, 18, 38]
                ]
            };

            optionsDailySalesChart = {
                lineSmooth: Chartist.Interpolation.cardinal({
                    tension: 0
                }),
                low: 0,
                high: 50,
                chartPadding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                },
            }

            var dailySalesChart = new Chartist.Line('#dailySalesChart', dataDailySalesChart, optionsDailySalesChart);

            var animationHeaderChart = new Chartist.Line('#websiteViewsChart', dataDailySalesChart, optionsDailySalesChart);
        }
    }
}