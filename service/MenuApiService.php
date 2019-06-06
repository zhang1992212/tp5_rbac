<?php

namespace geek1992\tp5_rbac\service;

use geek1992\tp5_rbac\model\Menu;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class MenuApiService
{
    private $menuModel;

    public function __construct()
    {
        $this->menuModel = new Menu();
    }

    public function insertData($data)
    {
        return $this->menuModel->insertData($data);
    }

    public function getParentList()
    {
        $where['level'] = 1;
        $lists = [['id' => -2, 'name' => '请选择'],['id' => -1, 'name' => '添加主菜单']];
        $list = $this->menuModel->getList($where, '', 'order desc', 'id,name,parent_id,level');
        $list = $this->buildTreeList($list);
        return array_merge($lists,$list);
    }

    public function getTreeList()
    {
        $list = $this->menuModel->getList([], '', 'order desc');
        $list = $this->buildTreeList($list);
        return $list;
    }

    private function buildTreeList($list, $pid = 0)
    {
        if (count($list) == 1) {
            return $list;
        }
        $tree = [];
        foreach ($list as $item) {
            if ($item['parent_id'] == $pid) {
                if ($item['level'] == 2) {
                    $item['name'] = '┣ ━ ' . $item['name'];
                } elseif ($item['level'] == 3) {
                    $item['name'] = '┣ ━━━ ' . $item['name'];
                }
                array_push($tree, $item);
                $tmp = $this->buildTreeList($list, $item['id']);
                if (!empty($tmp)) {
                    $tree = array_merge($tree, $tmp);
                }
            }
        }
        return $tree;
    }
}
