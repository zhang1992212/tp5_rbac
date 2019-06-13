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

        if (!empty($res)) {
            $list = $this->objectToArray($res);
        }

        return $list;
    }

    public function getCount($where = [])
    {
        $build = $this->deleted();

        if (!empty($where)) {
            $build = $build->where($where);
        }
        $res = $build->count();

        return empty($res) ? 0 : $res;
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

    public function insertAllData($data)
    {
        $res = $this->insertAll($data);

        return $res;
    }

    public function updateData($where, $data)
    {
        $data['update_time'] = date('Y-m-d H:i:s');
        $res = $this->where($where)->update($data);

        return $res;
    }

    protected function deleted()
    {
        $this->where(['deleted' => 0]);

        return $this;
    }

    private function objectToArray($items)
    {
        $res = array_map(function ($item) {
            return $item->data;
        }, $items);

        return $res;
    }
}
