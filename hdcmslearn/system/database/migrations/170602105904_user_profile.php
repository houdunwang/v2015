<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class user_profile extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('user_profile')) {
            $sql
                = <<<sql
CREATE TABLE `hd_user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `qq` varchar(15) NOT NULL DEFAULT '',
  `realname` varchar(15) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `nickname` varchar(45) NOT NULL DEFAULT '' COMMENT '昵称',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `telephone` varchar(15) NOT NULL DEFAULT '' COMMENT '固定电话',
  `vip` tinyint(3) unsigned NOT NULL COMMENT 'VIP级别',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '邮寄地址',
  `zipcode` varchar(10) NOT NULL DEFAULT '' COMMENT '邮编',
  `alipay` varchar(45) NOT NULL DEFAULT '' COMMENT '阿里帐号',
  `msn` varchar(45) NOT NULL DEFAULT '' COMMENT 'msn帐号',
  `taobao` varchar(45) NOT NULL DEFAULT '' COMMENT '淘宝帐号',
  `email` varchar(45) NOT NULL DEFAULT '' COMMENT '邮箱',
  `site` varchar(45) NOT NULL DEFAULT '' COMMENT '个人站点',
  `nationality` varchar(45) NOT NULL DEFAULT '' COMMENT '国籍',
  `introduce` varchar(200) NOT NULL DEFAULT '' COMMENT '自我介绍',
  `gender` varchar(10) NOT NULL DEFAULT '' COMMENT '性别',
  `graduateschool` varchar(45) NOT NULL DEFAULT '' COMMENT '毕业学校',
  `height` varchar(10) NOT NULL DEFAULT '' COMMENT '身高',
  `weight` varchar(10) NOT NULL DEFAULT '' COMMENT '体重',
  `bloodtype` varchar(5) NOT NULL DEFAULT '' COMMENT '血型',
  `birthyear` smallint(6) NOT NULL COMMENT '出生年',
  `birthmonth` tinyint(3) unsigned NOT NULL COMMENT '出生月',
  `birthday` tinyint(3) unsigned NOT NULL COMMENT '出生日',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户信息表';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}