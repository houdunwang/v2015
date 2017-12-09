<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class package extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('package')) {
            $sql
                = <<<sql
CREATE TABLE `hd_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '套餐名称',
  `modules` varchar(5000) NOT NULL COMMENT '允许使用的套餐',
  `template` varchar(5000) NOT NULL COMMENT '允许使用的模板',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='套餐';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}