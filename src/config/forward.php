<?php
/**
 * Created by PhpStorm.
 * User: Digital 2
 * Date: 2/28/2019
 * Time: 12:19 PM
 */

return [
    'base_uri' => env("FORWARD_URI"),
    "headers" => [
        'authorization',
        'accept',
        'app-version',
        'agent'
    ],
    "methods" => ['get', 'post', 'delete', 'put', 'patch']
];