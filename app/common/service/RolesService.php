<?php

namespace App\common\service;

use App\common\model\mysql\RolesModel as RolesModel;
use Illuminate\Support\Facades\DB;

class RolesService extends BaseService
{
    public $model = null;

    public function __construct()
    {
        $this->model = new RolesModel();
    }

    public function getRoleListByRoleIds($roleIds)
    {
        return $this->model::query()->whereIn('role_id', $roleIds)->get();
    }

    public function list($params)
    {
        // 查询条件组装
        $where = [];
        if (!empty($params['role_name'])) {
            $where[] = ['role_name', 'like', '%' . $params['role_name'] . '%'];
        }
        $list = $this->model->getRoleList($where);
        $total = $this->model::query()->where($where)->count();
        $page = [
            'total' => $total
        ];

        if (!$list) {
            return [];
        }

        return [
            'list' => $list->toArray(),
            'page' => $page
        ];
    }

    // 获取所有角色
    public function getAllRoles()
    {
        return $this->model::query()->get()->toArray();
    }

    // 替换menu_id_list、floor_checked_keys、has_child_keys中的菜单id(因为删除菜单，需要去掉相应的菜单id)
    public function updateMenuIdList($menuId)
    {
        $menuIdStr = "$menuId" .  ',';
        $sql = "update tg_roles set menu_id_list=replace(menu_id_list," . "'" . $menuIdStr . "'" . ",'')" . ",floor_checked_keys=replace(floor_checked_keys," . "'" . $menuIdStr . "'" . ",'')" . ",has_child_keys=replace(has_child_keys," . "'" . $menuIdStr . "'" . ",'')";
        DB::statement($sql);
    }

    // 更新角色名，确保唯一
    public function isUniqueRoleName($roleName, $roleId)
    {
        return $this->model::query()->where('role_id', '<>', $roleId)
            ->where('role_name', $roleName)
            ->first();
    }

    // 添加
    public function add($params)
    {
        return $this->model::query()->create($params);
    }

    // 编辑
    public function edit($params)
    {
        $role = $this->model::query()->find($params['role_id']);
        $role->role_name = $params['role_name'] ?? '';
        $role->remark = $params['remark'] ?? '';
        return $role->save();
    }

    // 删除
    public function del($params)
    {
        return $this->model::destroy($params);
    }

    // 更新权限
    public function updatePermission($data)
    {
        if (empty($data['menu_id_list'])) {
            $data['menu_id_list'] = '';
        } else if (is_array($data['menu_id_list'])) {
            $data['menu_id_list'] = implode(',', $data['menu_id_list']) . ',';
        }

        if (empty($data['floor_checked_keys'])) {
            $data['floor_checked_keys'] = '';
        } else if (is_array($data['floor_checked_keys'])) {
            $data['floor_checked_keys'] = implode(',', $data['floor_checked_keys']) . ',';
        }

        if (empty($data['has_child_keys'])) {
            $data['has_child_keys'] = '';
        } else if (is_array($data['has_child_keys'])) {
            $data['has_child_keys'] = implode(',', $data['has_child_keys']) . ',';
        }

        $role = $this->model::query()->find($data['role_id']);
        $role->menu_id_list = $data['menu_id_list'];
        $role->floor_checked_keys = $data['floor_checked_keys'];
        $role->has_child_keys = $data['has_child_keys'];

        return $role->save();
    }

}
