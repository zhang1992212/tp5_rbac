<?php

namespace geek1992\tp5_rbac\service;

use geek1992\tp5_rbac\library\StringHelper;
use geek1992\tp5_rbac\model\Account;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class LoginApiService
{
    protected $accountModel;

    public function __construct()
    {
        $this->accountModel = new Account();
    }

    public function checkLogin($account, $password)
    {
        $condition = ['account' => $account, 'password' =>StringHelper::getPassword($password)];
        $info = $this->accountModel->getByCondition($condition, null, ['id', 'is_active']);

        return $info;
    }
}
