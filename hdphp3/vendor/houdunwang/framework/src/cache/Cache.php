<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\cache;

/**
 * 缓存处理基类
 * Class Cache
 *
 * @package Hdphp\Cache
 * @author  向军 <2300071698@qq.com>
 */
class Cache {

	//应用
	public $app;

	//连接
	protected $link;

	//更改缓存驱动
	public function driver( $driver = '' ) {
		$driver     = $driver ?: c( 'cache.driver' );
		$driver     = '\hdphp\cache\\' . ucfirst( $driver );
		$this->link = new $driver;
		$this->link->connect();

		return $this;
	}

	public function __call( $method, $params ) {
		$this->link or $this->driver();
		if ( method_exists( $this->link, $method ) ) {
			return call_user_func_array( [ $this->link, $method ], $params );
		} else {
			return $this;
		}
	}

}