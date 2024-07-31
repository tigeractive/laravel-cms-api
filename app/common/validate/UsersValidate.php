<?php

namespace App\common\validate;

class UsersValidate extends BaseValidate
{
    protected $rule = [
        'username' => 'required|unique:users',
        'password' => 'required',
    ];

    protected $message = [
        'username.required' => '用户名称不能为空！',
        'username.unique' => '用户名称已存在！',
        'password.required' => '密码不能为空！',
        'username.update_unique' => '用户名称已存在！'
    ];

    protected $scene = [
        'edit' => 'username.update_unique|username.required',
    ];

}
