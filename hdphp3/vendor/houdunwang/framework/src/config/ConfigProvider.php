<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\config;

use hdphp\kernel\ServiceProvider;

class ConfigProvider extends ServiceProvider {

	//延迟加载
	public $defer = FALSE;

	public function boot() {
		date_default_timezone_set( c( 'app.timezone' ) );
	}

	public function register() {
		$this->app->single( 'Config', function ( $app ) {
			return new Config( $app );
		}, TRUE );
	}
}