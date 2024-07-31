<?php

namespace App\common\validate;

class MenusValidate extends BaseValidate
{
    protected $rule = [
        'menu_name' => 'required',
        'menu_id' => 'required|check_child',
        'sort_id' => 'numeric'
    ];

    protected $message = [
        'menu_name.required' => '菜单名称不能为空',
        'menu_id.required' => '菜单id不能为空',
        'menu_id.check_child' => '该菜单下面有子类，请先删除子类',
        'sort_id.numeric' => '排序数字必须为整数'
    ];

    protected $scene = [
        'operate' => 'menu_name.required|sort_id',
        'del' => 'menu_id.required|menu_id.check_child|sort_id'
    ];
}
