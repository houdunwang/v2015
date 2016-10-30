<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\cli;
class Table extends Cli {
	//创建缓存表
	public function cache() {
		$table = c( 'database.prefix' ) . c( 'cache.mysql.table' );
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
		Schema::sql( $sql );
	}
}