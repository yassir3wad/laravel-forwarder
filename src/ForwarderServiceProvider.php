<?php

namespace DigitalCloud\Forwarder;

use DigitalCloud\Forwarder\Http\Controllers\SendController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ForwarderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . './config/forward.php' => config_path('forward.php'),
        ], 'config');

        foreach (config('forward.methods') as $f) {
            Route::macro("{$f}Fwd", function ($route, $path = null) use ($f) {
                if (!$path) {
                    $path = [SendController::class, 'send'];
                }

                Route::$f($route, $path)->middleware("forward");
            });
        }
    }
}
