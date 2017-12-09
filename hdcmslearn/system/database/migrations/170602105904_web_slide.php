<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class web_slide extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('web_slide')) {
            $sql
                = <<<sql
CREATE TABLE `hd_web_slide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `url` varchar(255) NOT NULL COMMENT '链接',
  `thumb` varchar(255) NOT NULL COMMENT '缩略图',
  `displayorder` tinyint(4) unsigned NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='幻灯图片';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}