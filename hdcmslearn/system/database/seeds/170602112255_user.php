<?php namespace system\database\seeds;

use houdunwang\database\build\Seeder;

class user extends Seeder
{
    //执行
    public function up()
    {
        $sql
            = <<<str
INSERT INTO `hd_user` (`uid`, `groupid`, `username`, `realname`, `password`, `security`, `status`, `regtime`, `regip`, `lasttime`, `lastip`, `starttime`, `endtime`, `qq`, `mobile`, `email`, `mobile_valid`, `email_valid`, `remark`)
VALUES
	(1,0,'admin','','7976a2da71ee36c1a4298867459bf739','588cebdd42',1,1510232999,'121.69.37.186',1511266555,'111.193.186.207',1510232999,1512824999,'','','',0,0,'');
str;
        Db::execute($sql);
    }

    //回滚
    public function down()
    {

    }
}