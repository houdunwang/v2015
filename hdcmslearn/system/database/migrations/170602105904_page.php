<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class page extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('page')) {
            $sql
                = <<<sql
CREATE TABLE `hd_page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
  `title` varchar(150) NOT NULL COMMENT '各称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `params` longtext NOT NULL COMMENT '参数',
  `html` longtext NOT NULL COMMENT 'html页面代码 ',
  `type` char(30) NOT NULL DEFAULT '' COMMENT 'quickmenu快捷导航 profile会员中心',
  `status` tinyint(1) NOT NULL COMMENT '状态',
  `createtime` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='微官网页面(快捷导航/专题页面)';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}