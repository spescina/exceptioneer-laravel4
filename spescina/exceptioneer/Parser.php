<?php

namespace Spescina\Exceptioneer;

use Exception;
use Symfony\Component\HttpFoundation\Request;

class Parser
{
    public function createNotification(Exception $e, $apiKey)
    {
        return $this->build($e, $apiKey);
    }

    protected function build(Exception $e, $apiKey)
    {
        $notification = new Notification($apiKey);

        $notification->time = date('c');

        $this->parseException($notification, $e);
        $this->parseRequest($notification);

        return $notification;
    }

    protected function parseException(Notification $notification, Exception $e)
    {
        $notification->code = $e->getCode();
        $notification->exceptionClass = get_class($e);
        $notification->message = $e->getMessage();
        $notification->line = $e->getLine();
        $notification->file = $e->getFile();
        $notification->trace = $e->getTrace();
    }

    protected function parseRequest(Notification $notification)
    {
        $request = Request::createFromGlobals();

        $notification->path = $request->getPathInfo();
        $notification->uri = $request->getUri();
        $notification->method = $request->getMethod();
        $notification->clientIp = $request->getClientIp();
        $notification->userAgent = $request->headers->get('User-Agent');
    }
}