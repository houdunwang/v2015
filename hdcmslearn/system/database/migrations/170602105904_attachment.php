<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class attachment extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('attachment')) {
            $sql
                = <<<sql
CREATE TABLE `hd_attachment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL COMMENT '会员id',
  `siteid` int(11) unsigned NOT NULL COMMENT '站点编号',
  `module` varchar(100) NOT NULL COMMENT '模块标识',
  `name` varchar(80) NOT NULL,
  `filename` varchar(300) NOT NULL COMMENT '文件名',
  `path` varchar(300) NOT NULL COMMENT '相对路径',
  `extension` varchar(10) NOT NULL DEFAULT '' COMMENT '类型',
  `createtime` int(10) unsigned NOT NULL COMMENT '上传时间',
  `size` mediumint(9) NOT NULL COMMENT '文件大小',
  `user_type` char(10) NOT NULL DEFAULT '' COMMENT '用户类型',
  `data` varchar(100) NOT NULL DEFAULT '' COMMENT '辅助信息',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态',
  `content` text NOT NULL COMMENT '扩展数据内容',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `data` (`data`),
  KEY `extension` (`extension`),
  KEY `hash` (`status`),
  KEY `siteid` (`siteid`),
  KEY `module` (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='附件';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}