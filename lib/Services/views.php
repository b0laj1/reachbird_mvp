<?php

namespace Reachbird\Services;

class views
{

    public static function generateInfluencerSelect( ) {
        $db_object = new db();
        $return = "<select style='width: 50%; margin-bottom: 40px;' onchange='getInfluencerData(this);'><option>Select Influencer Account</option>";
        $influencers = $db_object->getInfluencersNames();
        if (! empty($influencers)) {
            foreach ($influencers as $influencer) {
                $id = $influencer['id'];
                $name = $influencer['username'];
                $return .= "<option value='$id'>$name</option>";
            }
        }

        $return .= "</select>";

        return $return;
    }

    public static function getSingleInfluencerDataJson($influencer_id) {
        $db = new db();

    }

    public static function getLastTenPostsData($influencer_id) {
        $db = new db();
        $posts = $db->getLastPosts($influencer_id, 10);

        if(! empty($posts)) {
            return json_encode([
                "labels" => [10,9,8,7,6,5,4,3,2,1],
                "datasets" => [
                    [
                        'label'=>'Post Likes',
                        "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                        "borderColor" => "rgba(38, 185, 154, 0.7)",
                        "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                        "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                        "pointHoverBackgroundColor" => "#fff",
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        "pointBorderWidth" => 1,
                        "data" => [31, 74, 6, 39, 20, 85, 7]
                    ],
                    [
                        'label'=>'Post Comments',
                        "backgroundColor" => "rgba(3, 88, 106, 0.3)",
                        "borderColor" => "rgba(3, 88, 106, 0.70)",
                        "pointBorderColor" => "rgba(3, 88, 106, 0.70)",
                        "pointBackgroundColor" => "rgba(3, 88, 106, 0.70)",
                        "pointHoverBackgroundColor" => "#fff",
                        "pointHoverBorderColor" => "rgba(151,187,205,1)",
                        "pointBorderWidth" => 1,
                        "data" => [82, 23, 66, 9, 99, 4, 2]
                    ],
                ]
            ]);
        }
        return json_encode([]);

    }
}