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
        return $this->roleMenuModel->insertDataGetId($data);
    }

    public function insertAllData($data)
    {
        return $this->roleMenuModel->insertAllData($data);
    }

    public function getListById($id)
    {
        $where['role_id'] = $id;
        $list = $this->roleMenuModel->searchAll($where);

        return $list['data'];
    }

    public function delData($id)
    {
        $where['id'] = $id;
        if (\is_array($id)) {
            $where['id'] = ['in', $id];
        }
        $data['deleted'] = 1;
        $res = $this->roleMenuModel->updateDataGetInfo($where, $data);

        return $res;
    }

    public function delWhereData($where)
    {
        $data['deleted'] = 1;
        $res = $this->roleMenuModel->updateDataGetInfo($where, $data);

        return $res;
    }

    public function updateData($id, $data)
    {
        $where['id'] = $id;
        $res = $this->roleMenuModel->updateDataGetInfo($where, $data);

        return $res;
    }
}
