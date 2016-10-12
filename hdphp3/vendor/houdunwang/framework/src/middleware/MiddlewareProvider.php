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
	public    $defer = FALSE;
	protected $instance;

	public function boot( $app ) {
	}

	public function register() {
		$this->app->single( 'Middleware', function ( $app ) {
			return new Middleware( $app );
		}, TRUE );
	}
}