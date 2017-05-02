<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\hook;

use hdphp\kernel\ServiceProvider;

class HookProvider extends ServiceProvider {

	//延迟加载
	public $defer = FALSE;

	public function boot() {
		$this->app['Error']->bootstrap();
	}

	public function register() {
		$this->app->single( 'Hook', function ( $app ) {
			return new Hook( $app );
		}, TRUE );
	}
}