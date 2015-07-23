<?php namespace Zuccadev\ExceptioneerLaravel;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class ExceptioneerServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(HttpClientInterface::class, GuzzleHttpClient::class);

        $this->app->bind('exceptioneer', function ($app) {
            $httpClient = $this->app->make(HttpClientInterface::class);

            $client = new Client($httpClient);

            $config = $this->loadConfig();

            return new Exceptioneer($client, new Parser(), $config);
        });
    }

    public function boot()
    {
        $this->package('zuccadev/exceptioneer-laravel');
    }

    public function provides()
    {
        return ['exceptioneer'];
    }

    protected function loadConfig()
    {
        $apiKey = Config::get('exceptioneer-laravel::apiKey');
        $stage = Config::get('exceptioneer-laravel::stage');
        $endpoint = Config::get('exceptioneer-laravel::endpoint');
        $logInApp = Config::get('exceptioneer-laravel::logInApp');

        return compact('apiKey', 'stage', 'endpoint', 'logInApp');
    }
}
