<?php

use think\migration\Seeder;

class RoleSeeder extends Seeder
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
                'name' => '超级管理员',
                'type' => 0,
            ],
            [
                'id' => 2,
                'name' => '系统管理员',
                'type' => 0,
            ]
        ];
        $this->table('admin_role')->insert($data)->save();
    }
}