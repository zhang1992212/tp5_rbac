<?php

namespace geek1992\tp5_rbac\controller;

use geek1992\tp5_rbac\service\RoleApiService;
use think\facade\Request;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Role extends Base
{
    private const VALIDATE = 'geek1992\tp5_rbac\validate\RoleValidate';
    private $roleService;

    public function __construct()
    {
        parent::__construct();
        $this->roleService = new RoleApiService();
    }

    public function index()
    {
        return $this->myFetch('role/index');
    }

    public function getRoleList()
    {
        $start = $this->request->post('start');
        $length = $this->request->post('length', '10', 'int');
        $list = $this->roleService->getList([], null, $start, $length);
        $data = [
            'draw' => $this->request->post('draw'),
            'recordsTotal' => $list['total'],
            'recordsFiltered' => $list['total'],
            'data' => $list['data'],
        ];

        return $data;
    }

    /**
     * 添加.
     *
     * @param Request $this->request
     *
     * @return mixed|void
     */
    public function role_add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post();
            $result = $this->validate($params, static::VALIDATE);
            if (true !== $result) {
                // 验证失败 输出错误信息
                return $this->badRequest('修改失败！'.$result);
            }
            unset($params['id']);
            $id = $this->roleService->insertData($params);
            if ($id) {
                return $this->success('添加成功');
            }

            return $this->error('添加失败');
        }
        $menu = $this->roleMenuHtml();
        $this->assign('menu', $menu);
        $this->noNavLayout();
        $this->assign('type', 'add');

        return $this->myFetch('role/role_add');
    }

    /**
     * 编辑.
     *
     * @param Request $this->request
     *
     * @return mixed|void
     */
    public function role_edit()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post();
            $result = $this->validate($params, static::VALIDATE);
            if (true !== $result) {
                // 验证失败 输出错误信息
                return $this->badRequest('修改失败！'.$result);
            }
            $id = $params['id'];
            unset($params['id']);
            $res = $this->roleService->updateData($id, $params);
            if ($res) {
                return $this->success('修改成功！');
            }

            return $this->serverError();
        }
        $id = $this->request->get('id', -1, 'int');
        if (-1 === $id) {
            return $this->badRequest('错误的ID');
        }
        $list = $this->roleService->getInfo($id, null, ['id', 'name']);
        $menu = $this->roleMenuHtml($id);
        $this->assign('menu', $menu);
        $this->noNavLayout();
        $this->assign('role_info', $list);
        $this->assign('type', 'edit');

        return $this->myFetch('role/role_add');
    }

    /**
     *  删除.
     *
     * @param Request $this->request
     */
    public function role_del()
    {
        $id = $this->request->post('id', -1, 'int');
        if (-1 === $id) {
            return $this->errorMsg('删除失败！错误的ID', 400);
        }
        $res = $this->roleService->delData($id);
        if ($res) {
            return $this->success('删除成功！');
        }

        return $this->errorMsg('删除失败！服务器错误', 500);
    }

    /**
     * 角色详情.
     *
     * @param Request $this->request
     *
     * @return mixed|void
     */
    public function role_view()
    {
        $id = $this->request->get('id', -1, 'int');
        if (-1 === $id) {
            return $this->badRequest('错误的ID');
        }
        $list = $this->roleService->getInfo($id);
        $this->assign('role_info', $list);
        $this->assign('action', 'view');
        $menu = $this->roleMenuHtml($id);
        $this->assign('menu', $menu);
        $this->noNavLayout();

        return $this->myFetch('role/role_view');
    }

    /**
     * 权限列表.
     *
     * @param $id
     *
     * @return mixed
     */
    protected function roleMenuHtml(int $id = 0)
    {
        $this->noLayOut();
        $menu_list = $this->roleService->getRoleMenuList($id);
        $this->assign('menu_info', $menu_list);
        $menu = $this->myFetch('role/role_list');

        return $menu;
    }
}
