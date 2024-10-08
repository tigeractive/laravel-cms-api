<?php

namespace App\Http\Admin;

use App\CodeResponse;
use App\common\service\RolesService;
use App\common\validate\RolesValidate as RolesValidate;
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

        return Common::show(CodeResponse::SUCCESS, '', $list);
    }

    // 获取所有角色
    public function allRoles()
    {
        $list = RolesService::getInstance()->getAllRoles();

        return Common::show(CodeResponse::SUCCESS, '', $list);
    }

    // 角色添加、编辑
    public function operate(Request $request)
    {
        $params = $request::input();
        $params = Common::trimArr($params);
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
            return Common::show(CodeResponse::ROLESADDSUCCESS, trans('messages.RolesAddSuccess'));
        }
        return Common::show(CodeResponse::ROLESADDFAIL, trans('messages.RolesAddFail'));
    }

    protected function edit($params)
    {
        (new RolesValidate())->goCheck('edit');
        $result = RolesService::getInstance()->edit($params);
        if ($result) {
            return Common::show(CodeResponse::ROLESEDITSUCCESS, trans('messages.RolesEditSuccess'));
        }
        return Common::show(CodeResponse::ROLESEDITFAIL, trans('messages.RolesEditFail'));
    }

    // 删除
    public function del(Request $request)
    {
        (new RolesValidate())->goCheck('del');
        $params = $request::input();
        if (!empty($params['role_id'])) {
            // 超级管理员角色不能删除
            if ($params['role_id'] == 1) {
                return Common::show(CodeResponse::ROLESSUPERDELETEFAIL, trans('messages.RolesSuperDeleteFail'));
            }
            $result = RolesService::getInstance()->del($params['role_id']);
            if ($result) {
                return Common::show(CodeResponse::ROLESDELETESUCCESS, trans('messages.RolesDeleteSuccess'));
            }

            return Common::show(CodeResponse::ROLESDELETEFAIL, trans('messages.RolesDeleteFail'));
        }
    }

    // 更新权限
    public function updatePermission(Request $request)
    {
        $data = $request::input();
        $result = RolesService::getInstance()->updatePermission($data);
        if ($result) {
            return Common::show(CodeResponse::ROLESPERMISSIONSUCCESS, trans('messages.RolesPermissionSuccess'));
        }

        return Common::show(CodeResponse::ROLESPERMISSIONFAIL, trans('messages.RolesPermissionFail'));
    }

}
