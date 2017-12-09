<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class template extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('template')) {
            $sql
                = <<<sql
CREATE TABLE `hd_template` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '模板名称',
  `title` varchar(200) NOT NULL COMMENT '中文标题',
  `resume` varchar(500) NOT NULL DEFAULT '' COMMENT '模板描述',
  `author` varchar(45) NOT NULL COMMENT '作者',
  `url` varchar(300) NOT NULL COMMENT '发布页URL地址',
  `industry` varchar(45) NOT NULL DEFAULT '' COMMENT '行业类型 hotel(酒店) car(汽车) tour(旅游) real(房地产) medical(医疗) 教育(edu) beauty(美容健身) photography(婚纱摄影) other(其他行业)',
  `position` tinyint(4) unsigned NOT NULL COMMENT '位置 ',
  `is_system` tinyint(1) unsigned NOT NULL COMMENT '系统模板',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '模板缩略图',
  `is_default` tinyint(1) unsigned NOT NULL COMMENT '默认模板',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='站点模板';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}