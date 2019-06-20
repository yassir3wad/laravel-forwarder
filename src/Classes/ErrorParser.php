<?php
/**
 * Created by PhpStorm.
 * User: mrajab
 * Date: 3/18/2019
 * Time: 11:49 AM
 */

namespace DigitalCloud\Forwarder\Classes;

use Exception;

class ErrorParser extends Exception
{
    public $exception;

    /**
     * ErrorParser constructor.
     * @param Exception $exception
     */
    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }

    public function handle()
    {
        switch ($this->exception->getCode()) {
            case 422:
                return $this->validation();
                break;

            default:
                return response(['message' => $this->exception->getMessage()], $this->exception->getCode());
                break;
        }
    }

    private function validation()
    {
        return response(json_decode(preg_split('/\r\n|\r|\n/', $this->exception->getMessage())[1], true), 422);
    }
}