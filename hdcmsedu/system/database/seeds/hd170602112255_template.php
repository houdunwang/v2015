<?php namespace system\database\seeds;

use houdunwang\database\build\Seeder;
use houdunwang\db\Db;

class hd170602112255_template extends Seeder
{
    //执行
    public function up()
    {
        if (Db::table('template')->where('tid', 1)->get()) {
            return;
        }
        $sql
            = <<<str
INSERT INTO `hd_template` (`tid`, `name`, `title`, `resume`, `author`, `url`, `industry`, `position`, `is_system`, `thumb`, `is_default`)
VALUES
	(1,'default','默认模板','系统默认模板','hdcms','http://www.hdcms.com','other',10,1,'thumb.jpg',0);
str;
        Db::execute($sql);
    }

    //回滚
    public function down()
    {

    }
}