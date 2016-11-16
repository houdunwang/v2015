<?php namespace hdphp\middleware;
/**
 * 全局中间件
 * Class App
 * @package hdphp\middleware\build
 */
class App {
	//执行中间件
	public function run() {
		//分配表单验证数据
		View::with( 'errors', Session::flash( 'errors' ) );
		//清除闪存
		Session::flash( '[del]' );
	}
}