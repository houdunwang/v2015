<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\backup;

use hdphp\kernel\ServiceProvider;

/**
 * 数据库备份服务
 * Class BackupProvider
 * @package hdphp\backup
 * @author  向军 <2300071698@qq.com>
 */
class BackupProvider extends ServiceProvider {

	//延迟加载
	public $defer = TRUE;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Backup', function ( $app ) {
			return new Backup( $app );
		} );
	}
}