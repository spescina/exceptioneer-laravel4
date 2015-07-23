# exceptioneer-laravel4
Exceptioneer client for Laravel 4.2.x

## install
Add `'Zuccadev\ExceptioneerLaravel\ExceptioneerServiceProvider'` to providers array in `app/config/app.php`  

Update the `app/start/global.php`
```
App::error(function (Exception $exception, $code) {
  App::make('exceptioneer')->report($exception);
});
```

Publish the config file using artisan `php artisan config:publish zuccadev/exceptioneer-laravel4` and edit it
