<?php

use think\migration\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => '首页',
                'module' => 'index',
                'controller' => 'welcome',
                'action' => 'index',
                'type' => 0,
                'order' => 9999,
            ],
            [
                'id' => 2,
                'name' => '系统管理',
                'module' => '',
                'controller' => '',
                'action' => '',
                'type' => 0,
                'order' => 0,
            ],
            [
                'id' => 3,
                'name' => '用户管理',
                'module' => 'index',
                'controller' => 'administrator',
                'action' => 'index',
                'level' => 2,
                'type' => 0,
                'order' => 0,
                'parent_id' => 2,
            ],
            [
                'id' => 4,
                'name' => '角色管理',
                'module' => 'index',
                'controller' => 'role',
                'action' => 'index',
                'level' => 2,
                'type' => 0,
                'order' => 0,
                'parent_id' => 2,
            ],
            [
                'id' => 5,
                'name' => '菜单管理',
                'module' => 'index',
                'controller' => 'menu',
                'action' => 'index',
                'level' => 2,
                'type' => 0,
                'order' => 0,
                'parent_id' => 2,
            ],
            [
                'id' => 6,
                'name' => '系统日志管理',
                'module' => '',
                'controller' => '',
                'action' => '',
                'type' => 0,
                'order' => 0,
            ],
            [
                'id' => 7,
                'name' => '操作日志管理',
                'module' => 'index',
                'controller' => 'administratorLog',
                'action' => 'index',
                'level' => 2,
                'type' => 0,
                'order' => 0,
                'parent_id' => 6,
            ],
        ];
        $this->table('admin_menu')->insert($data)->save();
    }
}
