<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\kernel;

/**
 * 服务抽象类
 */
abstract class ServiceProvider {

	//延迟加载
	public $defer = FALSE;

	//应用程序实例
	protected $app;

	//注册服务
	abstract function register();

	public function __construct( $app ) {
		$this->app = $app;
	}

	public function __call( $method, $args ) {
		if ( $method == 'boot' ) {
			return;
		}
		throw new BadMethodCallException( "$method 方法不存在 " );
	}
}




