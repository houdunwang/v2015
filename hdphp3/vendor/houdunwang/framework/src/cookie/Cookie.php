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

/**
 * Cookie 管理组件
 * Class Cookie
 * @package hdphp\cookie
 */
class Cookie {
	//加密key
	protected $secureKey;

	/**
	 * 设置加密密钥
	 *
	 * @param string $key
	 */
	public function setSecureKey( $key ) {
		$this->secureKey = $key;
	}

	/**
	 * 获取
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function get( $name ) {
		if ( isset( $_COOKIE[ $name ] ) ) {
			return Crypt::decrypt( $_COOKIE[ $name ], $this->secureKey );
		}
	}

	/**
	 * 获取所有
	 * @return array
	 */
	public function all() {
		$data = [ ];
		foreach ( $_COOKIE as $name => $value ) {
			$data[ $name ] = $this->get( $name );
		}

		return $data;
	}

	/**
	 * 设置
	 *
	 * @param string $name 名称
	 * @param mixed $value 值
	 * @param int $expire 过期时间
	 * @param string $path 有效路径
	 * @param null $domain 有效域名
	 */
	public function set( $name, $value, $expire = 0, $path = '/', $domain = null ) {
		$expire = $expire ? time() + $expire : $expire;
		setcookie( $name, Crypt::encrypt( $value, $this->secureKey ), $expire, $path, $domain );
	}

	/**
	 * 删除
	 *
	 * @param string $name 名称
	 *
	 * @return bool
	 */
	public function del( $name ) {
		return setcookie( $name, '', 1 );
	}

	/**
	 * 检测
	 *
	 * @param string $name 名称
	 *
	 * @return bool
	 */
	public function has( $name ) {
		return isset( $_COOKIE[ $name ] );
	}

	/**
	 * 删除所有
	 * @return bool
	 */
	public function flush() {
		foreach ( $_COOKIE as $key => $value ) {
			setcookie( $key, '', 1 );
		}

		return true;
	}
}