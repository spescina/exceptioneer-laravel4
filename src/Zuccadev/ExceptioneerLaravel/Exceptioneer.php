<?php

namespace Zuccadev\ExceptioneerLaravel;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class Exceptioneer
{
    protected $client;

    protected $parser;

    protected $config;

    /**
     * @param Client $client
     * @param Parser $parser
     * @param array $config
     */
    public function __construct(Client $client, Parser $parser, array $config)
    {
        $this->client = $client;

        $this->parser = $parser;

        $this->config = $config;
    }

    /**
     * @param \Exception $e
     */
    public function report(\Exception $e)
    {
        $apiKey = $this->getApiKey();
        $stage = $this->getStage();
        $endpoint = $this->getEndpoint();
        $logInApp = $this->getLogInApp();

        $notification = $this->parser->createNotification($e, $stage, $apiKey);

        if ($logInApp) {
            Log::error($e);
        }

        try {

            Log::info('Sending exception to Exceptioneer...');
            $this->client->send($notification, $endpoint);
            Log::info('Exception sent to Exceptioneer');

        } catch (ClientException $exception) {

            Log::error('Error while sending the exception to Exceptioneer');

        }
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getApiKey()
    {
        if ($this->config['apiKey']) {
            return $this->config['apiKey'];
        } else throw new Exception('No apiKey configured.');
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getStage()
    {
        if ($this->config['stage']) {
            return $this->config['stage'];
        } else throw new Exception('No stage configured.');
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getEndpoint()
    {
        if ($this->config['endpoint']) {
            return $this->config['endpoint'];
        } else throw new Exception('No endpoint configured.');
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getLogInApp()
    {
        if (isset($this->config['logInApp'])) {
            return $this->config['logInApp'];
        } else throw new Exception('No "log in app" setting configured.');
    }
}