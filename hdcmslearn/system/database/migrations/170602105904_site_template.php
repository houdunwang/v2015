<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class site_template extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('site_template')) {
            $sql
                = <<<sql
CREATE TABLE `hd_site_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL,
  `template` varchar(45) NOT NULL DEFAULT '' COMMENT '模块名称',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='站点扩展模板';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}