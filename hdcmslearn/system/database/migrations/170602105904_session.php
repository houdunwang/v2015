<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class session extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('session')) {
            $sql
                = <<<sql
CREATE TABLE `hd_session` (
  `session_id` char(50) NOT NULL DEFAULT '',
  `data` mediumtext COMMENT 'session数据',
  `atime` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`session_id`),
  KEY `atime` (`atime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='SESSION数据表';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}