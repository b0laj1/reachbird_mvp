<?php
$chart_data = json_encode([
    "labels" => ["January", "February", "March", "April", "May", "June", "July"],
    "datasets" => [
        [
            "label"=> '# of Votes',
            "backgroundColor" => "#26B99A",
            "data" => [51, 30, 40, 28, 92, 50, 45]
        ],
        [
            "label"=> '# of Votes',
            "backgroundColor" => "#03586A",
            "data" => [41, 56, 25, 48, 72, 34, 12]
        ],
    ]
]);

?>

<!DOCTYPE HTML>
<html>



<head>
    <link href="emoji-picker-gh-pages/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="de/css/style.css">
    <link rel="stylesheet" type="text/css" href="css/overlay.css">
</head>



<body>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title"></div>
        </div>
        <div class="x_content">
            <canvas id="mybarChart"></canvas>
        </div>
    </div>
</div>

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
