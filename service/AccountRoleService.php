<?php

namespace geek1992\tp5_rbac\service;

use geek1992\tp5_rbac\model\AccountRole;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class AccountRoleService
{
    protected $accountRoleModel;

    public function __construct()
    {
        $this->accountRoleModel = new AccountRole();
    }

    public function updateAccountRole(int $accountId, array $roleId)
    {
        if (empty($roleId)) {
            return null;
        }
        $oldAccountRole = $this->accountRoleModel->searchAll(['account_id' => $accountId], null, ['role_id', 'id']);
        $oldRoleId = array_column($oldAccountRole['data'], 'role_id', 'id');
        $insertRoleId = array_diff($roleId, $oldRoleId);
        $updateRoleId = array_diff($oldRoleId, $roleId);
        $this->accountRoleModel->startTrans();
        if (!empty($updateRoleId)) {
            foreach ($updateRoleId as $key => $item) {
                $res = $this->accountRoleModel->updateDataById($key, ['deleted' => 1]);
                if (false === $res || 0 === (int) $res) {
                    $this->accountRoleModel->rollback();

                    return null;
                }
            }
        }
        if (!empty($insertRoleId)) {
            foreach ($roleId as $item) {
                $data = ['account_id' => $accountId, 'role_id' => $item];
                $res = $this->accountRoleModel->insertData($data);
                if (false === $res || 0 === (int) $res) {
                    $this->accountRoleModel->rollback();

                    return null;
                }
            }
        }
        $this->accountRoleModel->commit();

        return true;
    }
}
