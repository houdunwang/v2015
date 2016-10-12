<?php namespace hdphp\middleware\build;

/**
 * 应用开始执行的中间件
 * Class AppStart
 * @package hdphp\middleware\build
 */
class AppStart {
	//执行中间件
	public function run() {
		//分配表单验证数据
		$errors =\Session::flash( 'validate' );
		\View::with( 'errors', $errors);
		//清除闪存
		\Session::flash( '[del]' );
	}
}