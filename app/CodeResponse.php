<?php

namespace App;

class CodeResponse
{
    const LANG = 'lang';

    // 通用返回码
    const SUCCESS = ['code' => 200, 'httpCode' => 200];
    const FAIL = ['code' => 402, 'httpCode' => 402];

    const TOKENFAIL = ['code' => 500001, 'httpCode' => 402];
    const LOGINERROR = ['code' => 402];

    // 默认页数
    const PAGESIZE = 10;

    // 密码盐
    const PWDSALT = 'southtiger112';

    // 操作标识
    const ADD = 'add';
    const EDIT = 'edit';

    // 用户添加
    const USERADDSUCCESS = ['code' => 200, 'httpCode' => 200];
    const USERADDFAIL = ['code' => 200, 'httpCode' => 200];
    // 用户编辑
    const USEREDITSUCCESS = ['code' => 200, 'httpCode' => 200];
    const USEREDITFAIL = ['code' => 200, 'httpCode' => 200];
    //用户删除
    const USERDELSUCCESS = ['code' => 200, 'httpCode' => 200];
    const USERDELFAIL = ['code' => 200, 'httpCode' => 200];


    // 角色
    const ROLESADDSUCCESS = ['code' => 200, 'httpCode' => 200];
    const ROLESADDFAIL = ['code' => 402, 'httpCode' => 200];
    const ROLESEDITSUCCESS = ['code' => 200, 'httpCode' => 200];
    const ROLESEDITFAIL = ['code' => 402, 'httpCode' => 200];
    const ROLESPERMISSIONSUCCESS = ['code' => 200, 'httpCode' => 200];
    const ROLESPERMISSIONFAIL = ['code' => 402, 'httpCode' => 200];

    const ROLESDELETESUCCESS = ['code' => 200, 'httpCode' => 200];
    const ROLESSUPERDELETEFAIL = ['code' => 402, 'httpCode' => 200];
    const ROLESDELETEFAIL = ['code' => 402, 'httpCode' => 200];

    // 菜单
    const MENUSADDSUCCESS = ['code' => 200, 'httpCode' => 200];
    const MENUSADDFAIL = ['code' => 402, 'httpCode' => 200];
    const MENUSEDITSUCCESS = ['code' => 200, 'httpCode' => 200];
    const MENUSEDITFAIL = ['code' => 402, 'httpCode' => 200];
    const MENUSDELSUCCESS = ['code' => 200, 'httpCode' => 200];
    const MENUSDELFAIL = ['code' => 402, 'httpCode' => 200];
}
