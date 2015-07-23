<?php

namespace Zuccadev\ExceptioneerLaravel;

class Client
{
    protected $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function send(Notification $notification, $endpoint)
    {
        $this->httpClient->send($notification, $endpoint);
    }
}