<?php

namespace geek1992\tp5_rbac\service;

use geek1992\tp5_rbac\model\AdministratorRole;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class AdministratorRoleService
{
    protected $administratorRoleModel;

    public function __construct()
    {
        $this->administratorRoleModel = new AdministratorRole();
    }

    public function updateAdministratorRole(int $administratorId, array $roleId)
    {
        if (empty($roleId)) {
            return null;
        }
        $oldAdministratorRole = $this->administratorRoleModel->searchAll(['admin_id' => $administratorId], null, ['role_id', 'id']);
        $oldRoleId = array_column($oldAdministratorRole['data'], 'role_id', 'id');
        $insertRoleId = array_diff($roleId, $oldRoleId);
        $updateRoleId = array_diff($oldRoleId, $roleId);
        $this->administratorRoleModel->startTrans();
        if (!empty($updateRoleId)) {
            foreach ($updateRoleId as $key => $item) {
                $res = $this->administratorRoleModel->updateDataById($key, ['deleted' => 1]);
                if (false === $res || 0 === (int) $res) {
                    $this->administratorRoleModel->rollback();

                    return null;
                }
            }
        }
        if (!empty($insertRoleId)) {
            foreach ($roleId as $item) {
                $data = ['admin_id' => $administratorId, 'role_id' => $item];
                $res = $this->administratorRoleModel->insertData($data);
                if (false === $res || 0 === (int) $res) {
                    $this->administratorRoleModel->rollback();

                    return null;
                }
            }
        }
        $this->administratorRoleModel->commit();

        return true;
    }
}
