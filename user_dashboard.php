<?php
require 'vendor/autoload.php';

$chart_data = \Reachbird\Services\views::getLastTenPostsData($_SESSION['user_id']);
$user = \Reachbird\Services\views::getSingleInfluencerData($_SESSION['user_id']);
$user_topics = \Reachbird\Services\views::getUserTopics($user);
$user_posts = \Reachbird\Services\views::getLastPosts($_SESSION['user_id'], 3);

function dayFromDate($date) {
    $timestamp = strtotime($date);

    return date('D', $timestamp);

}

function monthFromDate($date) {
    $timestamp = strtotime($date);

    return date('F', $timestamp);
}

function dateFromDate($date) {
    $timestamp = strtotime($date);

    return date('d', $timestamp);
}

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
                <div class="col-xs-12 col-sm-12 emphasis">
                    <p class="ratings">
                        <a><i class="fa fa-user"></i><?php echo " " . number_format($user['followed_by']['count']) . " Followers"; ?></a> |
                        <a href="#"><i class="fa fa-tags"></i> <?php echo " " . intval($user['posts']) . " Posts"; ?> </a>
                    </p>
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
        <div id="cloud"></div>
        <!--<div class="row tile_count">
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
        <div class="clearfix"></div>-->
        <!--<div class="row tile_count">

        </div>-->
    </div>
</div>
<div class="clearfix"></div>
<div class="row">

    <div class="col-md-8 col-xs-12 profile_details">
        <?php foreach ($user_posts as $post) {?>
        <div class="col-md-4 col-xs-12">
            <div class="left col-xs-5 text-center">
                <img src="<?php echo $post['display_src']; ?>" alt="" class="img-responsive">
            </div>
            <div class="right">
                <div class="message_date">
                    <h3 class="date text-info"><?php echo dateFromDate($post['timestamp_str']); ?></h3>
                    <p class="month"><?php echo monthFromDate($post['timestamp_str']); ?></p>
                </div>
                <div class="message_wrapper">
                    <h4 class="heading"></h4>
                    <blockquote class="message"><?php echo substr($post['caption'], 0, 100) . "..."; ?></blockquote>
                    <br />
                    <p class="url">
                        <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                        <a href="#"><i class="fa fa-paperclip"></i> <?php echo $post['likes']['count'] . " likes, " .  $post['comments']['count'] . " comments " ?></a>
                    </p>
                </div>
            </div>
        </div>
        <?php }?>

    </div>

    <div class="col-md-4 col-xs-12">
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
</div>

<script type="text/javascript" src="js/Chart.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.4.11/d3.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/jasondavies/d3-cloud/v1.2.1/build/d3.layout.cloud.js"></script>
<script type="text/javascript" src="js/wordcloud.js"></script>
<script>
    drawLineChart('myLineChart', <?php echo $chart_data; ?>);
    wordcloud(<?php echo $user_topics; ?>, 300, 300);

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
