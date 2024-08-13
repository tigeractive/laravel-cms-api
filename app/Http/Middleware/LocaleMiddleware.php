<?php

namespace App\Http\Middleware;

use App\CodeResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 自动侦测设置获取语言选择
        $langSet = '';
        if ($request->input(CodeResponse::LANG)) {
            $langSet = $request->input(CodeResponse::LANG);
        } else if ($request->header(CodeResponse::LANG)) {
            $langSet = $request->header(CodeResponse::LANG);
        } else if ($request->cookie(CodeResponse::LANG)) {
            $langSet = $request->cookie(CodeResponse::LANG);
        } else if ($request->server('HTTP_ACCEPT_LANGUAGE')) {
            // 自动侦测浏览器语言
            $langSet = $request->server('HTTP_ACCEPT_LANGUAGE');
        }

        if (!empty($langSet)) {
            App::setLocale($langSet);
        }

        return $next($request);
    }
}
