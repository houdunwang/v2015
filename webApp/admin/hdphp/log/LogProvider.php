<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\log;

use hdphp\kernel\ServiceProvider;

class LogProvider extends ServiceProvider {

	//延迟加载
	public $defer = FALSE;

	public function boot() {

	}

	public function register() {
		$this->app->single( 'Log', function ( $app ) {
			return new Log( $app );
		}, TRUE );
	}
}