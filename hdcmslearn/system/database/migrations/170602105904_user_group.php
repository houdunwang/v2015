<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;

class user_group extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('user_group')) {
            $sql
                = <<<sql
CREATE TABLE `hd_user_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '' COMMENT '组名',
  `maxsite` int(11) unsigned NOT NULL COMMENT '站点数量',
  `allfilesize` int(10) unsigned NOT NULL COMMENT '允许上传空间大小',
  `daylimit` int(11) unsigned NOT NULL COMMENT '有效期限',
  `package` varchar(2000) NOT NULL DEFAULT '' COMMENT '可使用的公众服务套餐',
  `system_group` tinyint(1) unsigned NOT NULL COMMENT '系统用户组',
  `router_num` int(11) unsigned NOT NULL COMMENT '允许设置路由的数量',
  `middleware_num` int(11) unsigned NOT NULL COMMENT '允许设置中间件的数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员组';
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}