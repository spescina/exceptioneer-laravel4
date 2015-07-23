<?php

namespace Zuccadev\ExceptioneerLaravel;

interface HttpClientInterface
{
    public function send(Notification $notification, $endpoint);
}