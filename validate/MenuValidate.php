<?php

namespace geek1992\tp5_rbac\validate;

use think\Validate;

class MenuValidate extends Validate
{
    protected $rule = [
        'name' => 'require|max:200',
        'icon' => 'max:200',
        'module' => 'max:200',
        'controller' => 'max:200',
        'action' => 'max:200',
        'type' => 'number',
        'level' => 'number',
        'order' => 'number',
        'parent_id' => 'number',
    ];

    protected $message = [
        'name.require' => '菜单名必须',
        'name.max' => '菜单名最大长度200',
        'icon.max' => '菜单名最大长度200',
        'module.max' => '菜单名最大长度200',
        'controller.max' => '菜单名最大长度200',
        'action.max' => '菜单名最大长度200',
        'type.number' => '类型必须是数字',
        'level.number' => '级别必须是数字',
        'order.number' => '排序必须是数字',
        'parent_id.number' => '父级ID必须是数字',
    ];

    protected $scene = [
    ];
}
