<?php

namespace geek1992\tp5_rbac\controller;

use geek1992\tp5_rbac\library\Redis;
use geek1992\tp5_rbac\model\RoleMenu;
use geek1992\tp5_rbac\service\LoginApiService;
use think\Request;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Login extends Base
{
    protected $LoginApiService;

    public function __construct()
    {
        parent::__construct();
        $this->LoginApiService = new LoginApiService();
    }

    /**
     * 登录.
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function login(Request $request)
    {
        if (session('userInfo')) {
            if ($request->isAjax()) {
                return $this->success('登录成功', url('index/welcome', ['method' => 'index']));
            }
            return $this->redirect(url('index/welcome', ['method' => 'index']));
        }
        if ($request->isPost()) {
            //登录
            $info = $this->LoginApiService->checkLogin($request->param('account'), $request->param('password'));
            Request::instance()->admin = $info;
            if (empty($info)) {
                $msg = '登录失败，用户名或密码错误';
                $this->writeLog($msg);

                return $this->error($msg);
            } elseif (!empty($info) && 0 === (int) $info['is_active']) {
                $msg = '登录失败，该用户已被禁用';
                $this->writeLog($msg);

                return $this->error($msg);
            }
            //将用户信息记录到session中
            $info = $this->getAdminInfo((int) $info['id']);
            session('userInfo', $info);
            $roleMenuModel = new RoleMenu();
            $roleMenu = $roleMenuModel->searchAll(['role_id' => ['in', $info['role_id']]], null, ['menu_id']);
            $authId = array_column($roleMenu, 'menu_id');
            unset($roleMenuModel);
            if (null === Redis::getRedis()) {//未开启redis 读取session
                session('authId', $authId);
            } elseif(!empty($authId)) {
                Redis::getRedis()->set(Redis::getKey(['admin_id' => $info['id'], 'admin_auth' => 1], serialize($authId)));
            }

            $msg = '登录成功';
            $this->writeLog($msg);
            return $this->success($msg, url('index/welcome', ['method' => 'index']));
        }
        $this->view->engine->layout(false);

        return $this->myFetch('login/login');
    }

    /**
     * 退出登录.
     */
    public function loginOut()
    {
        if ($userInfo = session('userInfo')) {
            session(null);
            $msg = '退出成功';
            Request::instance()->admin = $userInfo;
            $this->writeLog($msg, 1);
            if (null !== Redis::getRedis()) {//开启redis 删除权限id
                Redis::getRedis()->del(Redis::getKey(['admin_id' => $userInfo['id'], 'admin_auth' => 1]));
            }
            return $this->success($msg, url('login', ['method' => 'login']));
        }
        $msg = '非法操作';
        $this->writeLog($msg, 1);

        return $this->error($msg);
    }

    protected function writeLog($msg, $type = 0)
    {
        \geek1992\tp5_rbac\library\LoginLog::newLog($msg, $type);
    }
}
