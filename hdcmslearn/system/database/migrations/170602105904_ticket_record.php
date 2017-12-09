<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class ticket_record extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('ticket_record')) {
            $sql
                = <<<sql
CREATE TABLE `hd_ticket_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
  `tid` int(10) unsigned NOT NULL COMMENT '卡券编号',
  `uid` int(11) NOT NULL COMMENT '会员编号',
  `createtime` int(10) NOT NULL COMMENT '兑换卡券时间',
  `usetime` int(10) NOT NULL COMMENT '使用时间',
  `module` varchar(45) NOT NULL COMMENT '使用模块 system 为系统核销',
  `remark` varchar(200) NOT NULL COMMENT '备注',
  `status` tinyint(1) NOT NULL COMMENT '状态 1 未使用 2 使用',
  `manage` int(10) unsigned NOT NULL COMMENT '核销员编号',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`),
  KEY `uid` (`uid`),
  KEY `siteid` (`siteid`),
  KEY `manage` (`manage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='折扣券与代金券使用记录';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}