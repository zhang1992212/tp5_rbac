<?php

namespace geek1992\tp5_rbac\controller;

use geek1992\tp5_rbac\service\AdministratorRoleService;
use geek1992\tp5_rbac\service\AdministratorService;
use think\Request;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Administrator extends Base
{
    private const VALIDATE = 'geek1992\tp5_rbac\validate\AdministratorValidate';
    protected $administratorService;
    protected $administratorRoleService;

    public function __construct()
    {
        parent::__construct();
        $this->administratorService = new AdministratorService();
        $this->administratorRoleService = new AdministratorRoleService();
    }

    public function index()
    {
        $list = $this->administratorService->search();
        $this->assign('list', $list['data'] ?? []);
        $this->assign('total', $list['total'] ?? []);

        return $this->myFetch('administrator/index');
    }

    public function getAdministratorList(Request $request)
    {
        $page = $request->post('start', 0, 'int');
        $limit = $request->post('length', 10, 'int');
        $list = $this->administratorService->search([], null, $page, $limit);
        $data = [
            'draw' => $request->post('draw'),
            'recordsTotal' => $list['total'] ?? 0,
            'recordsFiltered' => $list['total'] ?? 0,
            'data' => $list['data'] ?? [],
        ];

        return $data;
    }

    public function administrator_role_edit(Request $request)
    {
        $id = $request->get('id', -1, 'int');
        if (-1 === $id) {
            return $this->badRequest('错误的ID');
        }
        if ($request->isPost()) {
            $params = $request->post();
            $res = $this->administratorRoleService->updateAdministratorRole($id, $params['role']);
            if ($res) {
                return $this->success('修改成功！');
            }

            return $this->serverError();
        }
        $administrator = $this->administratorService->getAdministratorInfo($id, null, ['name']);
        $list = $this->administrator_role_list($id);
        $this->assign('list', $list);
        $this->assign('administrator', $administrator);
        $this->noNavLayout();

        return $this->myFetch('administrator/administrator_edit');
    }

    public function administrator_add(Request $request)
    {
        if ($request->isPost()) {
            $params = $request->post();
            $result = $this->validate($params, static::VALIDATE);
            if (true !== $result) {
                // 验证失败 输出错误信息
                return $this->badRequest('修改失败！'.$result);
            }
            unset($params['repwd']);
            $id = $this->administratorService->insertData($params);
            if ($id) {
                return $this->success('添加成功');
            }

            return $this->error('添加失败');
        }
        $this->noNavLayout();

        return $this->myFetch('administrator/administrator_add');
    }

    public function administrator_active(Request $request)
    {
        $res = $this->administratorService->activeAdministrator($request->post('id'), $request->post('type'));
        if ($res) {
            return $this->success('修改成功！');
        }

        return $this->serverError();
    }

    public function administrator_del(Request $request)
    {
        $res = $this->administratorService->deletedAdministrator($request->post('id'));
        if ($res) {
            return $this->success('删除成功！');
        }

        return $this->serverError();
    }

    protected function administrator_role_list($id)
    {
        $this->noLayOut();
        $list = $this->administratorService->getAdministratorRoleList($id);
        $this->assign('info', $list);
        $menu = $this->myFetch('administrator/administrator_role_list');

        return $menu;
    }
}
