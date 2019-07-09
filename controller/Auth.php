<?php

namespace geek1992\tp5_rbac\controller;

use geek1992\tp5_rbac\library\Formatter;
use think\Exception;
use think\Request;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
abstract class Auth extends Base
{
    private $Router = [
        'login' => 'geek1992\tp5_rbac\controller\Login',
        'administrator' => 'geek1992\tp5_rbac\controller\Administrator',
        'welcome' => 'geek1992\tp5_rbac\controller\Welcome',
        'menu' => 'geek1992\tp5_rbac\controller\Menu',
        'role' => 'geek1992\tp5_rbac\controller\Role',
        'administratorlog' => 'geek1992\tp5_rbac\controller\AdministratorLog',
        'loginlog' => 'geek1992\tp5_rbac\controller\LoginLog',
    ];

    public function _empty($name)
    {
        $method = Request::instance()->param('method', null);
        $controller = $this->Router[$name] ?? $this->Router['login'];
        if (method_exists($controller, $method)) {
            if (isset($this->Router[$name]) && 'Index' === Request::instance()->controller()) {
                Request::instance()->isSystemMenu = '1';
            }
            return \call_user_func([new $controller(), $method], Request::instance());
//            try {
//                return \call_user_func([new $controller(), $method], Request::instance());
//            } catch (Exception $e) {
//                return $this->errorMsg('服务器内部错误',500);
//            }
        }
        //错误页面返回
        if (session('errors') !== null) {
            if (Request::instance()->isAjax()) {
                return Formatter::newInstance()->badRequest(session('msg'), session('code'))->format();
            }
            return $this->notFound(session('code'), session('msg'));
        }
        return $this->NotFound();
    }
}
