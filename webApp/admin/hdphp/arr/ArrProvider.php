<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\arr;

use hdphp\kernel\ServiceProvider;

class ArrProvider extends ServiceProvider {

	//延迟加载
	public $defer = TRUE;

	public function boot() {

	}

	public function register() {
		$this->app->single( 'Arr', function ( $app ) {
			return new Arr( $app );
		} );
	}
}