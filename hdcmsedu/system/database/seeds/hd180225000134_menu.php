<?php namespace system\database\seeds;

use houdunwang\database\build\Seeder;
use houdunwang\db\Db;

class hd180225000134_menu extends Seeder
{
    //执行
    public function up()
    {
        Db::table('menu')->where('id', 64)->update(
            [
                'url' => '?s=site/setting/wepay',
            ]
        );
    }

    //回滚
    public function down()
    {

    }
}