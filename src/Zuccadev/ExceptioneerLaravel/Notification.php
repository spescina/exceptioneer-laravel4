<?php

namespace Zuccadev\ExceptioneerLaravel;

class Notification
{
    public $code;
    public $exceptionClass;
    public $message;
    public $line;
    public $file;
    public $trace;
    public $path;
    public $uri;
    public $method;
    public $clientIp;
    public $userAgent;
    public $time;
    public $stage;
    public $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        $vars = get_object_vars($this);
        unset($vars['apiKey']);

        $object = [
            'notifier' => [
                'apiKey' => $this->apiKey
            ],
            'event' => $vars
        ];

        return $object;
    }
}