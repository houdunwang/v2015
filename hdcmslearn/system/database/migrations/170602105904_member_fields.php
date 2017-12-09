<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class member_fields extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('member_fields')) {
            $sql
                = <<<sql
CREATE TABLE `hd_member_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
  `field` varchar(45) NOT NULL COMMENT '字段名',
  `title` varchar(45) NOT NULL COMMENT '中文标题',
  `orderby` tinyint(3) unsigned NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '启用',
  `required` tinyint(1) DEFAULT NULL COMMENT '必须填写',
  `showinregister` tinyint(1) DEFAULT NULL COMMENT '注册时显示',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员字段信息中文名称与状态';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}