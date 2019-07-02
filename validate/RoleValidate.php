<?php

namespace geek1992\tp5_rbac\validate;

use think\Validate;

class RoleValidate extends Validate
{
    protected $rule = [
        'name' => 'require|max:200',
    ];

    protected $message = [
        'name.require' => '角色名必须',
        'name.max' => '角色名最大长度200',
    ];

    protected $scene = [
    ];
}
