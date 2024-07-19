<?php

namespace App\common\validate;

use App\Exceptions\ParameterException;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class BaseValidate extends Validator
{
    protected $rule = [
        'a' => 'required|date',
        'b' => 'required'
    ];

    protected $message = [
        'a.required' => 'a必须要有值'
    ];

    protected $scene = [
        'add' => ['a.required|a.date', 'b']
    ];

    protected $currentScene = null;

    protected $error = [];

    /**
     * 场景需要验证的规则
     * @var array
     */
    protected $currentRule = [];

    protected $tmpRule = [];

    public function scene($name)
    {
        $this->currentScene = $name;
        return $this;
    }

    // 获取错误信息
    public function getError()
    {
        return $this->error;
    }

    protected function getScence($scene = ''): bool
    {
        if (empty($scene)) {
            return false;
        }

        $this->tmpRule = [];
        $scene = $this->scene[$scene];
        if (isset($scene) && is_string($scene)) {
            $scene = explode(',', $scene);
        }
        $this->tmpRule = $scene;
        return true;
    }

    protected function assembleRule($rule)
    {
        $rule = explode('.', $rule);
        if (array_key_exists($rule[0], $this->rule)) {
            if (isset($this->currentRule[$rule[0]])) {
                $this->currentRule[$rule[0]] = $this->currentRule[$rule[0]] . '|' . $rule[1];
            } else {
                $this->currentRule[$rule[0]] = $rule[1];
            }
        }
    }

    public function goCheck($scene = '')
    {
        if ($this->getScence($scene)) {
            if (!empty($this->tmpRule)) {
                $newRule = [];
                foreach ($this->tmpRule as $key => $val) {
                    if (strpos($val, '|') !== false) {
                        $val = explode('|', $val);
                        foreach ($val as $k => $v) {
                            if (strpos($v, '.') !== false) {
                                $this->assembleRule($v);
                            }
                        }
                    } else if (strpos($val, '.') !== false) {
                        $rule = explode('.', $val);
                        $this->assembleRule($val);
                    } else {
                        if (array_key_exists($val, $this->rule)) {
                            $this->currentRule[$val] = $this->rule[$val];
                        }
                    }
                }
            }
        } else {
            $this->currentRule = $this->rule;
        }

        $request = Request::instance();
        $validator = Validator::make($request->toArray(), $this->currentRule, $this->message);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0];
            });
            throw new ParameterException([
                'msg' => implode("", $errors->toArray())
            ]);
        }

        return true;
    }
}
