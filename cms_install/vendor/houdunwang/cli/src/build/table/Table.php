<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\cli\build\table;

use houdunwang\cli\build\Base;
use houdunwang\config\Config;
use houdunwang\database\Schema;

class Table extends Base
{
    //创建缓存表
    public function cache()
    {
        $table = Config::get('database.prefix').Config::get(
                'cache.mysql.table'
            );
        if (Schema::tableExists(c('cache.mysql.table'))) {
            $this->error('Table already exists');
        }
        $sql
            = <<<sql
CREATE TABLE `{$table}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) DEFAULT NULL,
  `data` mediumtext,
  `create_at` int(10),
  `expire` int(10),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
sql;
        Schema::sql($sql);
    }
}