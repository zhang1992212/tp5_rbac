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
//        halt(Request::instance());
        // 获取所有菜单信息
        $admin_info = session('userInfo');
        $admin_info['is_supper'] = 1;
        if ($admin_info['is_supper'] == 1) {
            $menu_list = $this->getSupperMenu();
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
        $this->assign('menu_list', $menu_list);
    }

    protected function getSupperMenu() {
        $menuModel = new Menu();
        $menu_list = $menuModel->getList([], '', 'order desc');
        $menu_tree = $this->menuTreeList($menu_list);
        $menu_tree_html = $this->buildMenuTree($menu_tree);
        return $menu_tree_html;
    }

    private function menuTreeList($list, $pid = 0) {
        if (count($list) == 1) {
            return $list;
        }
        $tree = [];
        foreach ($list as $item) {
            if ($item['parent_id'] == $pid) {
                $tmp = [];
                $tmp['id'] = $item['id'];
                $tmp['name'] = $item['name'];
                $tmp['icon'] = $item['icon'];
                if ($item['type'] == 0) { //系统菜单
                    $tmp['url'] = url('index/index/'.$item['controller'],['method'=>$item['action']]);
                } else {
                    $tmp['url'] = url($item['module'].'/' .$item['controller'].'/'.$item['action']);
                }
                $tmp['type'] = $item['type'];
                $tmp['order'] = $item['order'];
                $tmp['parent_id'] = $item['parent_id'];
                $tmp['children'] = $this->menuTreeList($list, $item['id']);
                array_push($tree, $tmp);
            }
        }
        return $tree;
    }


    private function buildMenuTree($list) {
        $html = '';
        if (empty($list)) {
            return $html;
        }
        foreach ($list as $item) {
            if(empty($item['children'])) {
                $html .= '<dl><dt>';
                $html .= '<i class="Hui-iconfont">';
                $html .= $item['icon'];
                $html .= '</i>';
                $html .= '<a href="'.$item['url'].'" title="'. $item['name'] .'">' . $item['name'] .'</a>';
                $html .= '</dt></dl>';
                continue;
            }
            $html .= '<dl id="menu-article">';
            $html .= '<dt>';
            $html .= '<i class="Hui-iconfont">';
            $html .= $item['icon'];
            $html .= '</i>';
            $html .= $item['name'];
            $html .= '<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>';

            $html .= '</dt>';
            $html .= '<dd>';
            $html .= '<ul>';
            if (!empty($item['children'])) {
                foreach ($item['children'] as $i) {
                    $html .= '<li>';
                    $html .= '<a href="'.$i['url'].'" title="'. $i['name'] .'">' . $i['name'] .'</a>';
                    $html .= '</li>';
                }
            }
            $html .= '</ul>';
            $html .= '</dd>';
            $html .= '</dl>';

        }
        return $html;
    }

    public function myFetch($name = '', $vars = [], $replace = [], $config = [])
    {
        return parent::fetch(VIEW_PATH.$name.'.'.Config::get('url_html_suffix'), $vars = [], $replace = ['__ADMIN_STATIC__' => STATIC_PATH], $config = []);
    }

    /**
     * 没有导航的布局文件
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
}
