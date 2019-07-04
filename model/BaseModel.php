<?php

namespace geek1992\tp5_rbac\model;

use geek1992\tp5_rbac\interfaces\BaseModeInterfaces;
use think\Exception;
use think\Log;
use think\Model;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
abstract class BaseModel extends Model implements BaseModeInterfaces
{
    protected $connection = 'database';

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

    public function search(array $condition = [], ?array $order = null, int $page = 1, int $limit = 10, ?array $fields = null): array
    {
        try {
            $query = $this->deleted()->where($condition)->order($order)->field($fields)->limit($this->pagination($page, $limit));
            $list['data'] = collection($query->select())->toArray();
            $list['total'] = $this->deleted()->where($condition)->count();
        } catch (Exception $e) {
            Log::error($e->getTraceAsString());
            $list = [];
        }

        return $list;
    }

    public function searchAll(array $condition = [], ?array $order = null, ?array $fields = null): array
    {
        try {
            $query = $this->deleted()->where($condition)->order($order)->field($fields);
            $list['data'] = collection($query->select())->toArray();
            $list['total'] = $this->deleted()->where($condition)->count();
        } catch (Exception $e) {
            Log::error($e->getTraceAsString());
            $list = ['data' => [], 'total' => 0];
        }

        return $list;
    }

    public function getByCondition(array $condition = [], ?array $order = null, ?array $fields = null): array
    {
        $info = $this->deleted()->where($condition)->field($fields)->order($order)->find();
        if (empty($info)) {
            return [];
        }
        return $info->toArray();
    }

    public function updateDataById(int $id, array $data)
    {
        $data['update_time'] = date('Y-m-d H:i:s');
        $res = $this->where(['id' => $id])->update($data);

        return $res;
    }

    public function getById(int $id, ?array $order = null, ?array $fields = null): array
    {
        return $this->getByCondition(['id' => $id], $order, $fields);
    }

    protected function deleted()
    {
        $this->where(['deleted' => 0]);

        return $this;
    }

    protected function pagination(int $page = 1, int $limit = 10): string
    {
        $start = $page * $limit;

        return "$start,$limit";
    }

    private function objectToArray($items)
    {
        $res = array_map(function ($item) {
            return $item->data;
        }, $items);

        return $res;
    }
}
