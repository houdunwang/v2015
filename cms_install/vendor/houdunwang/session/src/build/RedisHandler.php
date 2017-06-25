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

class RedisHandler implements AbSession {
	use Base;
	/**
	 * Redis连接对象
	 * @access private
	 * @var Object
	 */
	private $redis;

	public function connect() {
		$config      = Config::get( 'session.redis' );
		$this->redis = new \Redis();
		$this->redis->connect( $config['host'], $config['port'] );
		if ( ! empty( $config['password'] ) ) {
			$this->redis->auth( $config['password'] );
		}
		$this->redis->select( (int) $config['database'] );
	}

	//获得
	function read() {
		$data = $this->redis->get( $this->session_id );

		return $data ? json_decode( $data,true ) : [ ];
	}

	//写入
	function write() {
		return $this->redis->set( $this->session_id, json_encode( $this->items ,JSON_UNESCAPED_UNICODE) );
	}

	//垃圾回收
	function gc() {

	}
}
