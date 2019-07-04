<?php
/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */

namespace geek1992\tp5_rbac\traits;

use geek1992\tp5_rbac\model\RoleMenu;
use think\Request;
use function tp5auth\auth\controller\menu;

trait Menu
{
    private $menu_fields = ['id', 'name', 'icon', 'module', 'controller', 'action', 'type', 'level', 'order', 'parent_id'];

    /**
     * 系统管理员菜单.
     *
     * @param $isSystemMenu 是否是系统菜单 1是 0否
     *
     * @return string 生成好的html代码
     */
    protected function getSupperMenu($isSystemMenu)
    {
        $menuModel = new \geek1992\tp5_rbac\model\Menu();
        $menu_list = $menuModel->searchAll([], ['order' => 'desc'], $this->menu_fields);
        $menu_tree = $this->menuTreeList($menu_list['data'], 0, $isSystemMenu);
        unset($menu_tree['selected'], $menuModel);

        $menu_tree_html = $this->buildMenuTree($menu_tree, $isSystemMenu);

        return $menu_tree_html;
    }

    /**
     * 根据角色id获取菜单.
     *
     * @param $isSystemMenu
     * @param $role_id
     *
     * @return string
     */
    protected function getCommonMenu($isSystemMenu, $role_id)
    {
        $roleMenuModel = new RoleMenu();
        $menuModel = new \geek1992\tp5_rbac\model\Menu();
        $roleMenu = $roleMenuModel->searchAll(['role_id' => ['in', $role_id]], null, ['menu_id', 'role_id']);
        if (empty($roleMenuArr = $roleMenu['data'])) {
            return '';
        }
        $menuId = array_unique(array_column($roleMenuArr, 'menu_id'));
        $menu_list = $menuModel->searchAll(['id' => ['in', $menuId]], ['order' => 'desc'], $this->menu_fields);
        $menu_tree = $this->menuTreeList($menu_list['data'], 0, $isSystemMenu);
        unset($menu_tree['selected'], $menuModel, $roleMenuModel);

        $menu_tree_html = $this->buildMenuTree($menu_tree, $isSystemMenu);

        return $menu_tree_html;
    }

    private function buildMenuTree($list, $isSystemMenu)
    {
        $html = '';
        if (empty($list)) {
            return $html;
        }
        foreach ($list as $item) {
            if (empty($item['children'])) {
                $html .= '<dl>';
                if (1 === $item['selected']) {
                    $html .= '<dt class="selected current">';
                } else {
                    $html .= '<dt>';
                }
                $html .= '<i class="Hui-iconfont">';
                $html .= $item['icon'];
                $html .= '</i>';
                if (1 === $item['selected']) {
                    $html .= '<li class="current"><a style="padding-left: 0px;" href="'.$item['url'].'" title="'.$item['name'].'">'.$item['name'].'</a></li>';
                } else {
                    $html .= '<a href="'.$item['url'].'" title="'.$item['name'].'">'.$item['name'].'</a>';
                }
                $html .= '</dt></dl>';
                continue;
            }
            $html .= '<dl id="menu-article">';
            if (1 === $item['selected']) {
                $html .= '<dt class="selected">';
            } else {
                $html .= '<dt>';
            }
            $html .= '<i class="Hui-iconfont">';
            $html .= $item['icon'];
            $html .= '</i>';
            $html .= $item['name'];
            $html .= '<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>';

            $html .= '</dt>';
            if (1 === $item['selected']) {
                $html .= '<dd style="display:block">';
            } else {
                $html .= '<dd>';
            }
            $html .= '<ul>';
            if (!empty($item['children'])) {
                foreach ($item['children'] as $i) {
                    if (1 === $i['selected']) {
                        $html .= '<li class="current">';
                    } else {
                        $html .= '<li>';
                    }

                    $html .= '<a href="'.$i['url'].'" title="'.$i['name'].'">'.$i['name'].'</a>';
                    $html .= '</li>';
                }
            }
            $html .= '</ul>';
            $html .= '</dd>';
            $html .= '</dl>';
        }

        return $html;
    }

    private function menuTreeList($list, $pid = 0, $isSystemMenu = '0')
    {
        if (1 === \count($list)) {
            return $list;
        }
        $tree = [];
        $tree['selected'] = 0;
        $request = Request::instance();
        foreach ($list as $item) {
            if ($item['parent_id'] === $pid) {
                $tmp = [];
                $tmp['id'] = $item['id'];
                $tmp['name'] = $item['name'];
                $tmp['icon'] = $item['icon'];
                $tmp['selected'] = 0;
                //系统菜单
                if ('1' === $isSystemMenu && $request->action() === $item['controller'] && $request->param('method') === $item['action']) {
                    $tmp['selected'] = 1;
                    $tree['selected'] = 1;
                }
                //非系统菜单
                if ('0' === $isSystemMenu && $request->module() === $item['module'] && $request->controller() === ucfirst($item['controller']) && $request->action() === $item['action']) {
                    $tmp['selected'] = 1;
                    $tree['selected'] = 1;
                }

                if (0 === $item['type']) { //系统菜单
                    $tmp['url'] = url('index/'.$item['controller'], ['method' => $item['action']]);
                } else {
                    $tmp['url'] = url($item['module'].'/'.$item['controller'].'/'.$item['action']);
                }
                $tmp['type'] = $item['type'];
                $tmp['order'] = $item['order'];
                $tmp['parent_id'] = $item['parent_id'];
                $children = $this->menuTreeList($list, $item['id'], $isSystemMenu);
                if (1 === $children['selected']) {
                    $tmp['selected'] = 1;
                    $tree['selected'] = 1;
                }
                unset($children['selected']);
                $tmp['children'] = $children;
                array_push($tree, $tmp);
            }
        }

        return $tree;
    }
}
