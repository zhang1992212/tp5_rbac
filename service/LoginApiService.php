<?php

namespace geek1992\tp5_rbac\service;

use geek1992\tp5_rbac\library\StringHelper;
use geek1992\tp5_rbac\model\Administrator;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class LoginApiService
{
    protected $administratorModel;

    public function __construct()
    {
        $this->administratorModel = new Administrator();
    }

    public function checkLogin($administrator, $password)
    {
        $condition = ['account' => $administrator, 'password' => StringHelper::getPassword($password)];
        $info = $this->administratorModel->getByCondition($condition, null, ['id', 'is_active']);

        return $info;
    }
}
