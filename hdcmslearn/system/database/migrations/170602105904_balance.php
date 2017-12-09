<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class balance extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('balance')) {
            $sql
                = <<<sql
CREATE TABLE `hd_balance` (
  `bid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
  `uid` int(11) NOT NULL COMMENT '会员编号',
  `tid` varchar(80) NOT NULL DEFAULT '' COMMENT '定单号',
  `fee` decimal(10,2) NOT NULL COMMENT '金额',
  `status` tinyint(1) NOT NULL COMMENT '状态 0 等待支付 1 支付成功',
  `createtime` int(10) NOT NULL COMMENT '创建时间',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`bid`),
  KEY `siteid` (`siteid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员余额充值';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}