<?php

namespace geek1992\tp5_rbac\controller;

use geek1992\tp5_rbac\model\Menu;
use think\Config;
use think\Controller;
use think\Request;


\defined('DS') or \define('DS', \DIRECTORY_SEPARATOR);
\defined('VIEW_PATH') or \define('VIEW_PATH', __DIR__.DS.'..'.DS.'view'.DS);
\defined('STATIC_PATH') or \define('STATIC_PATH', DS.'public'.DS.'..'.DS.'vendor'.DS.'geek1992'.DS.'tp5_rbac'.DS.'view'.DS);

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Base extends Controller
{
    protected const NO_AUTH_LOGIN_ACTION = [
        'login',
        'openfile',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->view->engine->layout(VIEW_PATH.'layout.html');
    }

    public function _initialize()
    {
        if (null === session('userInfo') && !\in_array(Request::instance()->action(), static::NO_AUTH_LOGIN_ACTION, true)) {
            return $this->redirect(url('login', ['method' => 'login']));
        }
//        $this->assign('layout',VIEW_PATH);

//        // 获取访问url地址
//        $url_arr1 = explode('.', trim($_SERVER['REQUEST_URI'], '/'))[0];
//        if (!empty($url_arr1)) {
//            $url_arr = explode('/', $url_arr1);
//            $url = $url_arr[0] . '/' . $url_arr[1] . '/' . $url_arr[2];
//        } else {
//            $url = '/';
//        }
        // 获取所有菜单信息
//        $menuModel = new Menu();
//        $menu_list = $menuModel->getList();
//        dump($menu_list);exit;
//        // 获取用户权限
//        $user_permission_info = self::_getUserPermission();
//        if ($user_permission_info['check'] == -1 || $user_permission_info['check'] == -2) {
//            //未配置 -1 角色信息 -2 权限菜单
//            $menu_new_list = [];
//        } elseif ($user_permission_info['check'] == 1) {
//            //超级管理员
//            $menu_new_list = self::_dealWithMenu($menu_list, 0, $url);
//        } else {
//            //其他用户
//            $menu_new_list = self::_dealWithMenu($menu_list, 0, $url, $user_permission_info['check']);
//        }
        $admin_info = session('userInfo');
//        halt($admin_info);
//        $admin_info['role_name'] = isset($user_permission_info['data']['name']) ? $user_permission_info['data']['name'] : '';
        $this->assign('admin_info', $admin_info);
//        $this->assign('menu_list', $menu_new_list);
        $this->assign('menu_list', $menu_new_list = []);
    }

    public function myFetch($name = '', $vars = [], $replace = [], $config = [])
    {
        return parent::fetch(VIEW_PATH.$name.'.'.Config::get('url_html_suffix'), $vars = [], $replace = ['__ADMIN_STATIC__' => STATIC_PATH], $config = []);
    }
}
