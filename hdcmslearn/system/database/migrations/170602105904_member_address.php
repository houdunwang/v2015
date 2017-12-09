<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class member_address extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('member_address')) {
            $sql
                = <<<sql
CREATE TABLE `hd_member_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
  `uid` int(11) NOT NULL COMMENT '用户编号',
  `username` varchar(20) NOT NULL COMMENT '姓名',
  `mobile` varchar(11) NOT NULL COMMENT '手机号',
  `zipcode` varchar(6) NOT NULL COMMENT '邮编',
  `province` varchar(45) NOT NULL COMMENT '省',
  `city` varchar(45) NOT NULL COMMENT '市',
  `district` varchar(45) NOT NULL COMMENT '区/县',
  `address` varchar(45) NOT NULL COMMENT '街道名称',
  `isdefault` tinyint(1) unsigned NOT NULL COMMENT '默认',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员收货地址';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}