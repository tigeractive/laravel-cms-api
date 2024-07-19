<?php

namespace App\Exceptions;

class ParameterException extends BaseException
{
    public $httpCode = 200;
    public $code = 400;
    public $msg = 'invalid parameters';
}
