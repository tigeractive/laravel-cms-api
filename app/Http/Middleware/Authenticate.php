<?php

namespace App\Http\Middleware;

use App\Exceptions\ParameterException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    protected function unauthenticated($request, array $guards)
    {
        if ($request->expectsJson() || in_array('admin', $guards)) {
            throw new ParameterException();
        }
        parent::unauthenticated($request, $guards);
    }
}
