<?php

namespace App\common\model\mysql;

use App\Helpers\Common;

class Roles extends BaseModel
{
    protected $primaryKey = 'role_id';

    protected $fillable = ['role_name', 'remark'];
    
    public function getMenuIdListAttribute($value)
    {
        return array_filter(explode(',', $value));
    }

    public function getFloorCheckedKeysAttribute($value)
    {
        if (!empty($value)) {
            return array_filter(explode(',', $value));
        }
    }

    public function getHasChildKeysAttribute($value)
    {
        if (!empty($value)) {
            return array_filter(explode(',', $value));
        }
    }

    // 获取角色列表
    public function getRoleList($where)
    {
        list($start, $pageSize) = Common::paginate();

        return self::query()->where($where)
            ->offset($start)
            ->limit($pageSize)
            ->orderBy('create_time', 'desc')
            ->get();
    }
}
