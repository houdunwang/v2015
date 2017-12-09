<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class site_setting extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('site_setting')) {
            $sql
                = <<<sql
CREATE TABLE `hd_site_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL,
  `grouplevel` tinyint(1) unsigned NOT NULL COMMENT '会员组变更设置 1 不自动变更   2根据总积分多少自动升降   3 根据总积分多少只升不降',
  `default_template` tinyint(1) unsigned NOT NULL COMMENT '默认网站模板',
  `creditnames` varchar(1000) NOT NULL COMMENT '积分名称',
  `creditbehaviors` varchar(1000) NOT NULL COMMENT '积分策略',
  `welcome` varchar(60) NOT NULL COMMENT '用户添加公众帐号时发送的欢迎信息',
  `default_message` varchar(60) NOT NULL COMMENT '系统不知道该如何回复粉丝的消息时默认发送的内容',
  `smtp` varchar(2000) NOT NULL DEFAULT '' COMMENT '邮件通知',
  `pay` text COMMENT '支付设置',
  `sms` varchar(2000) NOT NULL DEFAULT '' COMMENT '短信通知设置',
  `config` varchar(2000) NOT NULL DEFAULT '' COMMENT '全局设置',
  `register` varchar(2000) NOT NULL DEFAULT '' COMMENT '注册设置',
  `login` varchar(2000) NOT NULL DEFAULT '' COMMENT '登录设置',
  `aliyun` varchar(2000) NOT NULL DEFAULT '' COMMENT '阿里云配置',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='站点设置';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}