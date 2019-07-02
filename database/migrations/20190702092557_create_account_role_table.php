<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateAccountRoleTable extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $table = $this->table('admin_account_role');
        $table->addColumn('role_id', 'integer',array('limit' => 10,'default'=>0,'comment'=>'角色id'))
            ->addColumn('account_id', 'integer',array('limit' => 10,'default'=>0,'comment'=>'账户id'))
            ->addColumn('deleted', 'integer',array('limit' => 2,'default'=>0,'comment'=>'是否删除'))
            ->addTimestamps()   //默认生成create_time和update_time两个字段
            ->create();
    }

    public function down()
    {
        $this->dropTable('admin_account_role');
    }
}
