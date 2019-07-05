<?php

namespace geek1992\tp5_rbac\service;

use geek1992\tp5_rbac\library\StringHelper;
use geek1992\tp5_rbac\model\Administrator;
use geek1992\tp5_rbac\model\AdministratorRole;
use geek1992\tp5_rbac\model\Role;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class AdministratorService
{
    protected $administratorModel;
    protected $roleModel;
    protected $administratorRoleModel;

    public function __construct()
    {
        $this->administratorModel = new Administrator();
        $this->roleModel = new Role();
        $this->administratorRoleModel = new AdministratorRole();
    }

    public function search(array $condition = [], ?array $order = null, int $page = 1, int $limit = 10, ?array $fields = null)
    {
        return $this->administratorModel->search($condition, $order, $page, $limit, $fields);
    }

    public function activeAdministrator(int $id, int $type)
    {
        if (2 === $type) {
            $is_active = 0;
        } else {
            $is_active = 1;
        }
        $data = ['is_active' => $is_active];

        return $this->administratorModel->updateDataById($id, $data);
    }

    public function deletedAdministrator(int $id)
    {
        $data = ['deleted' => 1];

        return $this->administratorModel->updateDataById($id, $data);
    }

    public function insertData($data)
    {
        $data['password'] = StringHelper::getPassword($data['password']);

        return $this->administratorModel->insertData($data);
    }

    /**
     * 获取账户绑定角色信息.
     *
     * @param int $administratorId
     *
     * @return array
     */
    public function getAdministratorRoleList(int $administratorId)
    {
        $role = $this->roleModel->searchAll(['id' => ['neq', 1]], null, ['id', 'name']);
        $roleInfo = $role['data'];
        $administratorRole = $this->administratorRoleModel->searchAll(['admin_id' => $administratorId], null, ['role_id']);
        $administratorRoleInfo = array_column($administratorRole['data'], 'role_id');
        foreach ($roleInfo as $key => $item) {
            $roleInfo[$key]['checked'] = \in_array((int) $item['id'], $administratorRoleInfo, true) ? 1 : 0;
        }

        return $roleInfo;
    }

    public function getAdministratorInfo(int $administratorId, ?array $order = null, ?array $fields = [])
    {
        $administrator = $this->administratorModel->getById($administratorId, $order, $fields);

        return $administrator;
    }
}
