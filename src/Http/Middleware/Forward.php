<?php

namespace DigitalCloud\Forwarder\Http\Middleware;

use DigitalCloud\Forwarder\Classes\ErrorParser;
use Closure;
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
    public function handle($request, Closure $next, $to)
    {
//        $class = (Route::current()->getController());
//        $method = Route::current()->getActionMethod();
//        if (method_exists($class, 'before' . ucfirst($method))) {
//            $before = Closure::fromCallable([$class, 'before' . ucfirst($method)]);
//            $request = $before($request);
//        }

        $client = new Client(['base_uri' => config('forward.base_uri')]);
        try {
            $result = $client->__call($request->method(), [
                implode('/', $request->segments()), [
                    'form_params' => $request->post(),
                    'query' => $request->query(),
                    'headers' => [
                        'Authorization' => $request->header('authorization'),
                        'Accept' => $request->header('accept'),
                        'App-Version' => $request->header('App-Version'),
                        'Agent' => $request->header('Agent'),
                    ]
                ]
            ]);
        } catch (\Exception $exception) {
            $error = new ErrorParser($exception);
            return $error->handle();
        }

        $request = $request->merge(['response' => json_decode((string)$result->getBody(), true)]);
        return $next($request);
    }
}
