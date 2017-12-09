<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class site extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('site')) {
            $sql
                = <<<sql
CREATE TABLE `hd_site` (
  `siteid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '站点名称',
  `createtime` int(10) unsigned NOT NULL COMMENT '站点创建时间',
  `description` varchar(300) NOT NULL DEFAULT '' COMMENT '描述',
  `ucenter_template` varchar(50) NOT NULL DEFAULT '' COMMENT '会员中心模板',
  PRIMARY KEY (`siteid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='站点信息';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}