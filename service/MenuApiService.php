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
        if ($data['parent_id'] > 0) {
            $parentInfo = $this->menuModel->getOneInfo(['id' => $data['parent_id']], 'level');
            $data['level'] = $parentInfo['level'] + 1;
        }
        $data['type'] = 1;
        return $this->menuModel->insertData($data);
    }

    public function getParentList()
    {
        $where['level'] = 1;
        $lists = [['id' => -2, 'name' => '请选择'], ['id' => -1, 'name' => '添加主菜单']];
        $list = $this->menuModel->getList($where, '', 'order desc', 'id,name,parent_id,level');
        $list = $this->buildTreeList($list);

        return array_merge($lists, $list);
    }

    public function getParentInfo($id)
    {
        $info = $this->menuModel->getOneInfo(['id' => $id], 'id,name,parent_id,level');

        return $info;
    }

    public function getOneMenuInfo($id)
    {
        $info = $this->menuModel->getOneInfo(['id' => $id]);

        return $info;
    }

    public function getTreeList()
    {
        $list = $this->menuModel->getList([], '', 'order desc');
        $list = $this->buildTreeList($list);

        return $list;
    }

    public function getChildList($is_super = 1, $menu_id = [])
    {
        $list = $this->menuModel->getList([], '', 'order desc');
        $list = $this->buildChildTreeList($list, 0, $is_super, $menu_id);

        return $list;
    }
    private function buildChildTreeList($list, $pid = 0, $is_super=1, $menu_id = [])
    {
        if (1 === \count($list)) {
            return $list;
        }
        $tree = [];
        foreach ($list as $item) {
            $item['checked'] = 0;
            if ($is_super === 1 || in_array($item['id'], $menu_id)) {
                $item['checked'] = 1;
            }
            $item['str'] = '';
            if ($item['parent_id'] === $pid) {
                if (2 === $item['level']) {
                    $item['str'] = '┣ ━ ';
                } elseif (3 === $item['level']) {
                    $item['str'] = '┣ ━━━ ';
                }
                $item['child'] = $this->buildChildTreeList($list, $item['id'], $is_super, $menu_id);
                array_push($tree, $item);
            }
        }

        return $tree;
    }


    public function delData($id)
    {
        $where['id'] = $id;
        $data['deleted'] = 1;
        $res = $this->menuModel->updateData($where, $data);

        return $res;
    }

    public function updateData($id, $data)
    {
        $where['id'] = $id;
        $res = $this->menuModel->updateData($where, $data);

        return $res;
    }

    private function buildTreeList($list, $pid = 0)
    {
        if (1 === \count($list)) {
            return $list;
        }
        $tree = [];
        foreach ($list as $item) {
            $item['str'] = '';
            if ($item['parent_id'] === $pid) {
                if (2 === $item['level']) {
                    $item['str'] = '┣ ━ ';
                } elseif (3 === $item['level']) {
                    $item['str'] = '┣ ━━━ ';
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
