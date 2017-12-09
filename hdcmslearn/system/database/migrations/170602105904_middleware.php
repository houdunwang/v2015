<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class middleware extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('middleware')) {
            $sql
                = <<<sql
CREATE TABLE `hd_middleware` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(11) NOT NULL COMMENT '站点编号',
  `module` char(30) NOT NULL COMMENT '模块名称',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '中文描述',
  `name` varchar(500) NOT NULL DEFAULT '' COMMENT '中间件标识',
  `middleware` mediumtext NOT NULL COMMENT '中间件动作处理类',
  `status` tinyint(1) unsigned NOT NULL COMMENT '开启',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`),
  KEY `siteid_module` (`siteid`,`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模块中间件';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}