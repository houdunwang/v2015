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
	public $defer = true;

	public function boot() {
		date_default_timezone_set( c( 'app.timezone' ) );
		//将公共数据库配置合并到 write 与 read 中
		$config = \Config::getExtName( 'database', [ 'write', 'read' ] );
		if ( empty( $config['write'] ) ) {
			$config['write'][] = \Config::getExtName( 'database', [
				'write',
				'read'
			] );
		}
		if ( empty( $config['read'] ) ) {
			$config['read'][] = \Config::getExtName( 'database', [
				'write',
				'read'
			] );
		}
		\Config::set( 'database', $config );
	}

	public function register() {
		$this->app->single( 'Config', function ( $app ) {
			return new Config( $app );
		} );
	}
}