<?php

use think\migration\Seeder;

class AccountSeeder extends Seeder
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
            'account' => 'admin',
            'password' => md5(111111),
            'name' => 'admin',
            'is_active' => 1
        ];
        $this->table('account')->insert($data)->save();
    }
}