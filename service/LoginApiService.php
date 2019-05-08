<?php

namespace geek1992\tp5_rbac\service;

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
        $where = ['account' => $account, 'password' => md5($password)];
        $info = $this->accountModel->getOneInfo($where);

        return $info;
    }
}
