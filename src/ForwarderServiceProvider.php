<?php

namespace DigitalCloud\Forwarder;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ForwarderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::macro('forward', function ($methods, $to, $route, $path) {
            Route::group([
                'middleware' => ['forward:' . $to . "/"],
            ], function () use ($methods, $route, $path) {
                Route::match($methods, $route, $path);
            });
        });
    }
}
