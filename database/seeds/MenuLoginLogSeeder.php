<?php

use think\migration\Seeder;

class MenuLoginLogSeeder extends Seeder
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
                'id' => 8,
                'name' => '登录日志管理',
                'module' => 'index',
                'controller' => 'loginLog',
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