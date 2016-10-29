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
	public    $defer = true;
	protected $middleware
	                 = [
			//应用开始中间件
			'app_start' => [
				'hdphp\middleware\build\AppStart'
			],
			//应用结束中间件
			'app_end'   => [
				'hdphp\middleware\build\AppEnd'
			]
		];

	public function boot( $app ) {
		//添加应用启动中间件
		$config = array_merge( c( 'middleware.middleware.app_start' ), $this->middleware['app_start'] );
		c( 'middleware.middleware.app_start', array_unique( $config ) );
		//添加应用关闭中间件
		$config = array_merge( c( 'middleware.middleware.app_end' ), $this->middleware['app_end'] );
		c( 'middleware.middleware.app_end', array_unique( $config ) );
	}

	public function register() {
		$this->app->single( 'Middleware', function ( $app ) {
			return new Middleware( $app );
		} );
	}


}