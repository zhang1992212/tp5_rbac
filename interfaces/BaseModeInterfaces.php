<?php

namespace geek1992\tp5_rbac\interfaces;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
interface BaseModeInterfaces
{
    /**
     * 分页查询.
     *
     * @param array      $condition
     * @param array|null $order
     * @param int        $page
     * @param int        $limit
     * @param array|null $fields
     *
     * @return array
     */
    public function search(array $condition = [], ?array $order = null, int $page = 1, int $limit = 10, ?array $fields = null): array;

    /**
     * 获取所有数据.
     *
     * @param array      $condition
     * @param array|null $order
     * @param array|null $fields
     *
     * @return array
     */
    public function searchAll(array $condition = [], ?array $order = null, ?array $fields = null): array;

    /**
     * 通过条件查询1条
     *
     * @param array      $condition
     * @param array|null $order
     * @param array|null $fields
     *
     * @return array
     */
    public function getByCondition(array $condition = [], ?array $order = null, ?array $fields = null): array;

    /**
     * 通过id获取信息
     * @param int $id
     * @param array|null $order
     * @param array|null $fields
     * @return array
     */
    public function getById(int $id, ?array $order = null, ?array $fields = null): array;
}
