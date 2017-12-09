<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class web extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('web')) {
            $sql
                = <<<sql
CREATE TABLE `hd_web` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL COMMENT '站点id',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `template_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模板',
  `site_info` text NOT NULL COMMENT '序列化的数据',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`),
  KEY `template_name` (`template_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='站点表';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}