<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\alipay;

class AlipayProvider extends \hdphp\kernel\ServiceProvider {

	//延迟加载
	public $defer = TRUE;

	public function boot() {

	}

	public function register() {
		$this->app->single( 'Alipay', function ( $app ) {
			return new Alipay( $app );
		} );
	}
}