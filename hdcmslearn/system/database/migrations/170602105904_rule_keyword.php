<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class rule_keyword extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('rule_keyword')) {
            $sql
                = <<<sql
CREATE TABLE `hd_rule_keyword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL COMMENT '规则编号',
  `siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
  `content` varchar(200) NOT NULL COMMENT '关键词内容',
  `type` varchar(45) NOT NULL COMMENT '关键词类型 1: 完全匹配  2:包含  3:正则 4:直接托管',
  `rank` tinyint(3) unsigned NOT NULL COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL COMMENT '是否开启',
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`),
  KEY `siteid` (`siteid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='回复规则关键词';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}