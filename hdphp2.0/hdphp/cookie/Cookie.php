<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\cookie;

class Cookie {
	public function get( $name ) {
		if ( isset( $_COOKIE[ $name ] ) ) {
			return unserialize( $_COOKIE[ $name ] );
		}
	}

	public function all() {
		return $_COOKIE;
	}

	public function set( $name, $value, $expire = 0, $path = '/', $domain = NULL ) {
		$expire = $expire ? time() + $expire : $expire;
		setcookie( $name, serialize( $value ), $expire, $path, $domain );
	}

	public function del( $name ) {
		return setcookie( $name, '', 1 );
	}

	public function has( $name ) {
		return isset( $_COOKIE[ $name ] );
	}

	public function flush() {
		foreach ( $_COOKIE as $key => $value ) {
			setcookie( $key, '', 1 );
		}

	}
}