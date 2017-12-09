<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class web_field extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('web_field')) {
            $sql
                = <<<sql
CREATE TABLE `hd_web_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
  `mid` int(10) unsigned NOT NULL COMMENT '模型编号',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '中文名称',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '标识',
  `status` tinyint(1) unsigned NOT NULL COMMENT '开启',
  `options` text NOT NULL COMMENT '选项JSON格式',
  `orderby` tinyint(3) unsigned NOT NULL COMMENT '排序',
  `required` tinyint(1) unsigned NOT NULL COMMENT '必须输入',
  `type` varchar(50) NOT NULL DEFAULT '' COMMENT '字段类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自字义字段参数表';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}