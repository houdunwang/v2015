<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class navigate extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('navigate')) {
            $sql
                = <<<sql
CREATE TABLE `hd_navigate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
  `module` varchar(100) NOT NULL COMMENT '模块',
  `name` varchar(100) NOT NULL COMMENT '名称',
  `url` varchar(100) NOT NULL COMMENT '链接',
  `css` text NOT NULL COMMENT '样式',
  `status` tinyint(1) NOT NULL COMMENT '状态',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `position` tinyint(4) unsigned NOT NULL COMMENT '位置',
  `orderby` tinyint(4) unsigned NOT NULL COMMENT '排序',
  `icontype` tinyint(3) unsigned NOT NULL COMMENT '图标类型 1字体 2 图片',
  `entry` varchar(10) NOT NULL DEFAULT '' COMMENT 'home 文章系统官网首页导航  profile 手机会员中心导航 member 桌面会员中心导航',
  `groups` varchar(500) NOT NULL DEFAULT '' COMMENT '菜单使用的会员组',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='导航菜单管理表';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}