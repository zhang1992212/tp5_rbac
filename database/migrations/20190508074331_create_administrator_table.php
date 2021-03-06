<?php

use think\migration\Migrator;

class CreateAdministratorTable extends Migrator
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
        $table = $this->table('admin_administrator');
        $table->addColumn('account', 'string', ['limit' => 200, 'default' => '', 'comment' => '账号'])
            ->addColumn('password', 'string', ['limit' => 200, 'default' => '', 'comment' => '密码'])
            ->addColumn('name', 'string', ['limit' => 200, 'default' => '', 'comment' => '用户名'])
            ->addColumn('is_active', 'integer', ['limit' => 2, 'default' => 0, 'comment' => '类型 0未激活 1已激活'])
            ->addColumn('deleted', 'integer', ['limit' => 2, 'default' => 0, 'comment' => '是否删除'])
            ->addTimestamps()   //默认生成create_time和update_time两个字段
            ->create();
    }

    public function down()
    {
        $this->dropTable('admin_administrator');
    }
}
