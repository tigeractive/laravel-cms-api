<?php

use App\Http\Admin\AuthController;
use App\Http\Admin\RolesController;
use Illuminate\Support\Facades\Route;
use App\Http\Admin\UsersController;
use App\Http\Admin\MenusController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group([
    'prefix' => 'admin'
], function () {
    // 用户
    Route::post('/users/login', [UsersController::class, 'login']);
    Route::get('/users/test', [UsersController::class, 'test']);
    Route::get('/users/token', [UsersController::class, 'getToken']);
    Route::get('/users/list', [UsersController::class, 'list']);
    Route::get('/users/permission', [UsersController::class, 'getPermissionList']);
    Route::post('/users/operate', [UsersController::class, 'operate']);
    Route::post('/users/del', [UsersController::class, 'delUsers']);
    Route::get('/users/user-role', [UsersController::class, 'userRole']);

    // 角色
    Route::get('/roles/list', [RolesController::class, 'list']);
    Route::get('/roles/all', [RolesController::class, 'allRoles']);
    Route::post('/roles/operate', [RolesController::class, 'operate']);
    Route::post('/roles/del', [RolesController::class, 'del']);
    Route::post('/roles/update-permission', [RolesController::class, 'updatePermission']);

    // 菜单
    Route::get('/menus/list', [MenusController::class, 'list']);
    Route::get('/menus/parent-list', [MenusController::class, 'parentList']);
    Route::post('/menus/operate', [MenusController::class, 'operate']);
    Route::post('/menus/del', [MenusController::class, 'del']);

});

