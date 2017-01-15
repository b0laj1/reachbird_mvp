<?php
require 'vendor/autoload.php';

$chart_data = \Reachbird\Services\data::getGeneralDashboardDataByTopic(10);

?>

<!DOCTYPE HTML>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="emoji-picker-gh-pages/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="de/css/style.css">
    <link rel="stylesheet" type="text/css" href="css/overlay.css">
    <link rel="stylesheet" type="text/css" href="css/custom.min.css">
</head>



<body>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_content">
            <canvas id="mybarChart"></canvas>
        </div>
    </div>

</div>
<div class="clearfix"></div>

<script type="text/javascript" src="js/Chart.min.js"></script>
<script>
    drawBarChart('mybarChart', <?php echo $chart_data; ?>);
    function drawBarChart(element_id, data) {
        var ctx = document.getElementById(element_id);
        var mybarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }

</script>
</body>
</html>
