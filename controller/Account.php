<?php


namespace geek1992\tp5_rbac\controller;


/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Account extends Base
{
    public function index()
    {
        return $this->myFetch('account/index');
    }
}