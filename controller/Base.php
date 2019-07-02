<?php

namespace geek1992\tp5_rbac\controller;

use geek1992\tp5_rbac\library\Formatter;
use geek1992\tp5_rbac\model\Menu;
use think\Config;
use think\Controller;
use think\exception\HttpResponseException;
use think\Request;
use think\Response;
use think\Url;

\defined('DS') or \define('DS', \DIRECTORY_SEPARATOR);
\defined('VIEW_PATH') or \define('VIEW_PATH', __DIR__.DS.'..'.DS.'view'.DS);
\defined('STATIC_PATH') or \define('STATIC_PATH', DS.'public'.DS.'..'.DS.'vendor'.DS.'geek1992'.DS.'tp5_rbac'.DS.'view'.DS);

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Base extends Controller
{
    use \geek1992\tp5_rbac\traits\Menu;

    protected const NO_AUTH_LOGIN_ACTION = [
        'login',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->view->engine->layout(VIEW_PATH.'layout.html');
    }

    public function _initialize()
    {
        $request = Request::instance();
        if (null === session('userInfo') && !\in_array($request->action(), static::NO_AUTH_LOGIN_ACTION, true)) {
            return $this->redirect(url('login', ['method' => 'login']));
        }

        $isSystemMenu = $request->isSystemMenu ?? '0';

        // 获取所有菜单信息
        $admin_info = session('userInfo');
        $admin_info['is_supper'] = 1;
        if (1 === $admin_info['is_supper']) {
            $menu_list = $this->getSupperMenu($isSystemMenu);
        } else {
            $menu_list = [];
        }
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

//        $admin_info['role_name'] = isset($user_permission_info['data']['name']) ? $user_permission_info['data']['name'] : '';
        $this->assign('admin_info', $admin_info);
        $this->assign('menu_list_tree', $menu_list);
    }

    public function myFetch($name = '', $vars = [], $replace = [], $config = [])
    {
        return parent::fetch(VIEW_PATH.$name.'.'.Config::get('url_html_suffix'), $vars = [], $replace = ['__ADMIN_STATIC__' => STATIC_PATH], $config = []);
    }

    /**
     * 没有导航的布局文件.
     */
    public function noNavLayout()
    {
        $this->view->engine->layout(VIEW_PATH.'no_nav_layout.html');
    }

    /**
     * 关闭布局
     */
    public function noLayOut()
    {
        $this->view->engine->layout(false);
    }

    public function badRequest($msg)
    {
        return $this->errorMsg($msg, 400);
    }

    public function serverError($msg = '服务器内部错误')
    {
        return $this->errorMsg($msg, 500);
    }

    public function notFound($code = 404, $msg = '')
    {
        $this->assign('code', $code);
        $this->assign('msg', $msg);

        return $this->myFetch('blocks/error');
    }


    protected function errorMsg($msg = '', $code = 200, $data = '', $url = null, $wait = 3, array $header = [])
    {
        if (null === $url) {
            $url = Request::instance()->isAjax() ? '' : 'javascript:history.back(-1);';
        } elseif ('' !== $url && !strpos($url, '://') && 0 !== strpos($url, '/')) {
            $url = Url::build($url);
        }

        $type = $this->getResponseType();
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'url' => $url,
            'wait' => $wait,
        ];

        if ('html' === strtolower($type)) {
            $result = $this->notFound($code, $msg);
        }

        $response = Response::create($result, $type)->header($header)->code($code);

        throw new HttpResponseException($response);
    }

    /**
     * @return Formatter
     */
    protected function getFormatter(): Formatter
    {
        return Formatter::newInstance();
    }
    
}
