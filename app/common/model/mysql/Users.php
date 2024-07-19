<?php

namespace App\common\model\mysql;

use App\Helpers\Common;
use Illuminate\Support\Facades\Log;
use Nette\Utils\DateTime;

class Users extends BaseModel
{

    protected $primaryKey = 'user_id';

    protected $fillable = ['username', 'password', 'phone', 'job', 'state', 'role_list', 'lang'];

    protected $dates = ['create_time', 'update_time', 'login_time'];

    public function getRoleListAttribute($value)
    {
        return !empty($value) ? array_map('intval', explode(",", $value)) : '';
    }

    public function getLoginTimeAttribute($value)
    {
        return strtotime($value);
    }

    // 处理角色列表字段
    public function setRoleListAttribute($value)
    {
        if (!empty($value) && is_array($value)) {
            $this->attributes['role_list'] = implode(',', $value);
        } else {
            $this->attributes['role_list'] = '';
        }
    }

    public function getUserList($where = '')
    {
        list($start, $pageSize) = Common::paginate();
        return self::query()->where($where)
            ->offset($start)
            ->limit($pageSize)
            ->get();
    }

    public function edit($data)
    {
        $user = self::query()->find($data['user_id']);
        Log::error('user=>：' .  json_encode($user));
        if (!empty($data['password'])) {
            $data['password'] = Common::packagePassword($data['password']);
            $user->password = $data['password'];
        }
        $user->username = $data['username'];
        $user->phone = $data['phone'] ?? '';
        $user->job = $data['job'] ?? '';
        $user->state = $data['state'] ?? 1;
        $user->role_list = $data['role_list'] ?? '';

        Log::error('真是：' .  json_encode($data['role_list']));

        return $user->save();
    }

    public function del($data)
    {
        return self::destroy($data['user_id']);
    }

}
