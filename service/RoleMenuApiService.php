<?php

namespace geek1992\tp5_rbac\service;


use geek1992\tp5_rbac\model\RoleMenu;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class RoleMenuApiService
{
    private $roleMenuModel;

    public function __construct()
    {
        $this->roleMenuModel = new RoleMenu();
    }

    public function insertData($data)
    {
        return $this->roleMenuModel->insertData($data);
    }

    public function insertAllData($data)
    {
        return $this->roleMenuModel->insertAllData($data);
    }

    public function getListById($id)
    {
        $where['role_id'] = $id;
        $list = $this->roleMenuModel->getList($where);

        return $list;
    }

    public function getInfo($id)
    {
        $list = $this->roleMenuModel->getOneInfo(['id' => $id]);

        return $list;
    }

    public function delData($id)
    {
        $where['id'] = $id;
        if (is_array($id)) {
            $where['id'] = ['in', $id];
        }
        $data['deleted'] = 1;
        $res = $this->roleMenuModel->updateData($where, $data);

        return $res;
    }

    public function delWhereData($where)
    {
        $data['deleted'] = 1;
        $res = $this->roleMenuModel->updateData($where, $data);

        return $res;
    }

    public function updateData($id, $data)
    {
        $where['id'] = $id;
        $res = $this->roleMenuModel->updateData($where, $data);

        return $res;
    }

}
