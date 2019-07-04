<?php


namespace geek1992\tp5_rbac\library;


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
        $accountModel = new \geek1992\tp5_rbac\model\Account();
        if (1 === $id) {
            $adminInfo['role_name'] = '超级管理员';
            $adminInfo['is_supper'] = 1;
        } else {
            $accountRoleModel = new AccountRole();
            $roleModel = new \geek1992\tp5_rbac\model\Role();
            $accountRole = $accountRoleModel->searchAll(['account_id' => $id], null, ['role_id']);
            $role_id = array_column($accountRole['data'], 'role_id');
            if (!empty($role_id)) {
                $role = $roleModel->getById($role_id[0], null, ['name']);
                $adminInfo['role_name'] = $role['name'];
                $adminInfo['role_id'] = $role_id;
            }
            unset($accountRoleModel, $roleModel);
        }
        $account = $accountModel->getById($id, null, ['id', 'name', 'account']);
        unset($accountModel);

        return array_merge($account, $adminInfo);
    }
}