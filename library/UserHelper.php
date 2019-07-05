<?php

namespace geek1992\tp5_rbac\library;

use geek1992\tp5_rbac\model\Administrator;
use geek1992\tp5_rbac\model\AdministratorRole;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class UserHelper
{
    /**
     * 通过id 获取账户信息.
     *
     * @param int $id
     *
     * @return array
     */
    public static function getAdminInfo(int $id)
    {
        $adminInfo = ['role_name' => '', 'is_supper' => 0, 'role_id' => []];
        $administratorModel = new Administrator();
        if (1 === $id) {
            $adminInfo['role_name'] = '超级管理员';
            $adminInfo['is_supper'] = 1;
        } else {
            $administratorRoleModel = new AdministratorRole();
            $roleModel = new \geek1992\tp5_rbac\model\Role();
            $administratorRole = $administratorRoleModel->searchAll(['admin_id' => $id], null, ['role_id']);
            $role_id = array_column($administratorRole['data'], 'role_id');
            if (!empty($role_id)) {
                $role = $roleModel->getById($role_id[0], null, ['name']);
                $adminInfo['role_name'] = $role['name'];
                $adminInfo['role_id'] = $role_id;
            }
            unset($administratorRoleModel, $roleModel);
        }
        $administrator = $administratorModel->getById($id, null, ['id', 'name', 'account']);
        unset($administratorModel);

        return array_merge($administrator, $adminInfo);
    }
}
