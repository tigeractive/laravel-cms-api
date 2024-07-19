<?php

namespace App;

class CodeResponse
{
    // 通用返回码
    const SUCCESS = ['msg' => '', 'code' => 200, 'httpCode' => 200];
    const FAIL = ['msg' => '', 'code' => 402, 'httpCode' => 402];

    const TOKENFAIL = ['msg' => 'token非法', 'code' => 500001, 'httpCode' => 402];
    const LOGINERROR = ['msg' => '用户名或者密码不正确！', 'code' => 402];

    // 默认页数
    const PAGESIZE = 10;

    // 密码盐
    const PWDSALT = 'southtiger112';

    // 操作标识
    const ADD = 'add';
    const EDIT = 'edit';

    // 用户添加
    const USERADDSUCCESS = ['msg' => '用户添加成功', 'code' => 200, 'httpCode' => 200];
    const USERADDFAIL = ['msg' => '用户添加失败', 'code' => 200, 'httpCode' => 200];
    // 用户编辑
    const USEREDITSUCCESS = ['msg' => '用户更新成功', 'code' => 200, 'httpCode' => 200];
    const USEREDITFAIL = ['msg' => '用户更新失败', 'code' => 200, 'httpCode' => 200];
    //用户删除
    const USERDELSUCCESS = ['msg' => '用户删除成功', 'code' => 200, 'httpCode' => 200];
    const USERDELFAIL = ['msg' => '用户删除失败', 'code' => 200, 'httpCode' => 200];


    // 角色
    const ROLESADDSUCCESS = ['msg' => '角色添加成功', 'code' => 200, 'httpCode' => 200];
    const ROLESADDFAIL = ['msg' => '角色添加失败', 'code' => 200, 'httpCode' => 200];
    const ROLESEDITSUCCESS = ['msg' => '角色编辑成功', 'code' => 200, 'httpCode' => 200];
    const ROLESEDITFAIL = ['msg' => '角色编辑失败', 'code' => 200, 'httpCode' => 200];
    const ROLESPERMISSIONSUCCESS = ['msg' => '角色编辑成功', 'code' => 200, 'httpCode' => 200];
    const ROLESPERMISSIONFAIL = ['msg' => '角色编辑失败', 'code' => 200, 'httpCode' => 200];

    const ROLESDELETESUCCESS = ['msg' => '角色删除成功', 'code' => 200, 'httpCode' => 200];
    const ROLESSUPERDELETEFAIL = ['msg' => '超级管理员角色不能删除', 'code' => 200, 'httpCode' => 200];
    const ROLESDELETEFAIL = ['msg' => '角色删除失败', 'code' => 200, 'httpCode' => 200];

    // 菜单
    const MENUSADDSUCCESS = ['msg' => '菜单添加成功', 'code' => 200, 'httpCode' => 200];
    const MENUSADDFAIL = ['msg' => '菜单添加失败', 'code' => 200, 'httpCode' => 200];
    const MENUSEDITSUCCESS = ['msg' => '菜单更新成功', 'code' => 200, 'httpCode' => 200];
    const MENUSEDITFAIL = ['msg' => '菜单更新失败', 'code' => 200, 'httpCode' => 200];
    const MENUSDELSUCCESS = ['msg' => '菜单删除成功', 'code' => 200, 'httpCode' => 200];
    const MENUSDELFAIL = ['msg' => '菜单删除失败', 'code' => 200, 'httpCode' => 200];
}
