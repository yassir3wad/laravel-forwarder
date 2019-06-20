<?php

namespace DigitalCloud\Forwarder\Http\Middleware;

use DigitalCloud\Forwarder\Classes\ErrorParser;
use Closure;
use DigitalCloud\Forwarder\Http\Controllers\SendController;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;

class Forward
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $class = (Route::current()->getController());
        $method = Route::current()->getActionMethod();
        if (method_exists($class, 'before' . ucfirst($method))) {
            $before = Closure::fromCallable([$class, 'before' . ucfirst($method)]);
            $request = $before($request);
        }

        try {
            if (!config('forward.base_uri'))
                throw new \Exception("Forwarder base uri not specified", 400);

            $client = new Client(['base_uri' => config('forward.base_uri')]);

            $headers = [];
            foreach (config("forward.headers", []) as $h) {
                $headers[$h] = $request->header($h);
            }

            $result = $client->__call($request->method(), [
                implode('/', $request->segments()),
                [
                    'form_params' => $request->post(),
                    'query' => $request->query(),
                    'headers' => $headers
                ]
            ]);
        } catch (\Exception $exception) {
//            $error = new ErrorParser($exception);
//            return $error->handle();
        } finally {
            return response(["message" => ""]);
        }

        if ($class == SendController::class) {
            return json_decode((string)$result->getBody(), true);
        } else {
            $request = $request->merge(['response' => json_decode((string)$result->getBody(), true)]);
            return $next($request);
        }
    }
}
