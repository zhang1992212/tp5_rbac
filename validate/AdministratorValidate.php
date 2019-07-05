<?php

namespace geek1992\tp5_rbac\validate;

use think\Validate;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class AdministratorValidate extends Validate
{
    protected $rule = [
        ['account', 'require|max:200|unique:admin_administrator', '账号必须|账号最大长度200|账号已存在'],
        ['password', 'require|checkPassword', '密码必须'],
    ];

    protected $scene = [
    ];

    protected function checkPassword($value, $rule, $data)
    {
        if ($data['password'] !== $data['repwd']) {
            return '重复密码错误';
        }

        return true;
    }
}
