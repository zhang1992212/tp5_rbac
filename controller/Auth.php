<?php

namespace geek1992\tp5_rbac\controller;

use think\Exception;
use think\Request;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
abstract class Auth extends Base
{
    private $Router = [
      'login' => 'geek1992\tp5_rbac\controller\Login',
      'account' => 'geek1992\tp5_rbac\controller\Account',
      'welcome' => 'geek1992\tp5_rbac\controller\Welcome',
      'menu' => 'geek1992\tp5_rbac\controller\Menu',
      'role' => 'geek1992\tp5_rbac\controller\Role',
    ];

    public function _empty($name)
    {
        $method = Request::instance()->param('method', 'login');
        $controller = $this->Router[$name] ?? $this->Router['login'];
        if (method_exists($controller, $method)) {
            if ('index' === Request::instance()->module() && 'Index' === Request::instance()->controller()) {
                Request::instance()->isSystemMenu = '1';
            }
            try {
                return \call_user_func([new $controller(), $method], Request::instance());
            } catch (Exception $e) {
                return $this->errorMsg('服务器内部错误',500);
            }
        }

        return abort(404, '页面不存在');
    }
}
