<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class credits_record extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('credits_record')) {
            $sql
                = <<<sql
CREATE TABLE `hd_credits_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
  `uid` int(11) NOT NULL COMMENT '用户编号',
  `credittype` varchar(45) NOT NULL COMMENT '积分类型',
  `num` decimal(10,2) NOT NULL COMMENT '数量',
  `operator` int(10) unsigned NOT NULL COMMENT '操作者编号',
  `module` varchar(45) NOT NULL COMMENT '模块名',
  `createtime` int(10) NOT NULL COMMENT '创建时间',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`),
  KEY `uid` (`uid`),
  KEY `operator` (`operator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='积分变动记录';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}