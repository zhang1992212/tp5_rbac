<?php

namespace geek1992\tp5_rbac\controller;

use geek1992\tp5_rbac\library\Formatter;
use geek1992\tp5_rbac\model\Administrator;
use geek1992\tp5_rbac\model\AdministratorRole;
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

    protected $uniqueId;

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
        if (!(null === session('userInfo') && 'login' === $request->action())) {
            // 获取所有菜单信息
            $admin_info = session('userInfo');
            Request::instance()->admin = $admin_info;
            //超级管理员 、系统管理员 拥有全部菜单权限
            if (1 === $admin_info['is_supper'] || \in_array(2, $admin_info['role_id'], true)) {
                $menu_list = $this->getSupperMenu($isSystemMenu);
            } else {
                $menu_list = $this->getCommonMenu($isSystemMenu, $admin_info['role_id']);
            }
            $this->assign('admin_info', $admin_info);
            $this->assign('menu_list_tree', $menu_list);
        }
        $this->getUniqueId($isSystemMenu);
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

    /**
     * 通过id 获取账户信息.
     *
     * @param int $id
     *
     * @return array
     */
    public function getAdminInfo(int $id)
    {
        $adminInfo = ['role_name' => '', 'is_supper' => 0, 'role_id' => []];
        $administratorModel = new Administrator();
        if (1 === $id) {
            $adminInfo['role_name'] = '超级管理员';
            $adminInfo['is_supper'] = 1;
        } else {
            $administratorRoleModel = new AdministratorRole();
            $roleModel = new \geek1992\tp5_rbac\model\Role();
            $administratorRole = $administratorRoleModel->searchAll(['admin_id' => $id], null, ['role_id']);
            $role_id = array_column($administratorRole['data'], 'role_id');
            if (!empty($role_id)) {
                $role = $roleModel->getById($role_id[0], null, ['name']);
                $adminInfo['role_name'] = $role['name'];
                $adminInfo['role_id'] = $role_id;
            }
            unset($administratorRoleModel, $roleModel);
        }
        $administrator = $administratorModel->getById($id, null, ['id', 'name', 'account']);
        unset($administratorModel);

        return array_merge($administrator, $adminInfo);
    }

    protected function getUniqueId(int $isSystemMenu = 0)
    {
        $request = Request::instance();
        if (0 === $isSystemMenu) {
            $uniqueId = $request->module().'/'.$request->controller().'/'.$request->action();
        } else {
            $uniqueId = $request->module().'/'.$request->action().'/'.$request->param('method');
        }
        Request::instance()->uniqueId = $uniqueId;
        $this->uniqueId = $uniqueId;
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
