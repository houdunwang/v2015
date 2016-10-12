<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\db\connection;

class Mysql implements DbInterface{
	use Connection;
	/**
	 * pdo连接
	 * @return string
	 */
	public function getDns() {
		return $dns = 'mysql:host=' . $this->config['host'] . ';dbname=' . $this->config['database'];
	}
}