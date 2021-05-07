<?php

namespace Mia\Slack;

use GuzzleHttp\Psr7\Request;

class SlackHelper
{
    /**
     * 
     */
    public function __construct()
    {
        
    }

    public function postMessage($webhookUrl, $message)
    {
        return $this->generateJsonRequest($webhookUrl, array('text' => $message));
    }

    protected function generateJsonRequest($url, $params = null)
    {
        $body = null;
        if($params != null){
            $body = json_encode($params);
        }

        $request = new Request(
            'POST', 
            $url, 
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ], $body);

        $response = $this->guzzle->send($request);
        if($response->getStatusCode() == 200){
            return json_decode($response->getBody()->getContents());
        }

        return null;
    } 
}