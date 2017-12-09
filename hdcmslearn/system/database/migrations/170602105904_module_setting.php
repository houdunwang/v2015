<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class module_setting extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('module_setting')) {
            $sql
                = <<<sql
CREATE TABLE `hd_module_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL COMMENT '站点名称',
  `module` varchar(45) NOT NULL COMMENT '模块名称',
  `status` tinyint(1) NOT NULL COMMENT '状态',
  `config` text NOT NULL COMMENT '配置',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='模块配置';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
        Schema::drop('module_setting');
    }
}