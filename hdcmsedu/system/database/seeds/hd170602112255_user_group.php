<?php namespace system\database\seeds;

use houdunwang\database\build\Seeder;
use houdunwang\db\Db;

class hd170602112255_user_group extends Seeder
{
    //执行
    public function up()
    {
        if (Db::table('user_group')->where('id', 1)->get()) {
            return;
        }
        $sql
            = <<<str
INSERT INTO `hd_user_group` (`id`, `name`, `maxsite`, `allfilesize`, `daylimit`, `package`, `system_group`, `router_num`, `middleware_num`)
VALUES
	(1,'体验组',10,0,30,'\"\"',1,100,100);
str;
        Db::execute($sql);
    }

    //回滚
    public function down()
    {

    }
}