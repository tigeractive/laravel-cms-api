<?php

namespace App\Rules;

use App\common\service\MenusService;
use App\common\service\RolesService;
use Illuminate\Support\Facades\Validator;

class MenusRule
{
    public static function menuCheckChild()
    {
        Validator::extend('check_child', function ($attribute, $value, $parameters, $validator) {
            // 检查值是否包含 'admin'
            $result = MenusService::getInstance()->isExistChildByParentId($value);
            if ($result) {
                return false;
            }
            return true;
        }, '');
    }
}
