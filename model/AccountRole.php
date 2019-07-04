<?php

namespace geek1992\tp5_rbac\model;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class AccountRole extends BaseModel
{
    protected $name = 'admin_account_role';

    public function insertData($data)
    {
        $info = $this->where(['role_id' => $data['role_id'], 'account_id' => $data['account_id']])->field(['id', 'deleted'])->find();
        if (!empty($info) && 1 === (int) $info['deleted']) {
            $res = $this->updateDataById($info['id'], ['deleted' => 0]);
        } elseif (!empty($info) && 0 === (int) $info['deleted']) {
            $res = true;
        } else {
            $res = $this->insertGetId($data);
        }

        return $res;
    }
}
