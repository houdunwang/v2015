<?php namespace system\service\HdForm;

/** .-------------------------------------------------------------------
* |  Software: [HDPHP framework]
* |      Site: www.hdphp.com
* |-------------------------------------------------------------------
* |    Author: 向军 <2300071698@qq.com>
* |    WeChat: aihoudun
* | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
* '-------------------------------------------------------------------*/

use hdphp\kernel\ServiceProvider;

class HdFormProvider extends ServiceProvider {
	//延迟加载
	public $defer = true;

	//服务运行时自动执行的方法
	public function boot() {
		echo 'boot';
	}

	public function register() {
		$this->app->single( 'HdForm', function ( $app ) {
			return new HdForm($app);
		} );
	}
}