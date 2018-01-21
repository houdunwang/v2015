<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
use houdunwang\db\Db;
class hd170602105904_member_auth extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('member_auth')) {
            $sql
                = <<<sql
CREATE TABLE `hd_member_auth` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `qq` varchar(300) NOT NULL DEFAULT '',
  `wechat` varchar(300) NOT NULL DEFAULT '',
  `weibo` varchar(300) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方帐号登录数据';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}