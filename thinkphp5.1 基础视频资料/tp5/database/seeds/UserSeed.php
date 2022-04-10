<?php

use think\migration\Seeder;

class UserSeed extends Seeder
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
        //使用db()方法定义往哪个表里填充数据,然后使用insert()方法来设置插入的数据
        db('users')->insert(['username' => '后盾人','password' => md5('admin888'),'nick' => '人人做后盾']);
        db('users')->insert(['username' => '后盾网','password' => md5('admin888')]);
    }
}