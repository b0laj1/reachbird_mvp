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
        $return = [];
        $collection = $this->client->selectCollection(Config\Config::DB_DATABASE, self::COLLECTION_PROFILES);
        $cursor = $collection->find([
            'eng_median' => [
                '$exists' => true
            ]
        ]);

        $x=0;
        foreach ($cursor as $document) {
            $return[$x]['id'] = $document['_id'];
            $return[$x]['name'] = $document['username'];
            $x++;
        }
        return $return;
    }

    public function getSingleInfluencerData($id) {
        $return = [];
        $collection = $this->client->selectCollection(Config\Config::DB_DATABASE, self::COLLECTION_PROFILES);
        $cursor = $collection->find([ '_id' => $id ]);

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