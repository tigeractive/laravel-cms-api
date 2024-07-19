<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Jwt;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    protected $only;
    protected $except;
    public function __construct()
    {
        $option = [];
        if (!is_null($this->only)) {
            $option['only'] = $this->only;
        }
        if (!is_null($this->except)) {
            $option['except'] = $this->except;
        }
        $this->middleware(Jwt::class, $option);
    }

}
