<?php

namespace geek1992\tp5_rbac\controller;

use geek1992\tp5_rbac\service\MenuApiService;
use think\facade\Request;

/**
 *  菜单.
 *
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Menu extends Base
{
    private const VALIDATE = 'geek1992\tp5_rbac\validate\MenuValidate';
    private $menuApi;

    public function __construct()
    {
        parent::__construct();
        $this->menuApi = new MenuApiService();
    }

    /**
     *  首页列表.
     *
     * @return mixed
     */
    public function index()
    {
        $list = $this->menuApi->getTreeList();
        $this->assign('list', $list);

        return $this->myFetch('menu/index');
    }

    /**
     *  添加.
     *
     *
     * @return mixed|void
     */
    public function menu_add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post();
            $parent_id = $this->request->post('parent_id', '-2', 'int');
            if (-2 === (int) $parent_id) {
                return $this->error('请选择父级菜单');
            } elseif (-1 === (int) $parent_id) {
                $parent_id = 0;
            }
            $result = $this->validate($params, static::VALIDATE);
            if (true !== $result) {
                // 验证失败 输出错误信息
                return $this->badRequest('修改失败！'.$result);
            }
            $params['parent_id'] = $parent_id;
            $id = $this->menuApi->insertData($params);
            if ($id) {
                return $this->success('添加成功');
            }

            return $this->error('添加失败');
        }
        $id = $this->request->get('id', -1, 'int');
        if (-1 === $id) {
            $pList = [['id' => -1, 'name' => '添加主菜单']];
        } else {
            $pList = $this->menuApi->getParentInfo($id);
        }
        $this->noNavLayout();
        $this->assign('menu_list', $pList);
        $this->assign('pid', $id);
        $this->assign('type', 'add');

        return $this->myFetch('menu/menu_add');
    }

    public function menu_edit()
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
            $res = $this->menuApi->updateData($id, $params);
            if ($res) {
                return $this->success('修改成功！');
            }

            return $this->serverError();
        }
        $id = $this->request->get('id', -1, 'int');
        if (-1 === $id) {
            return $this->badRequest('错误的ID');
        }
        $list = $this->menuApi->getOneMenuInfo($id);
        $pList = [
            'id' => 0,
            'name' => '无',
            'parent_id' => 0,
            'level' => 1,
        ];
        if (0 !== $list['parent_id']) {
            $pList = $this->menuApi->getParentInfo($list['parent_id']);
        }
        $this->noNavLayout();
        $this->assign('menu_list', $pList);
        $this->assign('menu_info', $list);
        $this->assign('pid', 0);
        $this->assign('type', 'edit');

        return $this->myFetch('menu/menu_add');
    }

    /**
     *  删除.
     *
     * @param Request $this->request
     */
    public function menu_del()
    {
        $id = $this->request->post('id', -1, 'int');
        if (-1 === $id) {
            return $this->errorMsg('删除失败！错误的ID', 400);
        }
        $res = $this->menuApi->delData($id);
        if ($res) {
            return $this->success('删除成功！');
        }

        return $this->errorMsg('删除失败！服务器错误', 500);
    }
}
