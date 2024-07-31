<?php

namespace App\common\validate;

class RolesValidate extends BaseValidate
{
    protected $rule = [
        'role_name' => 'required|unique:roles',
        'role_id' => 'required'
    ];

    protected $message = [
        'role_name.required' => '角色名称不能为空',
        'role_name.unique' => '角色名称已经存在',
        'role_name.role_unique' => '角色名称已经存在',
        'role_id.required' => '角色id不能为空'
    ];

    protected $scene = [
        'add' => 'role_name.required|role_name.unique:roles',
        'edit' => 'role_name.required|role_name.role_unique',
        'del' => 'role_id.required'
    ];


}
