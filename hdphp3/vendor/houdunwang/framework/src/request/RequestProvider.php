<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\request;

use hdphp\kernel\ServiceProvider;

class RequestProvider extends ServiceProvider {
	//延迟加载
	public $defer = true;

	public function boot() {
		define( 'IS_MOBILE', \Request::isMobile() );
	}

	public function register() {
		$this->app->single( 'Request', function ( $app ) {
			return new Request( $app );
		} );
	}
}