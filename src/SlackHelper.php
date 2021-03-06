<?php

namespace Mia\Slack;

use GuzzleHttp\Psr7\Request;

class SlackHelper
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $guzzle;
    /**
     * 
     */
    public function __construct()
    {
        $this->guzzle = new \GuzzleHttp\Client();
    }

    public function postMessage($webhookUrl, $message, $blocks = [])
    {
        return $this->generateJsonRequest($webhookUrl, array('text' => $message, 'blocks' => $blocks));
    }

    protected function generateJsonRequest($url, $params = null)
    {
        $body = null;
        if($params != null){
            $body = json_encode($params, JSON_UNESCAPED_SLASHES);
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