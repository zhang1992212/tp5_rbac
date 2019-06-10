<?php

namespace geek1992\tp5_rbac\model;

use think\Model;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
abstract class BaseModel extends Model
{
    protected $connection = 'database';

    public function getList($where = [], $limit = '', $order = '', $field = '*')
    {
        $list = [];
        $build = $this->deleted();
        if (!empty($limit)) {
            $build = $build->limit($limit);
        }
        if (!empty($where)) {
            $build = $build->where($where);
        }
        if (!empty($field)) {
            $build = $build->field($field);
        }
        if (!empty($order)) {
            $build = $build->order($order);
        }
        $res = $build->select();
//        echo $build->getLastSql();exit();
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
        $res = $this->deleted()->field($field)->where($where)->find();
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

    protected function deleted()
    {
        $this->where(['deleted' => 0]);

        return $this;
    }
}
