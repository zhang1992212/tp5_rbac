<?php

namespace geek1992\tp5_rbac\model;

use geek1992\tp5_rbac\library\ArrayHelper;
use geek1992\tp5_rbac\library\Redis;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Menu extends BaseModel
{
    protected $name = 'admin_menu';

    /**
     * 通过缓存获取1条数据.
     *
     * @param array      $condition
     * @param array|null $order
     * @param array|null $fields
     *
     * @return array|null
     */
    public function getByConditionFromCache(array $condition = [], ?array $order = null, ?array $fields = null): ?array
    {
        $redis = Redis::getRedis();
        if (null === $redis) {//如果未开启redis  则直接查库
            $value = $this->getByCondition($condition, $order, $fields);
            $fields = null;
        } else {
            $key = Redis::getKey($condition);
            if ($value = Redis::getRedis()->get($key)) {
                $value = unserialize($value);
            } else {
                $value = $this->getByCondition($condition, $order);
                if (!empty($value)) {
                    Redis::getRedis()->set(serialize($value));
                }
            }
        }
        $info = ArrayHelper::array_filter_fields($value, $fields);
        return $info;
    }

    /**
     * @param int        $id
     * @param array|null $order
     * @param array|null $fields
     *
     * @return array
     */
    public function getByIdFromCache(int $id, ?array $order = null, ?array $fields = null): array
    {
        return $this->getByConditionFromCache(['id' => $id], $order, $fields);
    }

    /**
     * 通过缓存获取全部数据.
     * @param array $condition
     * @param array|null $order
     * @param array|null $fields
     * @return array
     */
    public function searchAllFromCache(array $condition = [], ?array $order = null, ?array $fields = null): array
    {
        $redis = Redis::getRedis();
        if (null === $redis) {//如果未开启redis  则直接查库
            $value = $this->searchAll($condition, $order, $fields);
            $fields = [];
        } else {
            $key = Redis::getKey($condition);
            if ($value = Redis::getRedis()->get($key)) {
                $value = unserialize($value);
            } else {
                $value = $this->searchAll($condition, $order);
                if (!empty($value)) {
                    Redis::getRedis()->set(serialize($value));
                }
            }
        }
        $info = ArrayHelper::array_filter_fields($value, $fields);

        return $info;
    }
}
