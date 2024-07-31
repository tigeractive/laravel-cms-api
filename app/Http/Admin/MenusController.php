<?php

namespace App\Http\Admin;

use App\CodeResponse;
use App\common\service\MenusService;
use App\common\service\RolesService;
use App\common\validate\MenusValidate;
use App\Helpers\Common;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class MenusController extends BaseController
{
    // 获取菜单列表
    public function list(Request $request)
    {
        $params = Request::input();
        $list = MenusService::getInstance()->getMenuList($params);
        return Common::show(CodeResponse::SUCCESS, $list);
    }

    public function parentList()
    {
        $list = MenusService::getInstance()->getAllMenuList();
        return Common::show(CodeResponse::SUCCESS, $list);
    }

    public function operate(Request $request)
    {
        $data = $request::input();
        $data = Common::trimArr($data);
        (new MenusValidate())->goCheck('operate');
        if ($data['action'] === CodeResponse::ADD) {
            return $this->add($data);
        } else if ($data['action'] === CodeResponse::EDIT) {
            return $this->edit($data);
        }
    }

    protected function add($data)
    {
        $result = MenusService::getInstance()->add($data);
        if ($result) {
            return Common::show(CodeResponse::MENUSADDSUCCESS);
        }

        return Common::show(CodeResponse::MENUSADDFAIL);
    }

    protected function edit($data)
    {
        $result = MenusService::getInstance()->edit($data);
        if ($result) {
            return Common::show(CodeResponse::MENUSEDITSUCCESS);
        }
        return Common::show(CodeResponse::MENUSEDITFAIL);
    }

    // 删除
    public function del(Request $request)
    {
        (new MenusValidate())->goCheck('del');
        $data = $request::input();
        if (!empty($data['menu_id'])) {
            DB::beginTransaction();
            try {
                $result = MenusService::getInstance()->del($data['menu_id']);
                Log::error('发生异常：' . $result);
                RolesService::getInstance()->updateMenuIdList($data['menu_id']);
                // 如果没有异常，则提交事务
                DB::commit();
                if ($result) {
                    return Common::show(CodeResponse::MENUSDELSUCCESS);
                }
                return Common::show(CodeResponse::MENUSDELFAIL);
            } catch (\Exception $e) {
                // 如果捕获到异常，则回滚事务
                DB::rollBack();
            }

        }

    }

}
