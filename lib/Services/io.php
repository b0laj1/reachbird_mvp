<?php

namespace Reachbird\Services;


class io
{

    /**
     * Send Post Request via Curl
     * @param array $request
     * @param string url
     *
     * @return mixed $result
     */
    public static function sendPostCurlRequest(array $request, $url)
    {
        //url-ify the data for the POST
        $fields_string = http_build_query($request);

        //open connection
        $ch = \curl_init();

        //set the url, number of POST vars, POST data
        \curl_setopt($ch,CURLOPT_URL, $url);
        \curl_setopt($ch,CURLOPT_POST, count($request));
        \curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        \curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        \curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
        \curl_setopt($ch, CURLOPT_VERBOSE, true);
        $verbose = fopen('php://temp', 'rw+');
        \curl_setopt($ch, CURLOPT_STDERR, $verbose);

        //execute post
        $result = \curl_exec($ch);

        //close connection
        \curl_close($ch);

        rewind($verbose);
        $verbose_log = stream_get_contents($verbose);
        //var_dump($verbose_log);

        return $result;
    }
}