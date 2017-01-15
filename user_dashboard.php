<?php
require 'vendor/autoload.php';

$user = \Reachbird\Services\views::getSingleInfluencerData($_SESSION['user_id']);
$user_topics = \Reachbird\Services\views::getUserTopics($user);
$user_posts = \Reachbird\Services\views::getLastPosts($_SESSION['user_id'], 4);

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

function calculateDeviationFromExpectation($actual, $expected) {
    $class = $expected > $actual ? 'red' : 'green';
    $arrow = $expected > $actual ? 'fa fa-sort-desc' : 'fa fa-sort-asc';

    $exp = (($actual - $expected) / $expected) * 100;
    $exp = number_format((float)$exp, 2, '.', '');
    return "<i class=\"$class\"><i class='$arrow'></i>$exp% </i> deviation from expectation";
}

?>

<!DOCTYPE HTML>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="emoji-picker-gh-pages/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="de/css/style.css">
    <link rel="stylesheet" type="text/css" href="css/overlay.css">
    <link rel="stylesheet" type="text/css" href="css/equaal.css">
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
                        <a><i class="fa fa-user"></i><?php echo " " . number_format($user['followed_by']['count']) . " Followers"; ?></a>
                        <a href="#"><i class="fa fa-tags"></i> <?php echo " " . intval($user['posts']) . " Posts"; ?> </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xs-12">
        <div class="row tile_count">
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i>Engagement</span>
                <div class="count"><?php echo $user['eng_median']; ?></div>
                <span class="count_bottom"><?php echo calculateDeviationFromExpectation($user['eng_median'], $user['exp_eng_median']); ?></span>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-thumbs-up"></i>Likes</span>
                <div class="count"><?php echo $user['likes_median']; ?></div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-comment"></i> Comments</span>
                <div class="count"><?php echo $user['comm_median']; ?></div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row tile_count">
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-share-alt"></i> Posts/Day</span>
                <div class="count"><?php
                    echo ($user['posts_per_day'] < 1 ? " < 1 " : number_format((float)$user['posts_per_day'], 2, '.', '') ); ?>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-clock-o"></i> Hours btw Posts</span>
                <div class="count"><?php
                    echo (number_format((float)$user['hours_between_posts_mean'], 2, '.', '') ); ?>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-hand-peace-o"></i> Main Topic Post %</span>
                <div class="count"><?php
                    echo (number_format((float)$user['main_topic'] * 100, 2, '.', '') ) . "%"; ?></div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xs-12">
        <div id="cloud"></div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">

    <div class="col-md-12 col-xs-12 profile_details">
        <?php foreach ($user_posts as $post) {?>
        <div class="col-md-3 col-xs-12">
            <div class="row row-eq-height">
                <div class="left col-md-7 text-center">
                    <img src="<?php echo $post['display_src']; ?>" alt="" class="img-responsive">
                </div>
                <div class="right col-md-5">
                    <div class="message_wrapper">
                        <h4 class="heading"><?php echo $post['username']; ?></h4>
                        <blockquote class="message"><?php echo substr($post['caption'], 0, 100) . "..."; ?></blockquote>
                        <br />
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12">
                    <p class="url">
                        <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                        <a href="#"><i class="fa fa-share-alt"></i> <?php echo $post['likes']['count'] . " likes, " .  $post['comments']['count'] . " comments " ?></a>
                    </p>
                </div>
            </div>
        </div>
        <?php }?>

    </div>

</div>

<script type="text/javascript" src="js/Chart.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.4.11/d3.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/jasondavies/d3-cloud/v1.2.1/build/d3.layout.cloud.js"></script>
<script type="text/javascript" src="js/wordcloud.js"></script>
<script>
    wordcloud(<?php echo $user_topics; ?>, 300, 300);

</script>
</body>
</html>
