<?php

if(!function_exists("callMomWithGet")) {
    function callMomWithGet($url) {
        $client = new \GuzzleHttp\Client();
        $request = $client->get($url);
        $response = $request->getBody();
        return json_decode($response);
    }
}

