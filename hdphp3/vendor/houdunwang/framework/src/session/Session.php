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

//URL处理类
class Session {
	public function __construct() {
		$this->init();
		$driver       = '\hdphp\session\\' . ucfirst( Config::get( 'session.driver' ) ) . 'Handler';
		$this->driver = new $driver();
	}

	/**
	 * session初始
	 */
	private function init() {
		//设置session_name
		session_name( Config::get( 'session.name' ) );

		//session_id的cookie域
		if ( $domain = Config::get( 'session.domain' ) ) {
			ini_set( 'session.cookie_domain', $domain );
		}

	}

	/**
	 * 检测数据是否存在
	 *
	 * @param $name
	 *
	 * @return bool
	 */
	public function has( $name ) {
		return isset( $_SESSION[ $name ] );
	}

	/**
	 * 设置数据
	 *
	 * @param $name
	 * @param $value
	 *
	 * @return mixed
	 */
	public function set( $name, $value ) {
		$tmp =& $_SESSION;
		foreach ( explode( '.', $name ) as $d ) {
			if ( ! isset( $tmp[ $d ] ) ) {
				$tmp[ $d ] = [ ];
			}
			$tmp = &$tmp[ $d ];
		}

		return $tmp = $value;
	}

	/**
	 * 获取指定的session数据
	 *
	 * @param string $name
	 */
	public function get( $name = '' ) {
		$tmp = $_SESSION;
		foreach ( explode( '.', $name ) as $d ) {
			if ( isset( $tmp[ $d ] ) ) {
				$tmp = $tmp[ $d ];
			} else {
				return;
			}
		}

		return $tmp;
	}

	/**
	 * 按名子删除
	 *
	 * @param $name
	 *
	 * @return bool
	 */
	public function del( $name ) {
		if ( isset( $_SESSION[ $name ] ) ) {
			unset( $_SESSION[ $name ] );
		}

		return TRUE;
	}

	/**
	 * 获取所有数据
	 * @return mixed
	 */
	public function all() {
		return $_SESSION;
	}

	/**
	 * 删除所有数据
	 */
	public function flush() {
		session_unset();
		session_destroy();
	}

	/**
	 * 闪存
	 *
	 * @param $name
	 * @param string $value
	 *
	 * @return bool|mixed|void
	 */
	public function flash( $name, $value = '[get]' ) {
		if ( $name == '[del]' ) {
			return $this->del( '_FLASH_' );
		}
		if ( $value == '[get]' ) {
			return $this->get( '_FLASH_.' . $name );
		}

		return $this->set( '_FLASH_.' . $name, $value );
	}

	public function __call( $method, $params ) {
		return call_user_func_array( [ new $this->driver, $method ], $params );
	}
}