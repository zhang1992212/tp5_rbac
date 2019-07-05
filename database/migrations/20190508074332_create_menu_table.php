<?php

use think\migration\Migrator;

class CreateMenuTable extends Migrator
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
        $table = $this->table('admin_menu');
        $table->addColumn('name', 'string', ['limit' => 200, 'default' => '', 'comment' => '菜单名称'])
            ->addColumn('icon', 'string', ['limit' => 200, 'default' => '', 'comment' => '图标'])
            ->addColumn('module', 'string', ['limit' => 200, 'default' => '', 'comment' => '模块'])
            ->addColumn('controller', 'string', ['limit' => 200, 'default' => '', 'comment' => '控制器'])
            ->addColumn('action', 'string', ['limit' => 200, 'default' => '', 'comment' => '方法'])
            ->addColumn('type', 'integer', ['limit' => 2, 'default' => 0, 'comment' => '类型 0系统菜单（不允许修改） 1普通菜单'])
            ->addColumn('level', 'integer', ['limit' => 2, 'default' => 1, 'comment' => '等级'])
            ->addColumn('order', 'integer', ['limit' => 2, 'default' => 0, 'comment' => '排序'])
            ->addColumn('parent_id', 'integer', ['limit' => 2, 'default' => 0, 'comment' => '父级ID'])
            ->addColumn('deleted', 'integer', ['limit' => 2, 'default' => 0, 'comment' => '是否删除'])
            ->addTimestamps()   //默认生成create_time和update_time两个字段
            ->create();
    }

    public function down()
    {
        $this->dropTable('admin_menu');
    }
}
