<?php

namespace App\common\service;

use App\common\model\mysql\UsersModel as UsersModel;
use App\Helpers\Common;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersService extends BaseService
{
    public $model = null;

    public function __construct()
    {
        $this->model = new UsersModel();
    }

    public function getUserByUserId($userId)
    {
        return $this->model::query()->where('user_id', $userId)->first();
    }

    public function getUserByName($userName)
    {
        return $this->model::query()->where('username', $userName)->first();
    }

    public function getUserList($params = [])
    {
        // 查询条件的组装
        $where = [];
        if (!empty($params['user_id'])) {
            $where[] = ['user_id', '=', $params['user_id']];
        }
        if (!empty($params['username'])) {
            $where[] = ['username', 'like', '%' . $params['username'] . '%'];
        }
        if (!empty($params['state'])) {
            $where[] = ['state', '=', $params['state']];
        }

        // 隐藏超级管理员
//        $where[] = ['user_id', '<>', 1];
        $list = $this->model->getUserList($where);
        $total = $this->model::query()->where($where)->count();
        if (empty($list)) {
            return [];
        }
        $page = [
            'total' => $total
        ];

        return [
            'list' => $list->toArray(),
            'page' => $page
        ];
    }

    // 登录时间修改，登录ip修改
    public function updateLoginInfo($userId)
    {
        $result = $this->model::query()->where('user_id', $userId)
            ->update([
                'login_time' => time(),
                'login_ip' => request()->ip(),
                'update_time' => DB::raw('update_time')   // 禁用update_time自动更新
            ]);
    }

    public function add($data)
    {
        return $this->model::query()->create($data);
    }

    public function edit($data)
    {
        return $this->model->edit($data);
    }

    // 更新用户名，确保唯一
    public function isUniqueUserName($userName, $userId)
    {
        return $this->model::query()->where('user_id', '<>', $userId)
            ->where('username', $userName)
            ->first();
    }

}
