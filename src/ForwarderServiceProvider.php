<?php

namespace DigitalCloud\Forwarder;

use DigitalCloud\Forwarder\Http\Controllers\SendController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ForwarderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::macro('getFwd', function ($route) {
            $path = [SendController::class, 'send'];
            Route::get($route, $path)->middleware("forward:$route");
        });

        Route::macro('postFwd', function ($route) {
            $path = [SendController::class, 'send'];
            Route::post($route, $path)->middleware("forward:$route");
        });

        Route::macro('putFwd', function ($route) {
            $path = [SendController::class, 'send'];
            Route::put($route, $path)->middleware("forward:$route");
        });

        Route::macro('patchFwd', function ($route) {
            $path = [SendController::class, 'send'];
            Route::patch($route, $path)->middleware("forward:$route");
        });

        Route::macro('deleteFwd', function ($route) {
            $path = [SendController::class, 'send'];
            Route::delete($route, $path)->middleware("forward:$route");
        });


        $this->publishes([
            __DIR__ . './config/forward.php' => config_path('forward.php'),
        ], 'config');
    }
}
