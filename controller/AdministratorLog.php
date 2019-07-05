<?php

namespace geek1992\tp5_rbac\controller;

use think\Request;

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class AdministratorLog extends Base
{
    protected $administratorLogModel;
    protected $administratorModel;

    public function __construct()
    {
        parent::__construct();
        $this->administratorLogModel = new \geek1992\tp5_rbac\model\AdministratorLog();
        $this->administratorModel = new \geek1992\tp5_rbac\model\Administrator();
    }

    public function index()
    {
        return $this->myFetch('administratorLog/index');
    }

    public function getAdministratorLogList(Request $request)
    {
        $start = $request->post('start');
        $length = $request->post('length', '10', 'int');
        $list = $this->administratorLogModel->search([], null, $start, $length);
        if (!empty($list['data'])) {
            foreach ($list['data'] as $key => $item) {
               $administrator = $this->administratorModel->getById($item['admin_id'], null, ['name']);
                $list['data'][$key]['name'] = $administrator['name'] . " 【 {$item['admin_id']} 】";
                $list['data'][$key]['relation'] = json_decode($item['relation'], true);
            }
        }
        $data = [
            'draw' => $request->post('draw'),
            'recordsTotal' => $list['total'],
            'recordsFiltered' => $list['total'],
            'data' => $list['data'],
        ];

        return $data;
    }
}
