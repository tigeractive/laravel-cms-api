<?php

namespace App\Rules;

use App\common\service\Roles;
use Illuminate\Support\Facades\Validator;

class RolesRule
{
    public static function updateUnique()
    {
        Validator::extend('role_unique', function ($attribute, $value, $parameters, $validator) {
            // 检查值是否包含 'admin'
            $result = Roles::getInstance()->isUniqueRoleName($value, request()->input('role_id'));
            if ($result) {
                return false;
            }
            return true;
        }, '');
    }
}
