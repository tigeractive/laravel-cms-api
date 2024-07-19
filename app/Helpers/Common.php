<?php

namespace App\Helpers;

use App\CodeResponse;
use App\Exceptions\ParameterException;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class Common
{
    public static function paginate()
    {
        $pageSize = intval(!empty(Request::input('page_size')) ? Request::input('page_size') : CodeResponse::PAGESIZE);
        $pageNum = intval(!empty(Request::input('page_num')) ? Request::input('page_num') : 1);

        $start = ($pageNum - 1) * $pageSize;

        if ($start < 0 || $pageSize < 0) throw new ParameterException();

        return [$start, $pageSize];
    }

    public static function packagePassword($password)
    {
        return sha1(sha1($password) . CodeResponse::PWDSALT);
    }

    public static function codeReturn(array $codeResponse, $data = null): \Illuminate\Http\JsonResponse
    {
        $result = ['msg' => $codeResponse['msg'], 'code' => $codeResponse['code']];
        if (!is_null($data)) {
            if (is_array($data)) {
                $data = array_filter($data, function ($item) {
                    return $item != null;
                });
            }
            $result['data'] = $data;
        }
        return response()->json($result, $codeResponse['httpCode'] ?? 200);
    }

    // 通过递归组织数据
    public static function unlimitedForLayer($data, $childName = 'children', $idName = 'id', $pid = 0, $level = 0): array
    {
        $arr = [];
        foreach ($data as $k => $v) {
            if ($v['parent_id'] == $pid) {
                $v['level'] = $level;
                $v[$childName] = self::unlimitedForLayer($data, $childName, $idName, $v[$idName], $level + 1);
                $arr[] = $v;
            }
        }
        return $arr;
    }

    public static function snakeToCamelKeys($array)
    {
        $result = [];
        foreach ($array as $key => $value) {
            // 将键名从蛇形转换为驼峰
            $camelKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));

            // 如果值是数组，递归转换
            if (is_array($value)) {
                $value = self::snakeToCamelKeys($value);
            }

            // 设置新的驼峰命名键和相应的值
            $result[$camelKey] = $value;
        }

        return $result;
    }

    public static function camelToSnake($input) {
        if (is_array($input)) {
            $output = [];
            foreach ($input as $key => $value) {
                // 转换键名
                $snakeKey = preg_replace_callback('/([A-Z])/', function ($matches) {
                    return '_' . strtolower($matches[0]);
                }, $key);

                // 如果键名的第一个字符是下划线，则去除
                $snakeKey = ltrim($snakeKey, '_');

                // 递归处理值，如果值是数组则继续转换
                $output[$snakeKey] = camelToSnake($value);
            }
            return $output;
        }

        // 如果不是数组，则直接返回原值
        return $input;
    }

    public static function filterArr($data)
    {
        return array_filter($data, function ($value) {
            return !is_null($value) && $value !== '';
        });
    }


}
