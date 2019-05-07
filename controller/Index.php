<?php
namespace geek1992\tp5_rbac\controller;

use think\Request;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Index extends Base
{
    public function index(Request $request)
    {
        
        return $this->myFetch('index/index');
    }

//    public function login(Request $request)
//    {
//        if ($request->isPost()) {
//
//        }
//    }
}