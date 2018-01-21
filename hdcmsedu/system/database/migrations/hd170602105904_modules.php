<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
use houdunwang\db\Db;
class hd170602105904_modules extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('modules')) {
            $sql
                = <<<sql
CREATE TABLE `hd_modules` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '英文标识',
  `industry` varchar(45) NOT NULL COMMENT '行业类型 business(主要业务)customer(客户关系)marketing(营销与活动)tools(常用服务与工具)industry(行业解决方案)other(其他)',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '模块名称(中文标题)',
  `version` varchar(45) NOT NULL COMMENT '版本号',
  `resume` varchar(1000) NOT NULL COMMENT '模块简述',
  `detail` varchar(500) NOT NULL DEFAULT '' COMMENT '详细介绍',
  `author` varchar(45) NOT NULL COMMENT '作者',
  `url` varchar(255) NOT NULL COMMENT '发布url',
  `is_system` varchar(45) NOT NULL DEFAULT '' COMMENT '系统模块',
  `subscribes` varchar(500) NOT NULL COMMENT '订阅信息',
  `processors` varchar(500) NOT NULL DEFAULT '' COMMENT '处理消息',
  `setting` tinyint(1) unsigned NOT NULL COMMENT '存在全局设置项',
  `router` tinyint(1) unsigned NOT NULL COMMENT '路由规则',
  `tag` tinyint(1) NOT NULL COMMENT '模版标签功能',
  `rule` tinyint(1) unsigned NOT NULL COMMENT '需要嵌入规则',
  `crontab` tinyint(1) unsigned NOT NULL COMMENT '定时任务',
  `permissions` varchar(5000) NOT NULL DEFAULT '' COMMENT '业务规则权限验证标识',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '模块缩略图',
  `preview` varchar(255) NOT NULL DEFAULT '' COMMENT '模块封面图',
  `locality` tinyint(1) unsigned NOT NULL COMMENT '本地应用',
  `domain` tinyint(1) unsigned NOT NULL COMMENT '域名设置',
  `build` char(30) NOT NULL DEFAULT '' COMMENT '云模块编译时间',
  `middleware` tinyint(1) unsigned NOT NULL COMMENT '中间件',
  PRIMARY KEY (`mid`),
  UNIQUE KEY `name` (`name`),
  KEY `is_system` (`is_system`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='模块列表';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}