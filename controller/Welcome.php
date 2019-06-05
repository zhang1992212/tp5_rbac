<?php


namespace geek1992\tp5_rbac\controller;


/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Welcome extends Base
{
    /**
     * 首页
     *
     * @return mixed
     */
    public function index()
    {
        return $this->myFetch('welcome/index');
    }
}