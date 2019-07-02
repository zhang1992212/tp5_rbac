<?php

namespace geek1992\tp5_rbac\controller;

use geek1992\tp5_rbac\service\AccountService;
use think\Request;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Account extends Base
{
    private const VALIDATE = 'geek1992\tp5_rbac\validate\AccountValidate';
    protected $accountService;

    public function __construct()
    {
        parent::__construct();
        $this->accountService = new AccountService();
    }

    public function index()
    {
        $list = $this->accountService->search();
        $this->assign('list', $list['data'] ?? []);
        $this->assign('total', $list['total'] ?? []);

        return $this->myFetch('account/index');
    }

    public function getAccountList(Request $request)
    {
        $page = $request->post('start', 0, 'int');
        $limit = $request->post('length', 10, 'int');
        $list = $this->accountService->search([], null, $page, $limit);
        $data = [
            'draw' => $request->post('draw'),
            'recordsTotal' => $list['total'] ?? 0,
            'recordsFiltered' => $list['total'] ?? 0,
            'data' => $list['data'] ?? [],
        ];

        return $data;
    }

    public function account_role_edit(Request $request)
    {
        $id = $request->get('id', -1, 'int');
        if (-1 === $id) {
            return $this->badRequest('错误的ID');
        }
        if ($request->isPost()) {
            $params = $request->post();
            $result = $this->validate($params, static::VALIDATE);
            if (true !== $result) {
                // 验证失败 输出错误信息
                return $this->badRequest('修改失败！'.$result);
            }
            $id = $params['id'];
            unset($params['id']);
            $res = $this->roleApi->updateData($id, $params);
            if ($res) {
                return $this->success('修改成功！');
            }

            return $this->serverError();
        }
        $account = $this->accountService->getAccountInfo($id, null, ['name']);
        $list = $this->account_role_list($id);
        $this->assign('list', $list);
        $this->assign('account', $account);
        $this->noNavLayout();

        return $this->myFetch('account/account_edit');
    }

    public function account_add(Request $request)
    {
        if ($request->isPost()) {
            $params = $request->post();
            $result = $this->validate($params, static::VALIDATE);
            if (true !== $result) {
                // 验证失败 输出错误信息
                return $this->badRequest('修改失败！'.$result);
            }
            unset($params['repwd']);
            $id = $this->accountService->insertData($params);
            if ($id) {
                return $this->success('添加成功');
            }

            return $this->error('添加失败');
        }
        $this->noNavLayout();

        return $this->myFetch('account/account_add');
    }

    public function account_active(Request $request)
    {
        $res = $this->accountService->activeAccount($request->post('id'), $request->post('type'));
        if ($res) {
            return $this->success('修改成功！');
        }

        return $this->serverError();
    }

    public function account_del(Request $request)
    {
        $res = $this->accountService->deletedAccount($request->post('id'));
        if ($res) {
            return $this->success('删除成功！');
        }

        return $this->serverError();
    }

    protected function account_role_list($id)
    {
        $this->noLayOut();
        $list = $this->accountService->getAccountRoleList($id);
        $this->assign('info', $list);
        $menu = $this->myFetch('account/account_role_list');

        return $menu;
    }
}
