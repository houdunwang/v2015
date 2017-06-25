<?php namespace system\service\{{NAME}};
use houdunwang\framework\build\Provider;

class {{NAME}}Provider extends Provider {
	//延迟加载
	public $defer = true;

	//服务运行时自动执行的方法
	public function boot() {
	}

	public function register() {
		$this->app->single( '{{NAME}}', function ( $app ) {
			return new {{NAME}}($app);
		} );
	}
}