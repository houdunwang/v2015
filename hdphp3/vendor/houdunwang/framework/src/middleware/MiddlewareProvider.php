<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\middleware;

use hdphp\kernel\ServiceProvider;

class MiddlewareProvider extends ServiceProvider {
	//延迟加载
	public $defer = false;

	public function boot( $app ) {
		//应用开始中间件
		\Middleware::exe( 'app_start' );
	}

	public function register() {
		$this->app->single( 'Middleware', function ( $app ) {
			return new Middleware( $app );
		}, true );
	}

	public function __destruct() {
		//中间件
		\Middleware::exe( 'app_end' );
	}
}