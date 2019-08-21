<?php

namespace geek1992\tp5_rbac\service;

use geek1992\tp5_rbac\model\Role;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class RoleApiService
{
    protected const SUPER_ROLE = [1, 2];
    private $roleModel;
    private $menuApi;
    private $roleMenuApi;

    public function __construct()
    {
        $this->roleModel = new Role();
        $this->menuApi = new MenuApiService();
        $this->roleMenuApi = new RoleMenuApiService();
    }

    public function insertData($data)
    {
        $menu = $data['menu'];
        unset($data['menu']);
        $id = $this->roleModel->insertDataGetId($data);
        $insertData = array_map(function ($item) use ($id) {
            return ['role_id' => $id, 'menu_id' => $item];
        }, $menu);

        return $this->roleMenuApi->insertAllData($insertData);
    }

    public function getList(array $where = [], ?array $orders = null, int $page = 0, int $limit = 10, ?array $fields = null)
    {
        $list = $this->roleModel->search($where, null, $page, $limit, $fields);

        return $list;
    }

    public function getInfo(int $id, ?array $orders = null, ?array $fields = null)
    {
        $list = $this->roleModel->getById($id, $orders, $fields);

        return $list;
    }

    public function delData($id)
    {
        $where['id'] = $id;
        $data['deleted'] = 1;
        $res = $this->roleModel->updateDataGetInfo($where, $data);

        return $res;
    }

    /**
     * 更新权限.
     *
     * @param $id
     * @param $data
     *
     * @return Role
     */
    public function updateData($id, $data)
    {
        $where['id'] = $id;
        $menu = $data['menu'] ?? [];
        unset($data['menu']);
        $res = $this->roleModel->updateDataGetInfo($where, $data);
        $old_role = $this->roleMenuApi->getListById($id);
        $old_menu = array_column($old_role, 'menu_id');
        $del_menu = array_diff($old_menu, $menu);
        $add_menu = array_diff($menu, $old_menu);
        //添加新权限
        if (!empty($add_menu)) {
            $insertData = array_map(function ($item) use ($id) {
                return ['role_id' => $id, 'menu_id' => $item];
            }, $add_menu);
            $this->roleMenuApi->insertAllData($insertData);
        }
        //删除撤销的权限
        if (!empty($del_menu)) {
            $old_id_menu = array_column($old_role, 'id', 'menu_id');
            $del_id = array_map(function ($item) use ($old_id_menu) {
                return $old_id_menu[$item];
            }, $del_menu);
            $this->roleMenuApi->delData($del_id);
        }

        return $res;
    }

    public function getRoleMenuList(int $id = 0)
    {
        $super = 1;
        $menu_id = [];
        if (!\in_array((int) $id, static::SUPER_ROLE, true)) {
            $menu = $this->roleMenuApi->getListById($id);
            $menu_id = array_column($menu, 'menu_id');
            $super = 0;
        }

        $list = $this->menuApi->getChildList($super, $menu_id);

        return $list;
    }
}
