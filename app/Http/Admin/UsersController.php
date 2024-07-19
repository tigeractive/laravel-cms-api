<?php

namespace App\Http\Admin;

use App\CodeResponse;
use App\common\model\mysql\Users;
use App\common\model\mysql\Users as UsersModel;
use App\common\service\AdminToken;
use App\common\service\Users as UsersSerive;
use App\common\validate\Users as UsersValidate;
use App\Helpers\Common;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class UsersController extends BaseController
{
    protected $except = [
        'getToken',
        'login'
    ];

    // 用户登录
    public function login(Request $request)
    {
        // 判断用户是否存在
        $user = (UsersSerive::getInstance())->getUserByName($request::input('username'));
        if (empty($user)) {
            return Common::codeReturn(CodeResponse::LOGINERROR);
        }
        // 判断密码是否正确
        if ($user->password != Common::packagePassword($request::input('password'))) {
            return Common::codeReturn(CodeResponse::LOGINERROR);
        }

        $user = $user->toArray();

        // 修改登录信息
        UsersSerive::getInstance()->updateLoginInfo($user['user_id']);


//        $menuList = $request::input('menuList');
        // 组装token,这个不是字符串，要转化字符串则$token->toString()
        $token = AdminToken::getInstance()->generateToken('user_id', $user['user_id'], '+12 hour');

        $data = [
            'username' => $user['username'],
            'token' => $token->toString()
        ];

        return Common::codeReturn(CodeResponse::SUCCESS, $data);
    }

    public function getToken()
    {
        return AdminToken::getInstance()->generateToken('user_id', '1', '+300 hour')->toString();
    }

    public function list(Request $request)
    {
        $params = $request::input();
        $result = (new UsersSerive())->getUserList($params);
        return Common::codeReturn(CodeResponse::SUCCESS, $result);
    }

    public function getPermissionList(Request $request)
    {
        $data = [
            "menuList" => $request::input('menuList'),
            "actionList" => $request::input('actionList')
        ];

        return Common::codeReturn(CodeResponse::SUCCESS, $data);
    }

    public function operate(Request $request)
    {
        $data = $request::input();
        if (isset($data['action'])) {
            if ($data['action'] == CodeResponse::ADD) {
                return $this->add($data);
            } else if ($data['action'] == CodeResponse::EDIT) {
                return $this->edit($data);
            }
        }
    }

    protected function add($data)
    {
        (new UsersValidate())->goCheck();
        $data['password'] = Common::packagePassword($data['password']);
        $data = Common::filterArr($data);
        $result = UsersSerive::getInstance()->add($data);
        if ($result) {
            return Common::codeReturn(CodeResponse::USERADDSUCCESS);
        }

        return Common::codeReturn(CodeResponse::USERADDFAIL);
    }

    protected function edit($data)
    {
        (new UsersValidate())->goCheck('edit');
        $result = UsersSerive::getInstance()->edit($data);
        if ($result) {
            return Common::codeReturn(CodeResponse::USEREDITSUCCESS);
        }

        return Common::codeReturn(CodeResponse::USEREDITFAIL);
    }

    // 单个/批量删除 硬删除
    public function delUsers(Request $request)
    {
        $data = $request::input();
        if (!empty($data['user_id'])) {
            if ($data['user_id'] == 1) {
                return Common::codeReturn(CodeResponse::USERDELFAIL);
            }
            $result = (new UsersModel())->del($data);
            if ($result) {
                return Common::codeReturn(CodeResponse::USERDELSUCCESS);
            }

            return Common::codeReturn(CodeResponse::USERDELFAIL);
        }
    }


}
