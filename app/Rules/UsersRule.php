<?php

namespace App\Rules;

use App\common\service\Users;
use Illuminate\Support\Facades\Validator;

class UsersRule
{
    public static function updateUnique()
    {
        Validator::extend('update_unique', function ($attribute, $value, $parameters, $validator) {
            // 检查值是否包含 'admin'
            $result = Users::getInstance()->isUniqueUserName($value, request()->input('user_id'));
            if ($result) {
                return false;
            }
            return true;
        }, '');
    }
}
