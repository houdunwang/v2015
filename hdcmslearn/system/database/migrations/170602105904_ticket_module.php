<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class ticket_module extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('ticket_module')) {
            $sql
                = <<<sql
CREATE TABLE `hd_ticket_module` (
  `tmid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) unsigned NOT NULL COMMENT '券编号',
  `siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
  `module` varchar(100) NOT NULL DEFAULT '' COMMENT '模块名称',
  PRIMARY KEY (`tmid`),
  KEY `tid` (`tid`),
  KEY `siteid` (`siteid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='代金券或优惠券可使用的模块';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}