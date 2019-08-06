<?php

require "chart.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        SharpXchange | test
    </title>
    <link rel="stylesheet" href="assets/css/material-dashboard.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <script src="assets/js/chartist.min.js"></script>
</head>

<body class="dark-edition">

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>Daily Sales</h3>
                <div class="ct-chart" id="dailySellChart"></div>
            </div>
            <div class="col-md-6">
                <h3>Completed Tasks</h3>
                <div class="ct-chart" id="completeTask"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        new Chartist.Line('#dailySellChart', {
            labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
            series: [
                <?php echo json_encode($dailySell); ?>
            ]
        }, {
            fullWidth: true,
            chartPadding: {
                right: 40
            }
        });

        new Chartist.Bar('#completeTask', {
            labels: <?php echo json_encode($cTWeakName); ?>,
            series: [
                <?php echo json_encode($cTWeaklyEx); ?>
            ]
        }, {
            fullWidth: true,
            chartPadding: {
                right: 40
            }
        });

    </script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap-material-design.min.js"></script>
    <script src="https://unpkg.com/default-passive-events"></script>
    <script src="assets/js/perfect-scrollbar.jquery.min.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="assets/js/material-dashboard.js?v=2.1.0"></script>
    <script src="assets/js/bootstrap-notify.js"></script>
</body>
</html>