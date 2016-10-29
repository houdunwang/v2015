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
		$this->load();
		date_default_timezone_set( c( 'app.timezone' ) );
		$this->setDatabaseConfig();
	}

	//加载配置文件
	protected function load() {
		foreach ( glob( ROOT_PATH . '/system/config/*' ) as $file ) {
			$info = pathinfo( $file );
			c( $info['filename'], require $file );
		}
	}

	//设置数据库连接配置
	protected function setDatabaseConfig() {
		//加载.env配置
		if ( is_file( '.env' ) ) {
			$config = [ ];
			foreach ( file( '.env' ) as $file ) {
				$data = explode( '=', $file );
				if ( count( $data ) == 2 ) {
					$config[ trim( $data[0] ) ] = trim( $data[1] );
				}
			}
			c( 'database.host', $config['DB_HOST'] );
			c( 'database.user', $config['DB_USER'] );
			c( 'database.password', $config['DB_PASSWORD'] );
			c( 'database.database', $config['DB_DATABASE'] );
		}

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
		c( 'database', $config );
	}

	public function register() {
		$this->app->single( 'Config', function ( $app ) {
			return new Config( $app );
		} );
	}
}