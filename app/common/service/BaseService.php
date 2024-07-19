<?php

namespace App\common\service;

class BaseService
{
    protected static $instance;

    public static function getInstance()
    {
        // static代表继承当前类
        if (static::$instance instanceof static) {
            return static::$instance;
        }

        return static::$instance = new static();
    }

    private function __construct()
    {

    }

    private function __clone()
    {

    }
}
