<?php

namespace DigitalCloud\Forwarder;

use DigitalCloud\Forwarder\Http\Controllers\SendController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ForwarderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::macro('getFwd', function ($route, $path = null) {
            Route::get($route, $this->getPath($path))->middleware("forward");
        });

        Route::macro('postFwd', function ($route, $path = null) {
            Route::post($route, $this->getPath($path))->middleware("forward");
        });

        Route::macro('putFwd', function ($route, $path = null) {
            Route::put($route, $this->getPath($path))->middleware("forward");
        });

        Route::macro('patchFwd', function ($route, $path = null) {
            Route::patch($route, $this->getPath($path))->middleware("forward");
        });

        Route::macro('deleteFwd', function ($route, $path = null) {
            Route::delete($route, $this->getPath($path))->middleware("forward");
        });

        $this->publishes([
            __DIR__ . './config/forward.php' => config_path('forward.php'),
        ], 'config');
    }

    private function getPath($path)
    {
        if (!$path) {
            $path = [SendController::class, 'send'];
        }

        return $path;
    }
}
