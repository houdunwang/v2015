<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class cloud extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('cloud')) {
            $sql
                = <<<sql
CREATE TABLE `hd_cloud` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL COMMENT '云帐号用户编号',
  `username` varchar(30) NOT NULL COMMENT '帐号',
  `webname` varchar(200) NOT NULL DEFAULT '' COMMENT '网站名称',
  `secret` varchar(50) NOT NULL DEFAULT '' COMMENT '应用密钥',
  `build` char(30) NOT NULL DEFAULT '' COMMENT '编译版本号',
  `status` tinyint(1) unsigned NOT NULL COMMENT '与云平台绑定状态',
  `version` char(30) DEFAULT NULL COMMENT 'hdcms当前版本号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='云平台数据';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}