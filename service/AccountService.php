<?php

namespace geek1992\tp5_rbac\service;

use geek1992\tp5_rbac\model\Account;
use geek1992\tp5_rbac\model\AccountRole;
use geek1992\tp5_rbac\model\Role;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class AccountService
{
    protected $accountModel;
    protected $roleModel;
    protected $accountRoleModel;

    public function __construct()
    {
        $this->accountModel = new Account();
        $this->roleModel = new Role();
        $this->accountRoleModel = new AccountRole();
    }

    public function search(array $condition = [], ?array $order = null, int $page = 1, int $limit = 10, ?array $fields = null)
    {
        return $this->accountModel->search($condition, $order, $page, $limit, $fields);
    }

    public function activeAccount(int $id, int $type)
    {
        if (2 === $type) {
            $is_active = 0;
        } else {
            $is_active = 1;
        }
        $data = ['is_active' => $is_active];

        return $this->accountModel->updateDataById($id, $data);
    }

    public function deletedAccount(int $id)
    {
        $data = ['deleted' => 1];

        return $this->accountModel->updateDataById($id, $data);
    }

    public function insertData($data)
    {
        return $this->accountModel->insertData($data);
    }

    /**
     * 获取账户绑定角色信息.
     *
     * @param int $accountId
     *
     * @return array
     */
    public function getAccountRoleList(int $accountId)
    {
        $role = $this->roleModel->searchAll(['id' => ['neq', 1]], null, ['id', 'name']);
        $roleInfo = $role['data'];
        $accountRole = $this->accountRoleModel->searchAll(['account_id' => $accountId]);
        $accountRoleInfo = $accountRole['data'];
        foreach ($roleInfo as $key => $item) {
            $roleInfo[$key]['checked'] = \in_array($item['id'], $accountRoleInfo, true) ? 1 : 0;
        }

        return $roleInfo;
    }

    public function getAccountInfo(int $accountId, ?array $order = null, ?array $fields = [])
    {
        $account = $this->accountModel->getById($accountId, $order, $fields);

        return $account;
    }
}
