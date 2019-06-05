<?php

namespace geek1992\tp5_rbac\model;

use think\Model;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Account extends Model
{
    protected $connection = 'database';
    protected $name = 'admin_account';

    public function getList($where, $limit = '')
    {
        $list = [];
        if (empty($limit)) {
            $res = $this->where($where)->select();
        } else {
            $res = $this->where($where)->limit($limit)->select();
        }
        if (!empty($res)) {
            $list = collection($res)->toArray();
        }

        return $list;
    }

    public function getTotal($where)
    {
        $total = $this->where($where)->count();

        return empty($total) ? 0 : $total;
    }

    public function getOneInfo($where, $field = '*')
    {
        $list = [];
        $res = $this->field($field)->where($where)->find();
        if (!empty($res)) {
            $list = $res->toArray();
        }

        return $list;
    }

    public function insertData($data)
    {
        $res = $this->insertGetId($data);

        return $res;
    }

    public function updateData($where, $data)
    {
        $res = $this->where($where)->update($data);

        return $res;
    }
}
