<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class module_domain extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('module_domain')) {
            $sql
                = <<<sql
CREATE TABLE `hd_module_domain` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
  `domain` varchar(100) NOT NULL DEFAULT '' COMMENT '域名',
  `module` varchar(50) DEFAULT NULL COMMENT '模块',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模块域名';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}