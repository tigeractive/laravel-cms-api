<?php

namespace App\Http\Admin;

use App\CodeResponse;
use App\common\service\Roles;
use App\common\service\Roles as RolesService;
use App\common\validate\Roles as RolesValidate;
use App\Helpers\Common;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Request;

class RolesController extends BaseController
{
    // 角色列表
    public function list(Request $request)
    {
        $params = $request::input();
        $list = RolesService::getInstance()->list($params);

        return Common::codeReturn(CodeResponse::SUCCESS, $list);
    }

    // 获取所有角色
    public function allRoles()
    {
        $list = RolesService::getInstance()->getAllRoles();

        return Common::codeReturn(CodeResponse::SUCCESS, $list);
    }

    // 角色添加、编辑
    public function operate(Request $request)
    {
        $params = $request::input();
        if ($params['action'] == CodeResponse::ADD) {
            $params = $request::input('filterData');
            return $this->add($params);
        } else if ($params['action'] == CodeResponse::EDIT) {
            return $this->edit($params);
        }
    }

    protected function add($params)
    {
        (new RolesValidate())->goCheck('add');
        $result = RolesService::getInstance()->add($params);
        if ($result) {
            return Common::codeReturn(CodeResponse::ROLESADDSUCCESS);
        }
        return Common::codeReturn(CodeResponse::ROLESADDFAIL);
    }

    protected function edit($params)
    {
        (new RolesValidate())->goCheck('edit');
        $result = RolesService::getInstance()->edit($params);
        if ($result) {
            return Common::codeReturn(CodeResponse::ROLESEDITSUCCESS);
        }
        return Common::codeReturn(CodeResponse::ROLESEDITFAIL);
    }

    // 删除
    public function del(Request $request)
    {
        (new RolesValidate())->goCheck('del');
        $params = $request::input();
        if (!empty($params['role_id'])) {
            // 超级管理员角色不能删除
            if ($params['role_id'] == 1) {
                return Common::codeReturn(CodeResponse::ROLESSUPERDELETEFAIL);
            }
            $result = RolesService::getInstance()->del($params['role_id']);
            if ($result) {
                return Common::codeReturn(CodeResponse::ROLESDELETESUCCESS);
            }

            return Common::codeReturn(CodeResponse::ROLESDELETEFAIL);
        }
    }

    // 更新权限
    public function updatePermission(Request $request)
    {
        $data = $request::input();
        $result = RolesService::getInstance()->updatePermission($data);
        if ($result) {
            return Common::codeReturn(CodeResponse::ROLESPERMISSIONSUCCESS);
        }

        return Common::codeReturn(CodeResponse::ROLESPERMISSIONFAIL);
    }

}
