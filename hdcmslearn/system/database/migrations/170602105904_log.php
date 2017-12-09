<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class log extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('log')) {
            $sql
                = <<<sql
CREATE TABLE `hd_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(30) DEFAULT NULL,
  `content` varchar(200) DEFAULT NULL,
  `record_time` int(10) unsigned DEFAULT NULL,
  `siteid` int(11) unsigned DEFAULT NULL,
  `system_module` tinyint(1) DEFAULT NULL,
  `url` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}