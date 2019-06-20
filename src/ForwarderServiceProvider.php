<?php

namespace DigitalCloud\Forwarder;

use DigitalCloud\Forwarder\Http\Controllers\SendController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ForwarderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::macro('forward', function ($route, $method, $routeTo = null, $path = null) {
            if (!$path) {
                $path = [SendController::class, 'send'];
            }

            if (!$routeTo) {
                $routeTo = $route;
            }

            Route::$method($route, $path)->middleware("forward:$routeTo");
        });

        $this->publishes([
            __DIR__ . './config/forward.php' => config_path('forward.php'),
        ], 'config');
    }
}
