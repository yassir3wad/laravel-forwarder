<?php

namespace DigitalCloud\Forwarder;

use DigitalCloud\Forwarder\Http\Controllers\SendController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ForwarderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::macro('forward', function ($method, $route) {
            $path = [SendController::class, 'send'];

            Route::$method($route, $path)->middleware("forward:$route");
        });

        $this->publishes([
            __DIR__ . './config/forward.php' => config_path('forward.php'),
        ], 'config');
    }
}
