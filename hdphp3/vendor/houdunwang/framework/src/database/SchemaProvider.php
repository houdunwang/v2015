<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\database;


use hdphp\kernel\ServiceProvider;

/**
 * Class SchemaProvider
 * @package hdphp\db
 */
class SchemaProvider extends ServiceProvider {
	//延迟加载
	public $defer = FALSE;

	public function boot() {

	}

	public function register() {
		$this->app->bind( 'Schema', function ( $app ) {
			return new Schema( $app );
		}, TRUE );
	}
}