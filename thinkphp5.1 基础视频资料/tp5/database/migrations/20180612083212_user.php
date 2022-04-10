<?php

use think\migration\Migrator;
use think\migration\db\Column;

class User extends Migrator
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
    public function change()
    {
        //定义表的名称
        $table = $this->table('users',['engine' => 'MyISAM']);
        //给当前表添加字段
//        addColumn()方法第一个参数是字段名称
        //第二个参数是字段的数据类型
        $table->addColumn('username','string',['default' => '后盾人','comment' => '用户名'])->addColumn('password','string',['comment' => '密码'])->addColumn('nick','string',['comment' => '昵称','default' => '幸福小海豚'])->create();
    }
}
