<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    private $httpCode;
    private $code;
    private $msg;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof BaseException) {
            // 如果是自定义异常
            $this->httpCode = $e->httpCode;
            $this->msg = $e->msg;
            $this->code = $e->code;
        } else {
            if (ENV::get('APP_DEBUG')) {
                return parent::render($request, $e); // TODO: Change the autogenerated stub
            } else {
                $this->httpCode = 503;
                $this->msg = '内部错误';
                $this->code = 999;
                Log::debug('内部错误：' . $e->getMessage());
            }
        }
        $request = Request::instance();

        $result = [
            'msg' => $this->msg,
            'code' => $this->code,
            'request_url' => $request->url()
        ];
        return response($result, $this->httpCode);
    }

}
