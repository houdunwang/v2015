<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\session;

use hdphp\kernel\ServiceProvider;

class SessionProvider extends ServiceProvider {

	//延迟加载
	public $defer = FALSE;

	public function boot() {
		\Session::make();
		//开启session
		session_start();
		//cookie的PHPSESSID过期时间
		$expire = Config::get( 'session.expire' );

		if ( $expire > 0 ) {
			setcookie( session_name(), session_id(), time() + $expire, '/' );
		}
	}

	public function register() {
		$this->app->single( 'Session', function ( $app ) {
			return new Session( $app );
		} );
	}
}