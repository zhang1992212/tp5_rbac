<?php

namespace geek1992\tp5_rbac\controller;

use geek1992\tp5_rbac\model\Menu;
use think\exception\HttpResponseException;
use think\Response;
use think\Url;
use think\View as ViewTemplate;
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

    protected function getSupperMenu($isSystemMenu)
    {
        $menuModel = new Menu();
        $menu_list = $menuModel->getList([], '', 'order desc');
        $menu_tree = $this->menuTreeList($menu_list, 0, $isSystemMenu);
        unset($menu_tree['selected']);

        $menu_tree_html = $this->buildMenuTree($menu_tree, $isSystemMenu);

        return $menu_tree_html;
    }

    protected function errorMsg($msg = '', $code=200, $data = '', $url = null, $wait = 3, array $header = [])
    {
        if (is_null($url)) {
            $url = Request::instance()->isAjax() ? '' : 'javascript:history.back(-1);';
        } elseif ('' !== $url && !strpos($url, '://') && 0 !== strpos($url, '/')) {
            $url = Url::build($url);
        }

        $type = $this->getResponseType();
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        if ('html' == strtolower($type)) {
            $result = $this->notFound($code, $msg);
        }

        $response = Response::create($result, $type)->header($header)->code($code);

        throw new HttpResponseException($response);
    }

    private function menuTreeList($list, $pid = 0, $isSystemMenu = '0')
    {
        if (1 === \count($list)) {
            return $list;
        }
        $tree = [];
        $tree['selected'] = 0;
        $request = Request::instance();
        foreach ($list as $item) {
            if ($item['parent_id'] === $pid) {
                $tmp = [];
                $tmp['id'] = $item['id'];
                $tmp['name'] = $item['name'];
                $tmp['icon'] = $item['icon'];
                $tmp['selected'] = 0;
                //系统菜单
                if ('1' === $isSystemMenu && $request->action() === $item['controller'] && $request->param('method') === $item['action']) {
                    $tmp['selected'] = 1;
                    $tree['selected'] = 1;
                }
                //非系统菜单
                if ('0' === $isSystemMenu && $request->module() === $item['module'] && $request->controller() === ucfirst($item['controller']) && $request->action() === $item['action']) {
                    $tmp['selected'] = 1;
                    $tree['selected'] = 1;
                }

                if (0 === $item['type']) { //系统菜单
                    $tmp['url'] = url('index/index/'.$item['controller'], ['method' => $item['action']]);
                } else {
                    $tmp['url'] = url($item['module'].'/'.$item['controller'].'/'.$item['action']);
                }
                $tmp['type'] = $item['type'];
                $tmp['order'] = $item['order'];
                $tmp['parent_id'] = $item['parent_id'];
                $children = $this->menuTreeList($list, $item['id'], $isSystemMenu);
                if (1 === $children['selected']) {
                    $tmp['selected'] = 1;
                    $tree['selected'] = 1;
                }
                unset($children['selected']);
                $tmp['children'] = $children;
                array_push($tree, $tmp);
            }
        }

        return $tree;
    }

    private function buildMenuTree($list, $isSystemMenu)
    {
        $html = '';
        if (empty($list)) {
            return $html;
        }
        foreach ($list as $item) {
            if (empty($item['children'])) {
                $html .= '<dl>';
                if (1 === $item['selected']) {
                    $html .= '<dt class="selected current">';
                } else {
                    $html .= '<dt>';
                }
                $html .= '<i class="Hui-iconfont">';
                $html .= $item['icon'];
                $html .= '</i>';
                if (1 === $item['selected']) {
                    $html .= '<li class="current"><a style="padding-left: 0px;" href="'.$item['url'].'" title="'.$item['name'].'">'.$item['name'].'</a></li>';
                } else {
                    $html .= '<a href="'.$item['url'].'" title="'.$item['name'].'">'.$item['name'].'</a>';
                }
                $html .= '</dt></dl>';
                continue;
            }
            $html .= '<dl id="menu-article">';
            if (1 === $item['selected']) {
                $html .= '<dt class="selected">';
            } else {
                $html .= '<dt>';
            }
            $html .= '<i class="Hui-iconfont">';
            $html .= $item['icon'];
            $html .= '</i>';
            $html .= $item['name'];
            $html .= '<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>';

            $html .= '</dt>';
            if (1 === $item['selected']) {
                $html .= '<dd style="display:block">';
            } else {
                $html .= '<dd>';
            }
            $html .= '<ul>';
            if (!empty($item['children'])) {
                foreach ($item['children'] as $i) {
                    if (1 === $i['selected']) {
                        $html .= '<li class="current">';
                    } else {
                        $html .= '<li>';
                    }

                    $html .= '<a href="'.$i['url'].'" title="'.$i['name'].'">'.$i['name'].'</a>';
                    $html .= '</li>';
                }
            }
            $html .= '</ul>';
            $html .= '</dd>';
            $html .= '</dl>';
        }

        return $html;
    }

    public function badRequest($msg)
    {
        return $this->errorMsg($msg, 400);
    }

    public function serverError($msg = '服务器内部错误')
    {
        return $this->errorMsg($msg, 500);
    }

    public function notFound($code=404, $msg='')
    {
        $this->assign('code', $code);
        $this->assign('msg', $msg);
        return $this->myFetch('blocks/error');
    }
}
