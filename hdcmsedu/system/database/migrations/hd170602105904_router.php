<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
use houdunwang\db\Db;
class hd170602105904_router extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('router')) {
            $sql
                = <<<sql
CREATE TABLE `hd_router` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(11) NOT NULL COMMENT '站点编号',
  `module` char(30) NOT NULL DEFAULT '' COMMENT '模块标识',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '中文描述',
  `router` varchar(500) NOT NULL DEFAULT '' COMMENT '路由规则',
  `url` varchar(300) NOT NULL DEFAULT '' COMMENT '匹配地址',
  `status` tinyint(1) unsigned NOT NULL COMMENT '开启',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  `condition` varchar(300) NOT NULL DEFAULT '' COMMENT '路由条件',
  PRIMARY KEY (`id`),
  KEY `siteid_module` (`siteid`,`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模块路由器设置';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}