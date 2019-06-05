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
        if ($request->isPost()) {
            //登录
            $info = $this->LoginApiService->checkLogin($request->param('account'), $request->param('password'));
            if (!empty($info)) {
                //将用户信息记录到session中
                if (1 === (int) $info['id']) {
                    $info['role_name'] = '超级管理员';
                }
                session('userInfo', $info);

                return $this->success('登录成功', url('welcome', ['method' => 'index']));
            }

            return $this->error('登录失败，用户名或密码错误');
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
