<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
use houdunwang\db\Db;
class hd170602105904_web_model extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('web_model')) {
            $sql
                = <<<sql
CREATE TABLE `hd_web_model` (
  `mid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(11) DEFAULT NULL COMMENT '站点编号',
  `model_title` varchar(100) NOT NULL DEFAULT '' COMMENT '模型名称',
  `model_name` char(10) NOT NULL DEFAULT '' COMMENT '模型表名标识',
  `is_system` tinyint(3) unsigned NOT NULL COMMENT '系统模型',
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模型名称';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}