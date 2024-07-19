<?php

namespace App\Exceptions;

class BaseException extends \Exception
{
    // HTTP 状态码
    public $httpCode = 400;

    // 错误具体信息
    public $msg = '参数错误';

    // 自定义的错误码
    public $code = 400;

    public function __construct($params = [])
    {
        if (!is_array($params)) {
            return;
        }

        if (array_key_exists('httpCode', $params)) {
            $this->httpCode = $params['httpCode'];
        }


        if (array_key_exists("msg", $params)) {
            $this->msg = $params['msg'];
        }

        if (array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }

    }

}
