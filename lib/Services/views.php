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

    public static function getSingleInfluencerData($influencer_id) {
        $return = [];
        $db = new db();
        $influencer = $db->getSingleInfluencerData($influencer_id);
        if(! empty($influencer)) {
            $return = $influencer[0];
        }
        return $return;
    }

    public static function getUserTopics($user) {
        $return = [];
        //{ text: 'javascript', size: 40 }
        $labels = data::getAllTopicLabels();
        foreach ($labels as $v) {
            $size = intval($user[$v['topic']] * 500);
            if( $size !== 0) {
                $return[] = [
                    'text' => $v['name'],
                    'size' => $size
                ];
            }
        }
        return json_encode($return);
    }

    public static function getLastTenPostsData($influencer_id) {
        $db = new db();
        $posts = $db->getLastPosts($influencer_id, 10);

        if(! empty($posts)) {
            $labels = [];
            $likes = [];
            $comments = [];
            foreach ($posts as $post) {
                $labels[] = $post['timestamp_str'];//substr($post[''], 0, 20);
                $likes[] = $post['likes']['count'];
                $comments[] = $post['comments']['count'];
            }
            return json_encode([
                "labels" => $labels,
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
                        "data" => $likes
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
                        "data" => $comments
                    ],
                ]
            ]);
        }
        return json_encode([]);

    }

    public static function getLastPosts($id, $count) {
        $db = new db();
        $posts = $db->getLastPosts($id, $count);
        if(! empty($posts) ) {
            return $posts;
        }
        return [];
    }
}