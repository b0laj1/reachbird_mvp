<?php

namespace Reachbird\Services;

use Reachbird\Config as Config;
use MongoDB;

class db
{
    private $client;

    const COLLECTION_PROFILES = "profiles";

    const COLLECTION_SAMPLES = "samples";

    const COLLECTION_POSTS = "posts";

    public function __construct()
    {

       $this->client = new MongoDB\Client(self::formatConnectionURL());
    }


    /**
     * @return array
     */
    public function getInfluencersNames() {
        $collection = $this->client->selectCollection(Config\Config::DB_DATABASE, self::COLLECTION_PROFILES);
        $cursor = $collection->find([
            'eng_median' => [
                '$exists' => true
            ]
        ],['sort'=>['username'=> 1]]);

        return $cursor->toArray();
    }

    public function getSingleInfluencerData($id) {
        $return = [];
        $collection = $this->client->selectCollection(Config\Config::DB_DATABASE, self::COLLECTION_PROFILES);
        $cursor = $collection->find([ 'id' => $id ]);

        if(! empty($cursor)) {
            return $cursor->toArray();
        }
        return $return;
    }

    public function getLastPosts($id, int $count) {
        $return = [];
        $collection = $this->client->selectCollection(Config\Config::DB_DATABASE, self::COLLECTION_SAMPLES);
        $cursor = $collection->find(['owner.id'=>$id], [ 'limit' => $count, 'sort'=>['date'=> -1] ]);

        if(! empty($cursor)) {
            return $cursor->toArray();
        }
        return $return;
    }

    private static function formatConnectionURL() {
        $url =  "mongodb://".Config\Config::DB_USER.":".Config\Config::DB_PASSWORD."@".Config\Config::DB_HOST.":".Config\Config::DB_PORT."/".Config\Config::DB_DATABASE;
        return $url;
    }
}