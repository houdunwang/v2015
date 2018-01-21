<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\Schema;
use houdunwang\db\Db;
class hd170603115211_message extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('message')) {
            $sql
                = <<<sql
CREATE TABLE `hd_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `mobile` varchar(100) NOT NULL DEFAULT '' COMMENT '手机号',
  `mail` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `sendtime` int(11) NOT NULL COMMENT '发送时间',
  `data` text NOT NULL COMMENT '数据内容',
  `ip` char(30) NOT NULL DEFAULT '' COMMENT '客户IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {

    }
}