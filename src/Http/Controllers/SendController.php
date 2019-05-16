<?php

namespace DigitalCloud\Forwarder\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SendController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function send()
    {
        return request()->response;
    }
}
