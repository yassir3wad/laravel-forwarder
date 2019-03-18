<?php

namespace DigitalCloud\Forwarder;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ForwarderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerMacroHelpers();

        if ($this->app->runningInConsole()) {
            $this->commands([AddBlameableColumns::class]);
        }
    }

    public function registerMacroHelpers()
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
