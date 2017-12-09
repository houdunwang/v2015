<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class modules_bindings extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('modules_bindings')) {
            $sql
                = <<<sql
CREATE TABLE `hd_modules_bindings` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(45) NOT NULL DEFAULT '' COMMENT '模块名称',
  `entry` varchar(45) NOT NULL DEFAULT '' COMMENT '类型:封面/规则列表/业务',
  `title` varchar(45) NOT NULL DEFAULT '' COMMENT '中文标题',
  `controller` varchar(50) NOT NULL COMMENT '控制器名只对业务导航有效',
  `do` text NOT NULL COMMENT '动作方法',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '自定义菜单的url',
  `icon` varchar(80) NOT NULL DEFAULT '' COMMENT '自定义菜单的图标图标',
  `orderby` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `params` varchar(300) NOT NULL DEFAULT '' COMMENT '参数',
  PRIMARY KEY (`bid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='模块动作';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
        Schema::drop('modules_bindings');
    }
}