<?php

namespace geek1992\tp5_rbac\model;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Menu extends BaseModel
{
    protected $connection = 'database';
    protected $name = 'admin_menu';

    public function getList($where = [], $limit = '', $order= '')
    {
        $where['deleted'] = 0;

        return parent::getList($where, $limit, $order); // TODO: Change the autogenerated stub
    }
}
