<?php


namespace geek1992\tp5_rbac\controller;


use geek1992\tp5_rbac\service\MenuApiService;
use think\Request;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Menu extends Base
{
    private $menuApi;
    public function __construct()
    {
        parent::__construct();
        $this->menuApi = new MenuApiService();
    }

    public function index()
    {
        $list = $this->menuApi->getTreeList();
   
        $this->assign('list', $list);
        return $this->myFetch('menu/index');
    }

    public function menu_add(Request $request)
    {
        if ($request->isPost()) {
            $params = $request->post();
            $parent_id = $request->post('parent_id');
            if ($parent_id == -2) {
                return $this->error('请选择父级菜单');
            } elseif($parent_id == -1) {
                $parent_id = 0;
            }
            $params['parent_id'] = $parent_id;
            $id = $this->menuApi->insertData($params);
            if ($id) {
                return $this->success('添加成功');
            } else {
                return $this->error('添加失败');
            }
        }
        $id = $request->get('id', -1, 'int');
        if ($id == -1) {
            $pList = $this->menuApi->getParentList();
        } else {
            $pList = $this->menuApi->getParentInfo($id);
        }
        $this->noNavLayout();
        $this->assign('menu_list', $pList);
        $this->assign('id', $id);
        return $this->myFetch('menu/menu_add');
    }
    
}