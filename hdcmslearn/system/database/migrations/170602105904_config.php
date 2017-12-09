<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class config extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('config')) {
            $sql
                = <<<sql
CREATE TABLE `hd_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site` text NOT NULL COMMENT '网站开启/登录等设置',
  `register` text NOT NULL COMMENT '注册配置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统配置';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}