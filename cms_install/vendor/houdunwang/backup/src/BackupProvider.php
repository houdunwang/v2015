<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace houdunwang\backup;
use houdunwang\framework\build\Provider;


/**
 * 数据库备份服务
 * Class BackupProvider
 * @package hdphp\backup
 * @author  向军 <2300071698@qq.com>
 */
class BackupProvider extends Provider {

	//延迟加载
	public $defer = true;

	public function boot() {
	}

	public function register() {
		$this->app->single( 'Backup', function (  ) {
			return new Backup(  );
		} );
	}
}