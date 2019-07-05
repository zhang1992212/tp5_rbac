<?php

namespace geek1992\tp5_rbac\controller;

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
            return $this->redirect(url('welcome/index', ['method' => 'index']));
        }
        if ($request->isPost()) {
            //登录
            $info = $this->LoginApiService->checkLogin($request->param('account'), $request->param('password'));
            if (empty($info)) {
                return $this->error('登录失败，用户名或密码错误');
            } elseif (!empty($info) && 0 === (int) $info['is_active']) {
                return $this->error('登录失败，该账户未激活');
            }
            //将用户信息记录到session中
            $info = $this->getAdminInfo((int) $info['id']);
            session('userInfo', $info);

            return $this->success('登录成功', url('index/welcome', ['method' => 'index']));
        }
        $this->view->engine->layout(false);

        return $this->myFetch('login/login');
    }

    /**
     * 退出登录.
     */
    public function loginOut()
    {
        if (session('userInfo')) {
            session(null);
            $this->success('退出成功', url('login', ['method' => 'login']));
        } else {
            $this->error('非法操作');
        }
    }
}
