<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\session;

class MemcacheHandler implements AbSession {
	use Base;
	private $memcache;

	public function connect() {
		$options        = Config( 'session.memcache' );
		$this->memcache = new Memcache();
		$this->memcache->connect( $options['host'], $options['port'] );
	}

	//获得
	public function read() {
		$data = $this->memcache->get( $this->session_id );

		return $data ? unserialize( $data ) : [ ];
	}

	//写入
	public function write() {
		return $this->memcache->set( $this->session_id, serialize( $this->items ) );
	}

	//删除
	public function flush() {
		return $this->memcache->delete( $this->session_id );
	}

	//垃圾回收
	public function gc() {
	}
}
