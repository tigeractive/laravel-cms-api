<?php

namespace App\common\model\mysql;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Nette\Utils\DateTime;

class BaseModel extends Model
{
    public $timestamps = true;
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';



    // 访问器：当设置属性时转换日期到时间戳
    public function setCreateTimeAttribute($value)
    {
        // 如果传入的是日期实例或者可以解析为日期的字符串
        if ($value instanceof DateTime || ($value = strtotime($value)) !== false) {
            // 将日期转换为时间戳
            $this->attributes['create_time'] = $value;
        }
    }

    public function setUpdateTimeAttribute($value)
    {
        // 如果传入的是日期实例或者可以解析为日期的字符串
        if ($value instanceof DateTime || ($value = strtotime($value)) !== false) {
            // 将日期转换为时间戳
            $this->attributes['update_time'] = $value;
        }
    }

    public function getCreateTimeAttribute($value)
    {
        // 使用 Carbon::parse 解析时间字符串，并设置为中国时区（Asia/Shanghai）
        $chinaTime = Carbon::parse($value)->tz('Asia/Shanghai');

        return $chinaTime->toDateTimeString();
    }

    public function getUpdateTimeAttribute($value)
    {
        // 使用 Carbon::parse 解析时间字符串，并设置为中国时区（Asia/Shanghai）
        $chinaTime = Carbon::parse($value)->tz('Asia/Shanghai');

        return $chinaTime->toDateTimeString();
    }

}
