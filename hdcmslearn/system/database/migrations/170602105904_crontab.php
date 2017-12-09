<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class crontab extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('crontab')) {
            $sql
                = <<<sql
CREATE TABLE `hd_crontab` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
  `runtime` int(11) unsigned NOT NULL COMMENT '执行时间任务执行后重置时间',
  `module` varchar(30) NOT NULL DEFAULT '' COMMENT '模块名称',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '任务标题',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '任务描述',
  `action` varchar(1000) NOT NULL DEFAULT '' COMMENT '执行的任务动作',
  PRIMARY KEY (`id`),
  KEY `siteid_module` (`siteid`,`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='定时任务';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}