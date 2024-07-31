<?php

namespace App\Http\Middleware;

use App\common\service\AdminToken;
use App\common\service\MenusService as MenusService;
use App\common\service\RolesService as RolesService;
use App\common\service\UsersService as UsersService;
use App\Exceptions\PrivilegeException;
use App\Exceptions\TokenException;
use App\Exceptions\TokenExpireException;
use App\Helpers\Common;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Jwt
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $requestUrl = $request->getPathInfo();
        if (empty($request->header()['authorization'])) {
            throw new TokenException();
        }
        $token = $request->header()['authorization'];
        $token = explode(' ', $token[0])[1];
        $userId = AdminToken::getInstance()->getClaim($token, 'user_id');
        // 判断token是否合法
        if (!AdminToken::getInstance()->isMy($token)) {
            throw new TokenException();
        }

        // 判断token是否已过期
        if (AdminToken::getInstance()->isExpired($token)) {
            throw new TokenExpireException();
        }

        $user = UsersService::getInstance()->getUserByUserId($userId);
        if (empty($user)) {
            throw new TokenException();
        }

        // 看该用户是否用该权限，进行拦截
        $roles = RolesService::getInstance()->getRoleListByRoleIds($user->role_list);
        if (!empty($roles)) {
            $menuListId = [];
            foreach ($roles->toArray() as $k => $v) {
                foreach ($v['menu_id_list'] as $k2 => $v2) {
                    if (!empty($v2)) {
                        $menuListId[] = intval($v2);
                    }
                }
            }
            $menuListId = array_unique($menuListId);
            // 获取该用户权限菜单
            $menus = MenusService::getInstance()->getMenuListByMenuIds($menuListId);
            if (empty($menus)) {
                throw new PrivilegeException();
            }
            $menus = $menus->toArray();
            $getPriUrl = '/admin/users/permission';
            $priArr = [$getPriUrl];
            $actionList = [];
            foreach ($menus as $k => $v) {
                if (!empty($v['url'])) {
                    $priArr[] = $v['url'];
                }
                if ($v['menu_type'] == 2) {
                    $actionList[] = $v['menu_code'];
                }
            }
            if (!in_array($requestUrl, $priArr)) {
                throw new PrivilegeException();
            }

            $menuList = Common::unlimitedForLayer($menus, 'children', 'menu_id');

            if ($getPriUrl === $requestUrl) {
                $request->merge([
                    'actionList' => $actionList,
                    'menuList' => $menuList
                ]);
            }

        }

        // 过滤空字段，添加数据更方便
        $filterData = $request->input();
        $filterData = Common::filterArr($filterData);
        if (!empty($filterData)) {
            $request->merge([
                'filterData' => $filterData
            ]);
        }

        $response = $next($request);
        $content = $response->getOriginalContent();

        // 将返回字段从蛇形转为驼峰
        if (!empty($content['data'])) {
            $content['data'] = Common::snakeToCamelKeys($content['data']);
            $response->setContent(json_encode($content, JSON_UNESCAPED_UNICODE));
        }

        return $response;

    }


}
