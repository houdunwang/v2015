<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class site_package extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('site_package')) {
            $sql
                = <<<sql
CREATE TABLE `hd_site_package` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL,
  `package_id` int(10) NOT NULL COMMENT '套餐编号',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='站点可以使用的套餐';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}