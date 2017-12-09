<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class site_quickmenu extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('site_quickmenu')) {
            $sql
                = <<<sql
CREATE TABLE `hd_site_quickmenu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(11) DEFAULT NULL COMMENT '站点编号',
  `data` text COMMENT '模块名称',
  `uid` int(11) DEFAULT NULL COMMENT '会员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台底部站点快捷菜单';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}