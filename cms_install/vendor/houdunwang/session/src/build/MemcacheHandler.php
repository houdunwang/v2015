<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\session\build;

use houdunwang\config\Config;

class MemcacheHandler implements AbSession {
	use Base;
	private $memcache;

	public function connect() {
		$options        = Config::get( 'session.memcache' );
		$this->memcache = new \Memcache();
		$this->memcache->connect( $options['host'], $options['port'] );
	}

	//获得
	public function read() {
		$data = $this->memcache->get( $this->session_id );

		return $data ? json_decode( $data, true ) : [];
	}

	//写入
	public function write() {
		return $this->memcache->set( $this->session_id, json_encode( $this->items, JSON_UNESCAPED_UNICODE ) );
	}

	//垃圾回收
	public function gc() {
	}
}
