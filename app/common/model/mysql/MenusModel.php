<?php

namespace App\common\model\mysql;

use Illuminate\Database\Eloquent\Model;

class MenusModel extends BaseModel
{
    protected  $table = 'menus';
    protected $primaryKey = 'menu_id';

    protected $fillable = [
        'menu_name',
        'menu_type',
        'menu_multilang',
        'icon',
        'path',
        'component',
        'url',
        'menu_code',
        'menu_state',
        'parent_id_list',
        'parent_id',
        'sort_id'
    ];

    protected $attributes = [
        'menu_multilang' => ''
    ];

    protected $hidden = ['create_time', 'update_time'];

    public function getMenuList($where)
    {
        return self::query()->where($where)
            ->orderBy('sort_id', 'DESC')
            ->get();
    }
}
