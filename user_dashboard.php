<?php
require 'vendor/autoload.php';

$chart_data = \Reachbird\Services\views::getLastTenPostsData($_SESSION['user_id']);
$user = \Reachbird\Services\views::getSingleInfluencerData($_SESSION['user_id']);

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

    <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
        <div class="well profile_view">
            <div class="col-sm-12">
                <h4 class="brief"><i>Influencer</i></h4>
                <div class="left col-xs-7">
                    <h2><?php echo  isset($user['full_name']) ? $user['full_name'] : $user['username'];  ?></h2>
                    <p><strong>About: </strong> <?php echo  isset($user['biography']) ? $user['biography'] : "Incognito";  ?></p>
                </div>
                <div class="right col-xs-5 text-center">
                    <img src="<?php echo $user['profile_pic_url']; ?>" alt="" class="img-circle img-responsive">
                </div>
            </div>
            <div class="col-xs-12 bottom text-center">
                <div class="col-xs-12 col-sm-6 emphasis">
                    <p class="ratings">
                        <a><?php echo number_format($user['followed_by']['count']) . " followers"; ?></a>
                        <a href="#"> </a>
                    </p>
                </div>
                <div class="col-xs-12 col-sm-6 emphasis">
                    <button type="button" class="btn btn-success btn-xs"> <i class="fa fa-user">
                        </i> <i class="fa fa-comments-o"></i> </button>
                    <button type="button" class="btn btn-primary btn-xs">
                        <i class="fa fa-user"> </i> View Profile
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xs-12">
        <div class="x_content">
            <canvas id="myLineChart"></canvas>
        </div>
    </div>

    <div class="col-md-4 col-xs-12">
        <div class="row tile_count">
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
                <div class="count">2500</div>
                <span class="count_bottom"><i class="green">4% </i> From last Week</span>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-clock-o"></i> Average Time</span>
                <div class="count">123.50</div>
                <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Males</span>
                <div class="count green">2,500</div>
                <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row tile_count">
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Females</span>
                <div class="count">4,567</div>
                <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
                <div class="count">2,315</div>
                <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
                <div class="count">7,325</div>
                <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<script type="text/javascript" src="js/Chart.min.js"></script>
<script>
    drawLineChart('myLineChart', <?php echo $chart_data; ?>);
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

    function drawLineChart(element_id, data) {
        var ctx = document.getElementById(element_id);
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: data
        });
    }

</script>
</body>
</html>
